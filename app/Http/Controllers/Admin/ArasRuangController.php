<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodAras;
use App\Models\KodBlok;
use App\Models\KodRuang;
use App\Models\KemasanRuang;
use App\Models\Da5Record;
use App\Models\Premis;
use App\Models\Blok;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArasRuangController extends Controller
{
    /**
     * Display a listing of the DAK (D.A.5) records.
     */
    public function index(Request $request)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Senarai DAK Borang D.A.5',
            'description'  => 'Pengguna melihat senarai Borang D.A.5 (Daftar Aset Khusus)',
        ]);

        $query = Da5Record::with('premis');

        // Search Filter (No DPA or Nama Premis or Nama Blok)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_dpa', 'LIKE', "%{$search}%")
                  ->orWhere('nama_premis', 'LIKE', "%{$search}%")
                  ->orWhere('nama_blok', 'LIKE', "%{$search}%");
            });
        }

        // Premis Filter
        if ($request->filled('premis_id')) {
            $query->where('nama_premis_id', $request->premis_id);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status_blok', $request->status);
        }

        // Date range filters
        if ($request->filled('tarikh_dari')) {
            $query->whereDate('created_at', '>=', $request->tarikh_dari);
        }
        if ($request->filled('tarikh_hingga')) {
            $query->whereDate('created_at', '<=', $request->tarikh_hingga);
        }

        $records = $query->latest()->paginate(10);

        // Stats calculations
        $totalRecords = Da5Record::count('*');
        $aktifBlok = Da5Record::where('status_blok', '=', 'aktif', 'and')->count('*');
        $tidakAktifBlok = Da5Record::where('status_blok', '=', 'tidak_aktif', 'and')->count('*');
        
        $premisList = Premis::orderBy('nama_premis', 'asc')->get();

        return view('admin.aras-ruang.index', compact(
            'records',
            'totalRecords',
            'aktifBlok',
            'tidakAktifBlok',
            'premisList'
        ));
    }

    /**
     * Show form for creating a new D.A.5 record.
     */
    public function create(Request $request)
    {
        // Tab logic for Aras and Ruang
        $activeTab = $request->get('tab', 'aras');

        // ===== ARAS QUERY =====
        $arasQuery = KodAras::with('blok');
        if ($request->aras_search) {
            $arasQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->aras_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->aras_search . '%');
            });
        }
        if ($request->aras_blok_id) {
            $arasQuery->where('blok_id', $request->aras_blok_id);
        }
        if ($request->aras_status === 'active') {
            $arasQuery->where('is_active', true);
        } elseif ($request->aras_status === 'inactive') {
            $arasQuery->where('is_active', false);
        }
        $arasPaginated = $arasQuery->orderBy('kod')->paginate(10, ['*'], 'aras_page');

        // ===== RUANG QUERY =====
        $ruangQuery = KodRuang::with(['aras.blok', 'latestKemasan']);
        if ($request->ruang_search) {
            $ruangQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->ruang_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->ruang_search . '%');
            });
        }
        if ($request->ruang_aras_id) {
            $ruangQuery->where('aras_id', $request->ruang_aras_id);
        }
        if ($request->ruang_status === 'active') {
            $ruangQuery->where('is_active', true);
        } elseif ($request->ruang_status === 'inactive') {
            $ruangQuery->where('is_active', false);
        }
        $ruangsPaginated = $ruangQuery->orderBy('kod')->paginate(10, ['*'], 'ruang_page');

        // Shared data for Aras and Ruang
        $bloks   = collect(); // Start empty on create, dynamically loaded via AJAX
        $arasAll = collect(); // Start empty on create, dynamically loaded via AJAX
        $premisList = Premis::orderBy('nama_premis', 'asc')->get();

        return view('admin.aras-ruang.create', compact(
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'arasAll',
            'activeTab',
            'premisList'
        ));
    }

    /**
     * Store a newly created D.A.5 record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_dpa' => 'nullable|string',
            'kod_blok' => 'nullable|string',
            'nama_blok' => 'nullable|string',
            'gambar_hadapan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gambar_belakang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('_token');
        
        if ($request->nama_premis_id === 'manual') {
            $data['nama_premis'] = $request->nama_premis_manual;
            $data['nama_premis_id'] = null; // Stored as null when manual input
        } elseif ($request->nama_premis_id) {
            $premis = Premis::find($request->nama_premis_id, ['*']);
            if ($premis) {
                $data['nama_premis'] = $premis->nama_premis;
            }
        }

        // Set default values for checkboxes if not present
        $data['aset_warisan'] = $request->has('aset_warisan') ? 1 : 0;

        // Store images
        if ($request->hasFile('gambar_hadapan')) {
            $data['gambar_hadapan'] = $request->file('gambar_hadapan')->store('gambar_da5', 'public');
        }
        if ($request->hasFile('gambar_belakang')) {
            $data['gambar_belakang'] = $request->file('gambar_belakang')->store('gambar_da5', 'public');
        }

        // Explicitly handle dynamic lists
        $data['kontraktor_list'] = $request->input('kontraktor_list', []);
        $data['juru_perunding_list'] = $request->input('juru_perunding_list', []);
        $data['lukisan_list'] = $request->input('lukisan_list', []);

        $record = Da5Record::create($data);

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Daftar Borang D.A.5 Baru',
            'description'  => 'Pendaftaran D.A.5 Baru untuk Premis: ' . ($record->nama_premis ?? 'Manual') . ', Blok: ' . ($record->nama_blok ?? 'N/A'),
        ]);

        return redirect()->route('admin.aras-ruang.edit', $record->id)
            ->with('success', 'Borang D.A.5 berjaya disimpan. Anda boleh mengurus aras dan ruang sekarang.');
    }

    /**
     * Show form for editing the specified D.A.5 record.
     */
    public function edit(int $id, Request $request)
    {
        $record = Da5Record::findOrFail($id);
        
        // Tab logic for Aras and Ruang
        $activeTab = $request->get('tab', 'aras');

        // ===== ARAS QUERY =====
        $arasQuery = KodAras::with('blok');
        if ($request->aras_search) {
            $arasQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->aras_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->aras_search . '%');
            });
        }
        if ($request->aras_blok_id) {
            $arasQuery->where('blok_id', $request->aras_blok_id);
        }
        if ($request->aras_status === 'active') {
            $arasQuery->where('is_active', true);
        } elseif ($request->aras_status === 'inactive') {
            $arasQuery->where('is_active', false);
        }
        $arasPaginated = $arasQuery->orderBy('kod')->paginate(10, ['*'], 'aras_page');

        // ===== RUANG QUERY =====
        $ruangQuery = KodRuang::with(['aras.blok', 'latestKemasan']);
        if ($request->ruang_search) {
            $ruangQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->ruang_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->ruang_search . '%');
            });
        }
        if ($request->ruang_aras_id) {
            $ruangQuery->where('aras_id', $request->ruang_aras_id);
        }
        if ($request->ruang_status === 'active') {
            $ruangQuery->where('is_active', true);
        } elseif ($request->ruang_status === 'inactive') {
            $ruangQuery->where('is_active', false);
        }
        $ruangsPaginated = $ruangQuery->orderBy('kod')->paginate(10, ['*'], 'ruang_page');

        // Shared data for Aras and Ruang
        $bloks = Blok::where('premis_id', '=', $record->nama_premis_id, 'and')->orderBy('kod_blok_myspata', 'asc')->get();
        $arasAll = KodAras::whereIn('blok_id', $bloks->pluck('id'), 'and', false)->orderBy('kod', 'asc')->get();
        $premisList = Premis::orderBy('nama_premis', 'asc')->get();

        return view('admin.aras-ruang.edit', compact(
            'record',
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'arasAll',
            'activeTab',
            'premisList'
        ));
    }

    /**
     * Display the specified D.A.5 record in read-only mode.
     */
    public function show(int $id, Request $request)
    {
        $record = Da5Record::findOrFail($id);
        
        // Tab logic for Aras and Ruang
        $activeTab = $request->get('tab', 'aras');

        // ===== ARAS QUERY =====
        $arasQuery = KodAras::with('blok');
        
        // Default to this record's block if no filter is applied
        $matchingBlok = KodBlok::where('kod', '=', $record->kod_blok, 'and')->first();
        if ($matchingBlok && !$request->filled('aras_blok_id')) {
            $arasQuery->where('blok_id', $matchingBlok->id);
            $request->merge(['aras_blok_id' => $matchingBlok->id]);
        }

        if ($request->aras_search) {
            $arasQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->aras_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->aras_search . '%');
            });
        }
        if ($request->aras_blok_id) {
            $arasQuery->where('blok_id', $request->aras_blok_id);
        }
        if ($request->aras_status === 'active') {
            $arasQuery->where('is_active', true);
        } elseif ($request->aras_status === 'inactive') {
            $arasQuery->where('is_active', false);
        }
        $arasPaginated = $arasQuery->orderBy('kod')->paginate(10, ['*'], 'aras_page');

        // ===== RUANG QUERY =====
        $ruangQuery = KodRuang::with(['aras.blok', 'latestKemasan']);

        if ($matchingBlok && !$request->filled('ruang_aras_id') && !$request->filled('ruang_search')) {
            $ruangQuery->whereHas('aras', function($q) use ($matchingBlok) {
                $q->where('blok_id', $matchingBlok->id);
            });
        }

        if ($request->ruang_search) {
            $ruangQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->ruang_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->ruang_search . '%');
            });
        }
        if ($request->ruang_aras_id) {
            $ruangQuery->where('aras_id', $request->ruang_aras_id);
        }
        if ($request->ruang_status === 'active') {
            $ruangQuery->where('is_active', true);
        } elseif ($request->ruang_status === 'inactive') {
            $ruangQuery->where('is_active', false);
        }
        $ruangsPaginated = $ruangQuery->orderBy('kod')->paginate(10, ['*'], 'ruang_page');

        // Shared data for Aras and Ruang
        $bloks   = KodBlok::where('is_active', '=', true, 'and')->orderBy('kod', 'asc')->get();
        $arasAll = KodAras::with('blok')->where('is_active', '=', true, 'and')->orderBy('kod', 'asc')->get();
        $premisList = Premis::orderBy('nama_premis', 'asc')->get();

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Butiran Borang D.A.5',
            'description'  => 'Pengguna melihat butiran Borang D.A.5 untuk Premis: ' . ($record->nama_premis ?? 'Manual'),
        ]);

        return view('admin.aras-ruang.show', compact(
            'record',
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'arasAll',
            'activeTab',
            'premisList'
        ));
    }

    /**
     * Update the specified D.A.5 record.
     */
    public function update(Request $request, int $id)
    {
        $record = Da5Record::findOrFail($id);

        $request->validate([
            'no_dpa' => 'nullable|string',
            'kod_blok' => 'nullable|string',
            'nama_blok' => 'nullable|string',
            'gambar_hadapan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gambar_belakang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->nama_premis_id === 'manual') {
            $data['nama_premis'] = $request->nama_premis_manual;
            $data['nama_premis_id'] = null;
        } elseif ($request->nama_premis_id) {
            $premis = Premis::find($request->nama_premis_id, ['*']);
            if ($premis) {
                $data['nama_premis'] = $premis->nama_premis;
            }
        }

        // Set checkboxes
        $data['aset_warisan'] = $request->has('aset_warisan') ? 1 : 0;

        // Image replacement/deletion logic
        if ($request->hasFile('gambar_hadapan')) {
            if ($record->gambar_hadapan && Storage::disk('public')->exists($record->gambar_hadapan)) {
                Storage::disk('public')->delete($record->gambar_hadapan);
            }
            $data['gambar_hadapan'] = $request->file('gambar_hadapan')->store('gambar_da5', 'public');
        } elseif ($request->input('padam_gambar_hadapan')) {
            if ($record->gambar_hadapan && Storage::disk('public')->exists($record->gambar_hadapan)) {
                Storage::disk('public')->delete($record->gambar_hadapan);
            }
            $data['gambar_hadapan'] = null;
        }

        if ($request->hasFile('gambar_belakang')) {
            if ($record->gambar_belakang && Storage::disk('public')->exists($record->gambar_belakang)) {
                Storage::disk('public')->delete($record->gambar_belakang);
            }
            $data['gambar_belakang'] = $request->file('gambar_belakang')->store('gambar_da5', 'public');
        } elseif ($request->input('padam_gambar_belakang')) {
            if ($record->gambar_belakang && Storage::disk('public')->exists($record->gambar_belakang)) {
                Storage::disk('public')->delete($record->gambar_belakang);
            }
            $data['gambar_belakang'] = null;
        }
        
        // Explicitly handle contractor and perunding lists if empty to avoid DB issues
        $data['kontraktor_list'] = $request->input('kontraktor_list', []);
        $data['juru_perunding_list'] = $request->input('juru_perunding_list', []);
        $data['lukisan_list'] = $request->input('lukisan_list', []);

        $record->update($data);

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Kemaskini Borang D.A.5',
            'description'  => 'Kemaskini D.A.5 ID: ' . $record->id . ', Premis: ' . ($record->nama_premis ?? 'Manual'),
        ]);

        return redirect()->route('admin.aras-ruang.edit', $record->id)
            ->with('success', 'Borang D.A.5 berjaya dikemaskini.');
    }

    /**
     * Delete the specified D.A.5 record.
     */
    public function destroy(int $id)
    {
        $record = Da5Record::findOrFail($id);
        
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Padam Borang D.A.5',
            'description'  => 'Padam D.A.5 ID: ' . $record->id . ', Premis: ' . ($record->nama_premis ?? 'Manual'),
        ]);

        // Clean up images from storage
        if ($record->gambar_hadapan && Storage::disk('public')->exists($record->gambar_hadapan)) {
            Storage::disk('public')->delete($record->gambar_hadapan);
        }
        if ($record->gambar_belakang && Storage::disk('public')->exists($record->gambar_belakang)) {
            Storage::disk('public')->delete($record->gambar_belakang);
        }

        $record->delete();

        return redirect()->route('admin.aras-ruang.index')
            ->with('success', 'Borang D.A.5 berjaya dipadam.');
    }

    /**
     * Export PDF — Konfigurasi Aras dan Ruang
     */
    public function exportPdf(int $id, Request $request)
    {
        $record = Da5Record::findOrFail($id);

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Export PDF Borang D.A.5',
            'description'  => 'Pengguna mengeksport PDF Borang D.A.5 ID: ' . $record->id,
        ]);

        // ===== ARAS QUERY (all records, no pagination) =====
        $arasQuery = KodAras::with('blok');
        $arasAll = $arasQuery->orderBy('blok_id')->orderBy('kod')->get();

        // ===== RUANG QUERY (all records, no pagination) =====
        $ruangQuery = KodRuang::with(['aras.blok']);
        $ruangsAll = $ruangQuery->orderBy('aras_id')->orderBy('kod')->get();

        $filterInfo = null;
        $filterArasBlok = null;
        $filterArasStatus = null;
        $filterRuangAras = null;
        $filterRuangStatus = null;

        // Convert the Da5Record into array representation matching the previous $da5_data format
        $da5_data = $record->toArray();

        // Parse date attributes back to string formats to ensure compatibility with view formatting
        if ($record->tarikh_siap_bina) {
            $da5_data['tarikh_siap_bina'] = $record->tarikh_siap_bina->format('Y-m-d');
        }
        if ($record->tarikh_penilaian) {
            $da5_data['tarikh_penilaian'] = $record->tarikh_penilaian->format('Y-m-d');
        }

        // Resolve absolute local storage paths for front and back images for mPDF
        $gambarHadapanPath = null;
        if ($record->gambar_hadapan) {
            $storagePath = storage_path('app/public/' . $record->gambar_hadapan);
            $publicPath = public_path('storage/' . $record->gambar_hadapan);
            if (file_exists($storagePath)) {
                $gambarHadapanPath = $storagePath;
            } elseif (file_exists($publicPath)) {
                $gambarHadapanPath = $publicPath;
            }
        }

        $gambarBelakangPath = null;
        if ($record->gambar_belakang) {
            $storagePath = storage_path('app/public/' . $record->gambar_belakang);
            $publicPath = public_path('storage/' . $record->gambar_belakang);
            if (file_exists($storagePath)) {
                $gambarBelakangPath = $storagePath;
            } elseif (file_exists($publicPath)) {
                $gambarBelakangPath = $publicPath;
            }
        }

        // Generate PDF using mPDF
        $mpdf = new Mpdf([
            'format'        => 'A4',
            'margin_top'    => 15,
            'margin_bottom' => 15,
            'margin_left'   => 15,
            'margin_right'  => 15,
            'default_font'  => 'arial',
        ]);

        $html = view('admin.aras-ruang.pdf', compact(
            'arasAll',
            'ruangsAll',
            'filterInfo',
            'filterArasBlok',
            'filterArasStatus',
            'filterRuangAras',
            'filterRuangStatus',
            'da5_data',
            'gambarHadapanPath',
            'gambarBelakangPath'
        ))->render();

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('DA5-Borang-Pengumpulan-Data.pdf', 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="DA5-Borang-Pengumpulan-Data.pdf"');
    }

    /**
     * Dapatkan maklumat premis berserta blok dan binaan luar untuk AJAX D.A.5
     */
    public function getPremisDetails(int $id)
    {
        $premis = Premis::with(['blok.aras', 'binaanLuar', 'tanah'])->find($id);
        if (!$premis) {
            return response()->json(['error' => 'Premis tidak ditemui'], 404);
        }

        $arasList = [];
        foreach ($premis->blok as $b) {
            foreach ($b->aras as $a) {
                $arasList[] = [
                    'id' => $a->id,
                    'kod' => $a->kod,
                    'nama' => $a->nama,
                    'blok_id' => $b->id,
                    'blok_kod' => $b->kod_blok_myspata,
                    'blok_nama' => $b->nama_blok,
                ];
            }
        }

        $premisArray = $premis->toArray();
        $premisArray['all_aras'] = $arasList;

        return response()->json($premisArray);
    }
}
