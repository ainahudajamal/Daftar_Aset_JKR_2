<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodAras;
use App\Models\Blok;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class ArasController extends Controller
{
    public function index(Request $request)
    {
        // TAMBAH LOG
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Senarai Aras',
            'description'  => 'Pengguna melihat senarai aras',
        ]);

        $query = KodAras::with('blok');

        if ($request->search) {
            $query->where('kod', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->blok_id) {
            $query->where('blok_id', $request->blok_id);
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $aras = $query->orderBy('kod', 'asc')->paginate(12);
        $bloks = Blok::orderBy('kod_blok_myspata', 'asc')->get();

        return view('admin.aras.index', compact('aras', 'bloks'));
    }

    public function create()
    {
        $bloks = Blok::orderBy('kod_blok_myspata', 'asc')->get();
        return view('admin.aras.create', compact('bloks'));
    }

   public function store(Request $request)
{
    $request->validate([
        'blok_id'        => 'nullable|exists:blok,id',
        'binaan_luar_id' => 'nullable|exists:binaan_luar,id',
        'kod'            => 'required|string|max:50',
        'nama'           => 'required|string|max:255',
    ], [
        'kod.required'  => 'Kod aras wajib diisi.',
        'nama.required' => 'Nama aras wajib diisi.',
    ]);

    // Pastikan salah satu (blok_id ATAU binaan_luar_id) mesti dipilih
    if (empty($request->blok_id) && empty($request->binaan_luar_id)) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['blok_id' => 'Sila pilih Blok atau Binaan Luar.']);
    }

    // Semak duplicate kod dalam scope Blok/Binaan Luar yang sama
    $existingQuery = KodAras::where('kod', '=', strtoupper($request->kod), 'and');
    if ($request->blok_id) {
        $existingQuery->where('blok_id', '=', $request->blok_id, 'and');
    } else {
        $existingQuery->where('binaan_luar_id', '=', $request->binaan_luar_id, 'and');
    }
    if ($existingQuery->exists()) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['kod' => 'Kod aras ini telah digunakan untuk pilihan ini.']);
    }

    $aras = KodAras::create([
        'blok_id'        => $request->blok_id ?: null,
        'binaan_luar_id' => $request->binaan_luar_id ?: null,
        'kod'            => strtoupper($request->kod),
        'nama'           => $request->nama,
        'is_active'      => $request->has('is_active'),
    ]);

    session()->push('recent_da5_aras_ids', $aras->id);

    AuditLog::create([
        'user_id'      => Auth::id(),
        'component_id' => null,
        'title'        => 'Tambah Aras',
        'description'  => 'Aras baru ditambah - Kod: ' . $aras->kod . ', Nama: ' . $aras->nama,
    ]);

    return redirect()->back()
        ->with('success', 'Aras berjaya ditambah.')
        ->with('_redirect_tab', $request->input('_redirect_tab', 'aras'));
}

    public function edit(KodAras $aras)
    {
        $bloks = Blok::orderBy('kod_blok_myspata', 'asc')->get();
        return view('admin.aras.edit', compact('aras', 'bloks'));
    }

    public function update(Request $request, KodAras $aras)
    {
        $request->validate([
            'blok_id'        => 'nullable|exists:blok,id',
            'binaan_luar_id' => 'nullable|exists:binaan_luar,id',
            'kod'            => 'required|string|max:50',
            'nama'           => 'required|string|max:255',
        ], [
            'kod.required'  => 'Kod aras wajib diisi.',
            'nama.required' => 'Nama aras wajib diisi.',
        ]);

        if (empty($request->blok_id) && empty($request->binaan_luar_id)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['blok_id' => 'Sila pilih Blok atau Binaan Luar.']);
        }

        $existingQuery = KodAras::where('kod', '=', strtoupper($request->kod), 'and')->where('id', '!=', $aras->id, 'and');
        if ($request->blok_id) {
            $existingQuery->where('blok_id', '=', $request->blok_id, 'and');
        } else {
            $existingQuery->where('binaan_luar_id', '=', $request->binaan_luar_id, 'and');
        }
        if ($existingQuery->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kod' => 'Kod aras ini telah digunakan untuk pilihan ini.']);
        }

        $aras->fill([
            'blok_id'        => $request->blok_id ?: null,
            'binaan_luar_id' => $request->binaan_luar_id ?: null,
            'kod'            => strtoupper($request->kod),
            'nama'           => $request->nama,
            'is_active'      => $request->has('is_active'),
        ]);
        $aras->save();

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Kemaskini Aras',
            'description'  => 'Aras dikemaskini - Kod: ' . $aras->kod . ', Nama: ' . $aras->nama,
        ]);

        return redirect()->back()
            ->with('success', 'Aras berjaya dikemaskini.')
            ->with('_redirect_tab', $request->input('_redirect_tab', 'aras'));
    }

    public function destroy(KodAras $aras)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Padam Aras',
            'description'  => 'Aras dipadam - Kod: ' . $aras->kod . ', Nama: ' . $aras->nama,
        ]);


        KodAras::destroy($aras->id);

        return redirect()->back()
            ->with('success', 'Aras berjaya dipadam.');
    }
}
