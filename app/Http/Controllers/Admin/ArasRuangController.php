<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodAras;
use App\Models\KodBlok;
use App\Models\KodRuang;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Mpdf\Mpdf;
use App\Models\Premis;
use App\Models\Blok;

class ArasRuangController extends Controller
{
    /**
     * Halaman gabungan Konfigurasi Aras dan Ruang
     */
    public function index(Request $request)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Lihat Konfigurasi Aras dan Ruang',
            'description'  => 'Admin melihat halaman gabungan konfigurasi aras dan ruang',
        ]);

        // Determine active tab (default: aras)
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
        $ruangQuery = KodRuang::with(['aras.blok']);

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

        // ===== SHARED DATA =====
        $bloks   = KodBlok::where('is_active', true)->orderBy('kod')->get();
        $arasAll = KodAras::with('blok')->where('is_active', true)->orderBy('kod')->get();
        $da5_data = session('da5_data', []);
        $premisList = Premis::orderBy('nama_premis')->get();

        return view('admin.aras-ruang.index', compact(
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'arasAll',
            'activeTab',
            'da5_data',
            'premisList'
        ));
    }

    /**
     * Export PDF — Konfigurasi Aras dan Ruang
     * Supports the same filter params as index() so users export exactly what they see.
     */
    public function exportPdf(Request $request)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Export PDF Konfigurasi Aras dan Ruang',
            'description'  => 'Admin mengeksport PDF senarai aras dan ruang',
        ]);

        // ===== ARAS QUERY (all records, no pagination) =====
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

        $arasAll = $arasQuery->orderBy('blok_id')->orderBy('kod')->get();

        // ===== RUANG QUERY (all records, no pagination) =====
        $ruangQuery = KodRuang::with(['aras.blok']);

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

        $ruangsAll = $ruangQuery->orderBy('aras_id')->orderBy('kod')->get();

        // ===== Build human-readable filter description =====
        $filterParts = [];
        if ($request->aras_search)   $filterParts[] = 'Carian Aras: "' . $request->aras_search . '"';
        if ($request->ruang_search)  $filterParts[] = 'Carian Ruang: "' . $request->ruang_search . '"';
        if ($request->aras_blok_id) {
            $blok = KodBlok::find($request->aras_blok_id);
            if ($blok) $filterParts[] = 'Blok: ' . $blok->kod . ' - ' . $blok->nama;
        }
        if ($request->ruang_aras_id) {
            $aras = KodAras::find($request->ruang_aras_id);
            if ($aras) $filterParts[] = 'Aras: ' . $aras->kod . ' - ' . $aras->nama;
        }
        if ($request->aras_status)   $filterParts[] = 'Status Aras: ' . ucfirst($request->aras_status);
        if ($request->ruang_status)  $filterParts[] = 'Status Ruang: ' . ucfirst($request->ruang_status);

        $filterInfo      = implode('  |  ', $filterParts) ?: null;
        $filterArasBlok  = $request->aras_blok_id ? (KodBlok::find($request->aras_blok_id)?->kod . ' - ' . KodBlok::find($request->aras_blok_id)?->nama) : null;
        $filterArasStatus  = $request->aras_status  ? ucfirst($request->aras_status)  : null;
        $filterRuangAras   = $request->ruang_aras_id ? (KodAras::find($request->ruang_aras_id)?->kod . ' - ' . KodAras::find($request->ruang_aras_id)?->nama) : null;
        $filterRuangStatus = $request->ruang_status  ? ucfirst($request->ruang_status) : null;

        $da5_data = session('da5_data', []);

        // ===== Generate PDF with mPDF (supports mixed portrait/landscape) =====
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
            'da5_data'
        ))->render();

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('DA5-Borang-Pengumpulan-Data.pdf', 'S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="DA5-Borang-Pengumpulan-Data.pdf"');
    }

    public function saveFormData(Request $request)
    {
        $data = $request->except('_token');
        if ($request->nama_premis_id === 'manual') {
            $data['nama_premis'] = $request->nama_premis_manual;
        } elseif ($request->nama_premis_id) {
            $premis = Premis::find($request->nama_premis_id);
            if ($premis) {
                $data['nama_premis'] = $premis->nama_premis;
            }
        }
        session(['da5_data' => $data]);
        return redirect()->back()->with('success', 'Maklumat D.A.5 berjaya disimpan.');
    }

    public function clearFormData()
    {
        session()->forget('da5_data');
        return redirect()->back()->with('success', 'Maklumat D.A.5 berjaya dipadam.');
    }

    /**
     * Dapatkan maklumat premis berserta blok dan binaan luar untuk AJAX D.A.5
     */
    public function getPremisDetails($id)
    {
        $premis = Premis::with(['blok', 'binaanLuar', 'tanah'])->find($id);
        if (!$premis) {
            return response()->json(['error' => 'Premis tidak ditemui'], 404);
        }
        return response()->json($premis);
    }
}
