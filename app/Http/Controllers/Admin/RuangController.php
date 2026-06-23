<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodRuang;
use App\Models\KodAras;
use App\Models\KemasanRuang;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
    public function index(Request $request)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Lihat Konfigurasi Ruang',
            'description'  => 'Pengguna melihat konfigurasi ruang',
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
    public function store(Request $request)
    {
        $request->validate([
            'kod'          => 'required|string|max:50|unique:kod_ruangs,kod',
            'nama'         => 'required|string|max:255',
            'aras_id'      => 'nullable|exists:kod_aras,id',
            'kod_sub_ruang'=> 'nullable|string|max:50',
            'luas'         => 'nullable|numeric|min:0',
            'tinggi'       => 'nullable|numeric|min:0',
            'fungsi_ruang' => 'nullable|string|max:255',
            'ada_kemasan'  => 'nullable|string|in:ada,tiada',
        ], [
            'aras_id.exists'  => 'Aras tidak sah',
            'kod.required'    => 'Kod ruang wajib diisi.',
            'kod.unique'      => 'Kod ruang ini sudah digunakan.',
            'nama.required'   => 'Nama ruang wajib diisi.',
        ]);

        $ruang = KodRuang::create([
            'aras_id'      => $request->aras_id,
            'kod'          => strtoupper($request->kod),
            'kod_sub_ruang'=> $request->kod_sub_ruang ? strtoupper($request->kod_sub_ruang) : null,
            'nama'         => $request->nama,
            'luas'         => $request->luas,
            'tinggi'       => $request->tinggi,
            'fungsi_ruang' => $request->fungsi_ruang,
            'ada_kemasan'  => $request->ada_kemasan ?? 'tiada',
            'is_active'    => $request->has('is_active'),
        ]);

        // Create Kemasan record if selected
        if ($request->ada_kemasan === 'ada') {
            KemasanRuang::create([
                'ruang_id'        => $ruang->id,
                'blok'            => $request->kemasan_blok,
                'aras'            => $request->kemasan_aras,
                'nama_aras'       => $request->kemasan_nama_aras,
                'kod_ruang'       => $request->kemasan_kod_ruang,
                'kemasan_lantai'  => $request->kemasan_lantai,
                'luas_lantai'     => $request->kemasan_luas_lantai,
                'kemasan_dinding' => $request->kemasan_dinding,
                'luas_dinding'    => $request->kemasan_luas_dinding,
                'kemasan_siling'  => $request->kemasan_siling,
                'luas_siling'     => $request->kemasan_luas_siling,
            ]);
        }

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Tambah Ruang',
            'description'  => 'Ruang baru ditambah - Kod: ' . $ruang->kod . ', Nama: ' . $ruang->nama,
        ]);

        return redirect()->back()
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
            'aras_id'      => 'required|exists:kod_aras,id',
            'kod'          => 'required|string|max:50',
            'nama'         => 'required|string|max:255',
            'kod_sub_ruang'=> 'nullable|string|max:50',
            'luas'         => 'nullable|numeric|min:0',
            'tinggi'       => 'nullable|numeric|min:0',
            'fungsi_ruang' => 'nullable|string|max:255',
            'ada_kemasan'  => 'nullable|string|in:ada,tiada',
        ], [
            'aras_id.required' => 'Sila pilih aras.',
            'aras_id.exists'   => 'Aras tidak sah.',
            'kod.required'     => 'Kod ruang wajib diisi.',
            'nama.required'    => 'Nama ruang wajib diisi.',
        ]);

        $ruang->update([
            'aras_id'      => $request->aras_id,
            'kod'          => strtoupper($request->kod),
            'kod_sub_ruang'=> $request->kod_sub_ruang ? strtoupper($request->kod_sub_ruang) : null,
            'nama'         => $request->nama,
            'luas'         => $request->luas,
            'tinggi'       => $request->tinggi,
            'fungsi_ruang' => $request->fungsi_ruang,
            'ada_kemasan'  => $request->ada_kemasan ?? 'tiada',
            'is_active'    => $request->has('is_active'),
        ]);

        // Create new Kemasan record (preserves history) if selected
        if ($request->ada_kemasan === 'ada') {
            KemasanRuang::create([
                'ruang_id'        => $ruang->id,
                'blok'            => $request->kemasan_blok,
                'aras'            => $request->kemasan_aras,
                'nama_aras'       => $request->kemasan_nama_aras,
                'kod_ruang'       => $request->kemasan_kod_ruang,
                'kemasan_lantai'  => $request->kemasan_lantai,
                'luas_lantai'     => $request->kemasan_luas_lantai,
                'kemasan_dinding' => $request->kemasan_dinding,
                'luas_dinding'    => $request->kemasan_luas_dinding,
                'kemasan_siling'  => $request->kemasan_siling,
                'luas_siling'     => $request->kemasan_luas_siling,
            ]);
        }

        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Kemaskini Ruang',
            'description'  => 'Ruang dikemaskini - Kod: ' . $ruang->kod . ', Nama: ' . $ruang->nama,
        ]);

        return redirect()->back()
            ->with('success', 'Ruang berjaya dikemaskini.');
    }

    public function destroy(KodRuang $ruang)
    {
        AuditLog::create([
            'user_id'      => Auth::id(),
            'component_id' => null,
            'title'        => 'Padam Ruang',
            'description'  => 'Ruang dipadam - Kod: ' . $ruang->kod . ', Nama: ' . $ruang->nama,
        ]);
        $ruang->delete();
        return redirect()->back()
            ->with('success', 'Ruang berjaya dipadam.');
    }
}
