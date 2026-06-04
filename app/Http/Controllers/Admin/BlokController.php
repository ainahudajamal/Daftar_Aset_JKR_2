<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodBlok;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class BlokController extends Controller
{
    public function index(Request $request)
    {
         //  TAMBAH LOG
    AuditLog::create([
        'user_id'      => auth()->id(),
        'component_id' => null,
        'title'        => 'Lihat Konfigurasi Blok',
        'description'  => 'Admin melihat konfigurasi blok',
        ]);

        $query = KodBlok::query();

        if ($request->search) {
            $query->where('kod', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $bloks = $query->orderBy('kod')->paginate(12);

        return view('admin.blok.index', compact('bloks'));
    }

    public function create()
    {
        return view('admin.blok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kod'  => 'required|string|max:50|unique:kod_bloks,kod',
            'nama' => 'required|string|max:255',
        ], [
            'kod.required'  => 'Kod blok wajib diisi.',
            'kod.unique'    => 'Kod blok ini telah digunakan. Sila gunakan kod lain.',
            'nama.required' => 'Nama blok wajib diisi.',
        ]);

        $blok = KodBlok::create([
            'kod'       => strtoupper($request->kod),
            'nama'      => $request->nama,
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Tambah Blok',
            'description'  => 'Blok baru ditambah - Kod: ' . $blok->kod . ', Nama: ' . $blok->nama,
        ]);

        return redirect()->route('admin.blok.index')
            ->with('success', 'Blok berjaya ditambah.');
    }

    public function edit(KodBlok $blok)
    {
        return view('admin.blok.edit', compact('blok'));
    }

    public function update(Request $request, KodBlok $blok)
    {
        $request->validate([
            'kod'  => 'required|string|max:50|unique:kod_bloks,kod,' . $blok->id,
            'nama' => 'required|string|max:255',
        ], [
            'kod.required'  => 'Kod blok wajib diisi.',
            'kod.unique'    => 'Kod blok ini telah digunakan. Sila gunakan kod lain.',
            'nama.required' => 'Nama blok wajib diisi.',
        ]);

        $blok->update([
            'kod'       => strtoupper($request->kod),
            'nama'      => $request->nama,
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Kemaskini Blok',
            'description'  => 'Blok dikemaskini - Kod: ' . $blok->kod . ', Nama: ' . $blok->nama,
        ]);

            return redirect()->route('admin.blok.index')
                ->with('success', 'Blok berjaya dikemaskini.');   
    }

    public function destroy(KodBlok $blok)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Padam Blok',
            'description'  => 'Blok dipadam - Kod: ' . $blok->kod . ', Nama: ' . $blok->nama,
        ]);
        $blok->delete();

        return redirect()->route('admin.blok.index')
            ->with('success', 'Blok berjaya dipadam.');
    }
}
