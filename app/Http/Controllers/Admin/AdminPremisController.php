<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPremisController extends Controller
{
    public function index()
    {
        return view('admin.premis.index');
    }

    public function create()
    {
        return view('admin.premis.create');
    }

    public function show($id)
    {
        return view('admin.premis.show');
    }

    public function edit($id)
    {
        return view('admin.premis.edit');
    }

   public function exportPdf()
{
    $premis = (object)[
        'nama_premis'       => '',
        'alamat_premis'     => '',
        'poskod'            => '',
        'gps_x'             => '',
        'gps_y'             => '',
        'kumpulan_agensi'   => '',
        'kementerian'       => '',
        'jabatan'           => '',
        'negara'            => '',
        'negeri'            => '',
        'daerah'            => '',
        'mukim_bandar'      => '',
        'kategori_premis'   => '',
        'sub_kategori'      => '',
        'jumlah_keluasan'   => '',
        'kos_siap_bina'     => '',
        'kos_tambahan'      => '',
        'kos_keseluruhan'   => '',
        'tarikh_siap_bina'  => '',
        'sumber_pembiayaan' => '',
        'kod_ptj'           => '',
        'nilai_semasa'      => '',
        'tarikh_penilaian'  => '',
        'bil_blok'          => '',
        'bil_binaan_luar'   => '',
        'catatan'           => '',
    ];

    $pdf = Pdf::loadView('admin.premis.pdf', compact('premis'))
        ->setPaper('a4', 'portrait')
        ->setOption('margin_top', 10)
        ->setOption('margin_bottom', 10)
        ->setOption('margin_left', 10)
        ->setOption('margin_right', 10);

    return $pdf->stream('DA3-Premis.pdf');
}
}