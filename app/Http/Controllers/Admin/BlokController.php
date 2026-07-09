<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodBlok;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Mpdf\Mpdf;

use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;



class BlokController extends Controller
{
    public function index(Request $request)
    {
         //  TAMBAH LOG
    AuditLog::create([
        'user_id'      => auth()->id(),
        'component_id' => null,
        'title'        => 'Lihat Konfigurasi Blok',
        'description'  => 'Pengguna melihat konfigurasi blok',
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

        $kodBloks = $query->orderBy('kod')->paginate(12);
return view('admin.blok.list', compact('kodBloks'));
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
    public function exportPdf()
{
    $premis = [
        'nama'   => 'PARLIMEN MALAYSIA',
        'no_dpa' => '11011 01MYS.14004 4.BD0001',
    ];

    $bloks = [
        ['bil' => 1, 'nama' => 'DEWAN PERSIDANGAN', 'fungsi_binaan' => 'DEWAN',   'luas_tapak' => '4,509.26', 'kod_myspata' => 'F'],
        ['bil' => 2, 'nama' => 'BLOK PEJABAT',      'fungsi_binaan' => 'PEJABAT', 'luas_tapak' => '2,100.00', 'kod_myspata' => 'A'],
        ['bil' => 3, 'nama' => 'BLOK STOR',          'fungsi_binaan' => 'STOR',    'luas_tapak' => '850.00',   'kod_myspata' => 'B'],
    ];

    $binaanLuars = [
        ['bil' => 1, 'nama' => 'PAGAR KAWASAN', 'jenis' => 'PAGAR', 'luas_tapak' => '320.00', 'kod_myspata' => 'PG01'],
    ];

    $catatan_blok   = '';
    $catatan_binaan = '';

$mpdf = new Mpdf([

    'margin_top'    => 10,
    'margin_bottom' => 10,
    'margin_left'   => 10,
    'margin_right'  => 10,

    'format'        => 'A4',

    'default_font' => 'fredoka',

    'tempDir'       => storage_path('mpdf/tmp'),

    'fontDir' => array_merge(
        (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'],
        [
            storage_path('fonts')
        ]
    ),

    'fontdata' => array_merge(
        (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'],
        [
            'fredoka' => [
                'R' => 'Fredoka-Regular.ttf',
            ]
        ]
    ),

]);



    $html = view('admin.blok.pdf', compact(
        'premis', 'bloks', 'binaanLuars', 'catatan_blok', 'catatan_binaan'
    ))->render();

    $mpdf->WriteHTML($html);

    return response($mpdf->Output('DA4_Borang_Blok.pdf', 'S'), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="DA4_Borang_Blok.pdf"');
}
}
