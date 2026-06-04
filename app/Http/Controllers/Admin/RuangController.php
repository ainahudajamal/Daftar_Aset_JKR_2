<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodRuang;
use App\Models\KodAras;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Lihat Konfigurasi Ruang',
            'description'  => 'Admin melihat konfigurasi ruang',
        ]);

        $query = KodRuang::with('aras');

        if ($request->search) {
            $query->where('kod', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->aras_id) {
            $query->where('aras_id', $request->aras_id);
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $ruangs = $query->orderBy('kod')->paginate(12);
        $aras = KodAras::where('is_active', true)->orderBy('kod')->get();

        return view('admin.ruang.index', compact('ruangs', 'aras'));
    }

    public function create()
    {
        $aras = KodAras::where('is_active', true)->orderBy('kod')->get();
        return view('admin.ruang.create', compact('aras'));
    }
    //
    public function store(Request $request)
    {
        $request->validate([
            'kod' => 'required|string|max:50|unique:kod_ruangs,kod',
            'nama' => 'required|string|max:255',
            'aras_id' => 'nullable|exists:kod_aras,id',
        ], [
            'aras_id.required' => 'Sila pilih aras',
            'aras_id.exists' => 'Aras tidak sah',
            'kod.required' => 'Kod ruang wajib diisi.',
            'kod.unique' => 'Kod ruang ini sudah digunakan.',
            'nama.required' => 'Nama ruang wajib diisi.',
        ]);

        $ruang = KodRuang::create([
            'aras_id' => $request->aras_id,
            'kod' => strtoupper($request->kod),
            'nama' => $request->nama,
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Tambah Ruang',
            'description'  => 'Ruang baru ditambah - Kod: ' . $ruang->kod . ', Nama: ' . $ruang->nama,
        ]);

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Ruang berjaya ditambahkan.');
    }

    public function edit(KodRuang $ruang)
    {
        $aras = KodAras::where('is_active', true)->orderBy('kod')->get();
        return view('admin.ruang.edit', compact('ruang', 'aras'));
    }

    public function update(Request $request, KodRuang $ruang)
    {
        $request->validate([
            'aras_id' => 'required|exists:kod_aras,id',
            'kod'     => 'required|string|max:50',
            'nama'    => 'required|string|max:255',
        ], [
            'aras_id.required' => 'Sila pilih aras.',
            'aras_id.exists'   => 'Aras tidak sah.',
            'kod.required'     => 'Kod ruang wajib diisi.',
            'nama.required'    => 'Nama ruang wajib diisi.',
        ]);

        $ruang->update([
            'aras_id'   => $request->aras_id,
            'kod'       => strtoupper($request->kod),
            'nama'      => $request->nama,
            'is_active' => $request->has('is_active'),
        ]);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Kemaskini Ruang',
            'description'  => 'Ruang dikemaskini - Kod: ' . $ruang->kod . ', Nama: ' . $ruang->nama,
        ]);

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Ruang berjaya dikemaskini.');
    }

    public function destroy(KodRuang $ruang)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Padam Ruang',
            'description'  => 'Ruang dipadam - Kod: ' . $ruang->kod . ', Nama: ' . $ruang->nama,
        ]);
        $ruang->delete();
        return redirect()->route('admin.ruang.index')
            ->with('success', 'Ruang berjaya dipadam.');
    }
}
