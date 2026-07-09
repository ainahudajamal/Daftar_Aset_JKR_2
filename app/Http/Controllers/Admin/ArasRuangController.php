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
use App\Models\BinaanLuar;
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
        // Reset session if entering create page freshly (not redirecting after add/edit/pagination/tab change)
        if ($request->has('fresh') || (!$request->hasAny(['tab', 'aras_page', 'ruang_page', 'aras_search', 'ruang_search', 'aras_blok_id', 'ruang_aras_id']) && !session()->has('success') && !session()->has('errors'))) {
            session()->forget(['recent_da5_aras_ids', 'recent_da5_ruang_ids']);
        }

        // Tab logic for Aras and Ruang
        $activeTab = $request->get('tab', 'aras');

        // ===== ARAS QUERY =====
        $arasQuery = KodAras::with('blok');
        if ($request->filled('aras_blok_id') && $request->aras_blok_id !== 'all') {
            $arasQuery->where('blok_id', $request->aras_blok_id);
        } elseif (!$request->filled('aras_search')) {
            $arasQuery->whereIn('id', session('recent_da5_aras_ids', []));
        }

        if ($request->filled('aras_search')) {
            $arasQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->aras_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->aras_search . '%');
            });
        }
        $arasPaginated = $arasQuery->latest('id')->paginate(10, ['*'], 'aras_page');

        // ===== RUANG QUERY =====
        $ruangQuery = KodRuang::with(['aras.blok', 'latestKemasan']);
        if ($request->filled('ruang_aras_id') && $request->ruang_aras_id !== 'all') {
            $ruangQuery->where('aras_id', $request->ruang_aras_id);
        } elseif (!$request->filled('ruang_search')) {
            $ruangQuery->whereIn('id', session('recent_da5_ruang_ids', []));
        }

        if ($request->filled('ruang_search')) {
            $ruangQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->ruang_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->ruang_search . '%');
            });
        }
        $ruangsPaginated = $ruangQuery->latest('id')->paginate(10, ['*'], 'ruang_page');

      // Shared data for Aras and Ruang
$bloks   = Blok::orderBy('kod_blok_myspata', 'asc')->get();
$binaanLuars = BinaanLuar::orderBy('kod_binaan_luar_myspata', 'asc')->get();
$arasAll = KodAras::with(['blok', 'binaanLuar'])->orderBy('kod', 'asc')->get();
$premisList = Premis::orderBy('nama_premis', 'asc')->get();

        return view('admin.aras-ruang.create', compact(
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'binaanLuars',
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

        session()->forget(['recent_da5_aras_ids', 'recent_da5_ruang_ids']);

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

        // Filter strictly to this DA5 record's block so old/unrelated data is excluded
        // Filter strictly to this DA5 record's block/binaan luar
        $matchingBlok = null;
        $matchingBinaanLuar = null;

        $kod  = trim((string) $record->kod_blok);
        $nama = trim((string) $record->nama_blok);

        if ($record->nama_premis_id) {
            // 1. First priority: Match exact NAME (nama_blok) against Blok or Binaan Luar
            if ($nama !== '') {
                $matchingBlok = Blok::where('premis_id', $record->nama_premis_id)
                    ->where('nama_blok', $nama)
                    ->first();

                if (!$matchingBlok) {
                    $matchingBinaanLuar = BinaanLuar::where('premis_id', $record->nama_premis_id)
                        ->where('nama_binaan_luar', $nama)
                        ->first();
                }
            }

            // 2. Second priority: Match CONCAT string or full string
            if (!$matchingBlok && !$matchingBinaanLuar && $kod !== '') {
                $matchingBlok = Blok::where('premis_id', $record->nama_premis_id)
                    ->whereRaw("TRIM(CONCAT(IFNULL(kod_blok_myspata,''), ' - ', IFNULL(nama_blok,''))) = ?", [$kod])
                    ->first();

                if (!$matchingBlok) {
                    $matchingBinaanLuar = BinaanLuar::where('premis_id', $record->nama_premis_id)
                        ->whereRaw("TRIM(CONCAT(IFNULL(kod_binaan_luar_myspata,''), ' - ', IFNULL(nama_binaan_luar,''))) = ?", [$kod])
                        ->first();
                }
            }

            // 3. Third priority: Match by kod_blok_myspata ONLY IF nama_blok is empty
            if (!$matchingBlok && !$matchingBinaanLuar && $nama === '' && $kod !== '') {
                $matchingBlok = Blok::where('premis_id', $record->nama_premis_id)
                    ->where('kod_blok_myspata', $kod)
                    ->first();

                if (!$matchingBlok) {
                    $matchingBinaanLuar = BinaanLuar::where('premis_id', $record->nama_premis_id)
                        ->where('kod_binaan_luar_myspata', $kod)
                        ->first();
                }
            }
        }

        // ===== ARAS QUERY =====
        $arasQuery = KodAras::with(['blok', 'binaanLuar']);
        if ($request->filled('aras_blok_id') && $request->aras_blok_id !== 'all') {
            if (str_starts_with($request->aras_blok_id, 'binaan_luar_')) {
                $blId = (int) str_replace('binaan_luar_', '', $request->aras_blok_id);
                $arasQuery->where('binaan_luar_id', $blId);
            } elseif (str_starts_with($request->aras_blok_id, 'blok_')) {
                $bId = (int) str_replace('blok_', '', $request->aras_blok_id);
                $arasQuery->where('blok_id', $bId);
            } else {
                $arasQuery->where('blok_id', $request->aras_blok_id);
            }
        } elseif ($matchingBlok) {
            $arasQuery->where('blok_id', $matchingBlok->id);
        } elseif ($matchingBinaanLuar) {
            $arasQuery->where('binaan_luar_id', $matchingBinaanLuar->id);
        } elseif ($record->nama_premis_id) {
            $premisBlokIds = Blok::where('premis_id', $record->nama_premis_id)->pluck('id');
            $premisBLIds = BinaanLuar::where('premis_id', $record->nama_premis_id)->pluck('id');
            $arasQuery->where(function ($q) use ($premisBlokIds, $premisBLIds) {
                if ($premisBlokIds->isNotEmpty()) {
                    $q->whereIn('blok_id', $premisBlokIds);
                }
                if ($premisBLIds->isNotEmpty()) {
                    $q->orWhereIn('binaan_luar_id', $premisBLIds);
                }
                if ($premisBlokIds->isEmpty() && $premisBLIds->isEmpty()) {
                    $q->whereRaw('1 = 0');
                }
            });
        } else {
            $arasQuery->whereRaw('1 = 0');
        }

        if ($request->filled('aras_search')) {
            $arasQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->aras_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->aras_search . '%');
            });
        }
        if ($request->aras_status === 'active') {
            $arasQuery->where('is_active', true);
        } elseif ($request->aras_status === 'inactive') {
            $arasQuery->where('is_active', false);
        }
        $arasPaginated = $arasQuery->latest('id')->paginate(10, ['*'], 'aras_page');

        // ===== RUANG QUERY =====
        $ruangQuery = KodRuang::with(['aras.blok', 'aras.binaanLuar', 'latestKemasan']);
        if ($request->filled('ruang_aras_id') && $request->ruang_aras_id !== 'all') {
            $ruangQuery->where('aras_id', $request->ruang_aras_id);
        } elseif ($matchingBlok) {
            $ruangQuery->whereHas('aras', function($q) use ($matchingBlok) {
                $q->where('blok_id', $matchingBlok->id);
            });
        } elseif ($matchingBinaanLuar) {
            $ruangQuery->whereHas('aras', function($q) use ($matchingBinaanLuar) {
                $q->where('binaan_luar_id', $matchingBinaanLuar->id);
            });
        } elseif ($record->nama_premis_id) {
            $premisBlokIds = Blok::where('premis_id', $record->nama_premis_id)->pluck('id');
            $premisBLIds = BinaanLuar::where('premis_id', $record->nama_premis_id)->pluck('id');
            $ruangQuery->whereHas('aras', function ($q) use ($premisBlokIds, $premisBLIds) {
                $q->where(function ($sub) use ($premisBlokIds, $premisBLIds) {
                    if ($premisBlokIds->isNotEmpty()) {
                        $sub->whereIn('blok_id', $premisBlokIds);
                    }
                    if ($premisBLIds->isNotEmpty()) {
                        $sub->orWhereIn('binaan_luar_id', $premisBLIds);
                    }
                });
            });
        } else {
            $ruangQuery->whereRaw('1 = 0');
        }

        if ($request->filled('ruang_search')) {
            $ruangQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->ruang_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->ruang_search . '%');
            });
        }
        if ($request->ruang_status === 'active') {
            $ruangQuery->where('is_active', true);
        } elseif ($request->ruang_status === 'inactive') {
            $ruangQuery->where('is_active', false);
        }
        $ruangsPaginated = $ruangQuery->orderBy('kod')->paginate(10, ['*'], 'ruang_page');

        // Shared data for Aras and Ruang
$bloks = Blok::where('premis_id', '=', $record->nama_premis_id, 'and')->orderBy('kod_blok_myspata', 'asc')->get();
$binaanLuars = BinaanLuar::where('premis_id', $record->nama_premis_id)->orderBy('kod_binaan_luar_myspata', 'asc')->get();

if ($matchingBlok) {
    $arasAll = KodAras::where('blok_id', $matchingBlok->id)->orderBy('kod', 'asc')->get();
} elseif ($matchingBinaanLuar) {
    $arasAll = KodAras::where('binaan_luar_id', $matchingBinaanLuar->id)->orderBy('kod', 'asc')->get();
} else {
    $premisBlokIds = $bloks->pluck('id');
    $premisBLIds = $binaanLuars->pluck('id');
    $arasAll = KodAras::where(function ($q) use ($premisBlokIds, $premisBLIds) {
        if ($premisBlokIds->isNotEmpty()) {
            $q->whereIn('blok_id', $premisBlokIds);
        }
        if ($premisBLIds->isNotEmpty()) {
            $q->orWhereIn('binaan_luar_id', $premisBLIds);
        }
    })->orderBy('kod', 'asc')->get();
}
        $premisList = Premis::orderBy('nama_premis', 'asc')->get();

        return view('admin.aras-ruang.edit', compact(
            'record',
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'binaanLuars',
            'arasAll',
            'activeTab',
            'premisList',
            'matchingBlok',
            'matchingBinaanLuar'
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
        
        // Match the Blok for this DA5 record
        $matchingBlok = null;
        $matchingBinaanLuar = null;

        $kod  = trim((string) $record->kod_blok);
        $nama = trim((string) $record->nama_blok);

        if ($record->nama_premis_id) {
            // 1. First priority: Match exact NAME (nama_blok) against Blok or Binaan Luar
            if ($nama !== '') {
                $matchingBlok = Blok::where('premis_id', $record->nama_premis_id)
                    ->where('nama_blok', $nama)
                    ->first();

                if (!$matchingBlok) {
                    $matchingBinaanLuar = BinaanLuar::where('premis_id', $record->nama_premis_id)
                        ->where('nama_binaan_luar', $nama)
                        ->first();
                }
            }

            // 2. Second priority: Match CONCAT string or full string
            if (!$matchingBlok && !$matchingBinaanLuar && $kod !== '') {
                $matchingBlok = Blok::where('premis_id', $record->nama_premis_id)
                    ->whereRaw("TRIM(CONCAT(IFNULL(kod_blok_myspata,''), ' - ', IFNULL(nama_blok,''))) = ?", [$kod])
                    ->first();

                if (!$matchingBlok) {
                    $matchingBinaanLuar = BinaanLuar::where('premis_id', $record->nama_premis_id)
                        ->whereRaw("TRIM(CONCAT(IFNULL(kod_binaan_luar_myspata,''), ' - ', IFNULL(nama_binaan_luar,''))) = ?", [$kod])
                        ->first();
                }
            }

            // 3. Third priority: Match by kod_blok_myspata ONLY IF nama_blok is empty
            if (!$matchingBlok && !$matchingBinaanLuar && $nama === '' && $kod !== '') {
                $matchingBlok = Blok::where('premis_id', $record->nama_premis_id)
                    ->where('kod_blok_myspata', $kod)
                    ->first();

                if (!$matchingBlok) {
                    $matchingBinaanLuar = BinaanLuar::where('premis_id', $record->nama_premis_id)
                        ->where('kod_binaan_luar_myspata', $kod)
                        ->first();
                }
            }
        }

        // ===== ARAS QUERY =====
        $arasQuery = KodAras::with(['blok', 'binaanLuar']);
        if ($request->filled('aras_blok_id') && $request->aras_blok_id !== 'all') {
            if (str_starts_with($request->aras_blok_id, 'binaan_luar_')) {
                $blId = (int) str_replace('binaan_luar_', '', $request->aras_blok_id);
                $arasQuery->where('binaan_luar_id', $blId);
            } elseif (str_starts_with($request->aras_blok_id, 'blok_')) {
                $bId = (int) str_replace('blok_', '', $request->aras_blok_id);
                $arasQuery->where('blok_id', $bId);
            } else {
                $arasQuery->where('blok_id', $request->aras_blok_id);
            }
        } elseif ($matchingBlok) {
            $arasQuery->where('blok_id', $matchingBlok->id);
        } elseif ($matchingBinaanLuar) {
            $arasQuery->where('binaan_luar_id', $matchingBinaanLuar->id);
        } else {
            $arasQuery->whereRaw('1 = 0');
        }

        if ($request->filled('aras_search')) {
            $arasQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->aras_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->aras_search . '%');
            });
        }
        if ($request->aras_status === 'active') {
            $arasQuery->where('is_active', true);
        } elseif ($request->aras_status === 'inactive') {
            $arasQuery->where('is_active', false);
        }
        $arasPaginated = $arasQuery->orderBy('kod')->paginate(10, ['*'], 'aras_page');

        // ===== RUANG QUERY =====
        $ruangQuery = KodRuang::with(['aras.blok', 'aras.binaanLuar', 'latestKemasan']);
        if ($request->filled('ruang_aras_id') && $request->ruang_aras_id !== 'all') {
            $ruangQuery->where('aras_id', $request->ruang_aras_id);
        } elseif ($matchingBlok) {
            $ruangQuery->whereHas('aras', function($q) use ($matchingBlok) {
                $q->where('blok_id', $matchingBlok->id);
            });
        } elseif ($matchingBinaanLuar) {
            $ruangQuery->whereHas('aras', function($q) use ($matchingBinaanLuar) {
                $q->where('binaan_luar_id', $matchingBinaanLuar->id);
            });
        } else {
            $ruangQuery->whereRaw('1 = 0');
        }

        if ($request->filled('ruang_search')) {
            $ruangQuery->where(function ($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->ruang_search . '%')
                  ->orWhere('nama', 'like', '%' . $request->ruang_search . '%');
            });
        }
        if ($request->ruang_status === 'active') {
            $ruangQuery->where('is_active', true);
        } elseif ($request->ruang_status === 'inactive') {
            $ruangQuery->where('is_active', false);
        }
        $ruangsPaginated = $ruangQuery->orderBy('kod')->paginate(10, ['*'], 'ruang_page');

        // Shared data for Aras and Ruang
        $bloks = Blok::where('premis_id', $record->nama_premis_id)->orderBy('kod_blok_myspata', 'asc')->get();
        $binaanLuars = BinaanLuar::where('premis_id', $record->nama_premis_id)->orderBy('kod_binaan_luar_myspata', 'asc')->get();

        if ($matchingBlok) {
            $arasAll = KodAras::where('blok_id', $matchingBlok->id)->orderBy('kod', 'asc')->get();
        } elseif ($matchingBinaanLuar) {
            $arasAll = KodAras::where('binaan_luar_id', $matchingBinaanLuar->id)->orderBy('kod', 'asc')->get();
        } else {
            $premisBlokIds = $bloks->pluck('id');
            $premisBLIds = $binaanLuars->pluck('id');
            $arasAll = KodAras::where(function ($q) use ($premisBlokIds, $premisBLIds) {
                if ($premisBlokIds->isNotEmpty()) {
                    $q->whereIn('blok_id', $premisBlokIds);
                }
                if ($premisBLIds->isNotEmpty()) {
                    $q->orWhereIn('binaan_luar_id', $premisBLIds);
                }
            })->orderBy('kod', 'asc')->get();
        }
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
            'binaanLuars',
            'arasAll',
            'activeTab',
            'premisList',
            'matchingBlok',
            'matchingBinaanLuar'
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
            'tempDir'       => storage_path('mpdf/tmp'),
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
        $premis = Premis::with(['blok.aras', 'binaanLuar.aras', 'tanah'])->find($id);
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
        foreach ($premis->binaanLuar as $bl) {
            foreach ($bl->aras as $a) {
                $arasList[] = [
                    'id' => $a->id,
                    'kod' => $a->kod,
                    'nama' => $a->nama,
                    'binaan_luar_id' => $bl->id,
                    'blok_kod' => $bl->kod_binaan_luar_myspata,
                    'blok_nama' => $bl->nama_binaan_luar,
                ];
            }
        }

        $premisArray = $premis->toArray();
        $premisArray['all_aras'] = $arasList;

        return response()->json($premisArray);
    }
}
