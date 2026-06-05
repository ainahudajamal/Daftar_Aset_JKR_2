<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodAras;
use App\Models\KodBlok;
use App\Models\KodRuang;
use Illuminate\Http\Request;
use App\Models\AuditLog;

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

        return view('admin.aras-ruang.index', compact(
            'arasPaginated',
            'ruangsPaginated',
            'bloks',
            'arasAll',
            'activeTab'
        ));
    }
}
