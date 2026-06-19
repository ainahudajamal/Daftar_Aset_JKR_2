<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodAras;
use App\Models\KodBlok;
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
            'description'  => 'Admin melihat senarai aras',
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

        $aras = $query->orderBy('kod')->paginate(12);
        $bloks = KodBlok::where('is_active', true)->orderBy('kod')->get();

        return view('admin.aras.index', compact('aras', 'bloks'));
    }

    public function create()
    {
        $bloks = KodBlok::where('is_active', true)->orderBy('kod')->get();
        return view('admin.aras.create', compact('bloks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'blok_id' => 'required|exists:kod_bloks,id',
            'kod'     => 'required|string|max:50|unique:kod_aras,kod,NULL,id,blok_id,' . $request->blok_id,
            'nama'    => 'required|string|max:255',
        ], [
            'blok_id.required' => 'Sila pilih blok.',
            'blok_id.exists'   => 'Blok tidak sah.',
            'kod.required'     => 'Kod aras wajib diisi.',
            'kod.unique'       => 'Kod aras ini telah digunakan untuk blok ini.',
            'nama.required'    => 'Nama aras wajib diisi.',
        ]);

        $aras = KodAras::create([
            'blok_id'   => $request->blok_id,
            'kod'       => strtoupper($request->kod),
            'nama'      => $request->nama,
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Tambah Aras',
            'description'  => 'Aras baru ditambah - Kod: ' . $aras->kod . ', Nama: ' . $aras->nama,
        ]);

        return redirect()->back()
            ->with('success', 'Aras berjaya ditambah.');
    }

    public function edit(KodAras $aras)
    {
        $bloks = KodBlok::where('is_active', true)->orderBy('kod')->get();
        return view('admin.aras.edit', compact('aras', 'bloks'));
    }

    public function update(Request $request, KodAras $aras)
    {
        $request->validate([
            'blok_id' => 'required|exists:kod_bloks,id',
            'kod'     => 'required|string|max:50|unique:kod_aras,kod,' . $aras->id . ',id,blok_id,' . $request->blok_id,
            'nama'    => 'required|string|max:255',
        ], [
            'blok_id.required' => 'Sila pilih blok.',
            'blok_id.exists'   => 'Blok tidak sah.',
            'kod.required'     => 'Kod aras wajib diisi.',
            'kod.unique'       => 'Kod aras ini telah digunakan untuk blok ini.',
            'nama.required'    => 'Nama aras wajib diisi.',
        ]);

        $aras->update([
            'blok_id'   => $request->blok_id,
            'kod'       => strtoupper($request->kod),
            'nama'      => $request->nama,
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Kemaskini Aras',
            'description'  => 'Aras dikemaskini - Kod: ' . $aras->kod . ', Nama: ' . $aras->nama,
        ]);

        return redirect()->back()
            ->with('success', 'Aras berjaya dikemaskini.');
    }

    public function destroy(KodAras $aras)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Padam Aras',
            'description'  => 'Aras dipadam - Kod: ' . $aras->kod . ', Nama: ' . $aras->nama,
        ]);


        $aras->delete();

        return redirect()->back()
            ->with('success', 'Aras berjaya dipadam.');
    }
}
