<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\BinaanLuar;
use App\Models\Premis;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BlokPremisController extends Controller
{
    public function index(Request $request)
    {
        $query = Premis::with(['blok', 'binaanLuar'])
            ->where(function ($q) {
                $q->whereHas('blok')
                  ->orWhereHas('binaanLuar');
            });

        // 1. Filter Carian
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($subQ) use ($search) {
                $subQ->where('nama_premis', 'LIKE', "%{$search}%")
                     ->orWhere('no_dpa', 'LIKE', "%{$search}%");
            });
        });

        // Filter Pilihan Premis
        $query->when($request->filled('premis_id'), function ($q) use ($request) {
            $q->where('id', $request->premis_id);
        });

        // 2. Filter Negeri
        $query->when($request->filled('negeri'), function ($q) use ($request) {
            $q->where('negeri', $request->negeri);
        });

        // 3. Filter Status
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status_premis', $request->status);
        });

        $bloks = $query->latest()->paginate(10);

        // --- PENGIRAAN STATISTIK D.A.4 ---
        // Kira jumlah premis yang HANYA mempunyai blok atau binaan luar (D.A.4)
        $totalPremisDa4 = Premis::has('blok')->orHas('binaanLuar')->count();
        
        // Kira keseluruhan rekod dari table Blok dan BinaanLuar
        $totalBlok = Blok::count();
        $totalBinaanLuar = BinaanLuar::count();

        return view('admin.blok.index', compact('bloks', 'totalPremisDa4', 'totalBlok', 'totalBinaanLuar'));
    }
    public function create()
    {
        $premis = Premis::all();
        return view('admin.blok.create', compact('premis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'premis_id' => 'required|exists:premis,id',
        ]);

        if ($request->has('blok')) {
            foreach ($request->blok as $blok) {
                if (!empty($blok['nama_blok'])) {
                    Blok::create([
                        'premis_id'        => $request->premis_id,
                        'bil'              => $blok['bil'] ?? null,
                        'nama_blok'        => $blok['nama_blok'],
                        'fungsi_binaan'    => $blok['fungsi_binaan'] ?? null,
                        'luas_tapak'       => $blok['luas_tapak'] ?? null,
                        'kod_blok_myspata' => $blok['kod_blok_myspata'] ?? null,
                        'catatan'          => $blok['catatan'] ?? null,
                    ]);
                }
            }
        }

        if ($request->has('binaan_luar')) {
            foreach ($request->binaan_luar as $binaan) {
                if (!empty($binaan['nama_binaan_luar'])) {
                    BinaanLuar::create([
                        'premis_id'              => $request->premis_id,
                        'bil'                    => $binaan['bil'] ?? null,
                        'nama_binaan_luar'        => $binaan['nama_binaan_luar'],
                        'jenis_binaan_luar'       => $binaan['jenis_binaan_luar'] ?? null,
                        'luas_tapak'             => $binaan['luas_tapak'] ?? null,
                        'kod_binaan_luar_myspata' => $binaan['kod_binaan_luar_myspata'] ?? null,
                        'catatan'                => $binaan['catatan'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.blok.index')
            ->with('success', 'Data DA4 berjaya disimpan.');
    }

    public function show($id)
    {
        $premis = Premis::with(['blok', 'binaanLuar'])->findOrFail($id);
        return view('admin.blok.show', compact('premis'));
    }

    public function edit($id)
    {
        $premis = Premis::with(['blok', 'binaanLuar'])->findOrFail($id);
        $allPremis = Premis::all();
        return view('admin.blok.edit', compact('premis', 'allPremis'));
    }

    public function update(Request $request, $id)
    {
        $premis = Premis::findOrFail($id);

        $premis->blok()->delete();
        if ($request->has('blok')) {
            foreach ($request->blok as $blok) {
                if (!empty($blok['nama_blok'])) {
                    Blok::create([
                        'premis_id'        => $premis->id,
                        'bil'              => $blok['bil'] ?? null,
                        'nama_blok'        => $blok['nama_blok'],
                        'fungsi_binaan'    => $blok['fungsi_binaan'] ?? null,
                        'luas_tapak'       => $blok['luas_tapak'] ?? null,
                        'kod_blok_myspata' => $blok['kod_blok_myspata'] ?? null,
                        'catatan'          => $blok['catatan'] ?? null,
                    ]);
                }
            }
        }

        $premis->binaanLuar()->delete();
        if ($request->has('binaan_luar')) {
            foreach ($request->binaan_luar as $binaan) {
                if (!empty($binaan['nama_binaan_luar'])) {
                    BinaanLuar::create([
                        'premis_id'              => $premis->id,
                        'bil'                    => $binaan['bil'] ?? null,
                        'nama_binaan_luar'        => $binaan['nama_binaan_luar'],
                        'jenis_binaan_luar'       => $binaan['jenis_binaan_luar'] ?? null,
                        'luas_tapak'             => $binaan['luas_tapak'] ?? null,
                        'kod_binaan_luar_myspata' => $binaan['kod_binaan_luar_myspata'] ?? null,
                        'catatan'                => $binaan['catatan'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.blok.index')
            ->with('success', 'Data DA4 berjaya dikemaskini.');
    }

    public function destroy($id)
    {
        $premis = Premis::findOrFail($id);
        $premis->blok()->delete();
        $premis->binaanLuar()->delete();

        return redirect()->route('admin.blok.index')
            ->with('success', 'Data DA4 berjaya dipadam.');
    }

    public function exportPdf($id)
    {
        $premis = Premis::with(['blok', 'binaanLuar'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.blok.pdf', compact('premis'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin_top', 10)
            ->setOption('margin_bottom', 10)
            ->setOption('margin_left', 10)
            ->setOption('margin_right', 10);

        return $pdf->stream('DA4-Blok-' . $premis->nama_premis . '.pdf');
    }
}