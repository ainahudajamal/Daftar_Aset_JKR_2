<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PDF Premis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px 20px;
            color: #000;
        }

        .page {
            width: 100%;
        }

        .page-number {
            border: 1px solid black;
            width: 80px;
            padding: 5px;
            font-style: italic;
            font-size: 11px;
            float: right;
            text-align: center;
        }

        .top-title {
            text-align: right;
            font-weight: bold;
            font-size: 12px;
            margin-top: 30px;
        }

        .main-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 25px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .no-border td {
            border: none;
            vertical-align: middle;
            padding: 4px 2px;
        }

        .label {
            width: 110px;
            font-weight: bold;
            text-align: left;
            padding-right: 5px;
            white-space: nowrap;
        }

        .colon {
            width: 10px;
            text-align: center;
        }

        .input-box {
            border: 1px solid #000;
            height: 20px;
            width: 100%;
            box-sizing: border-box;
            padding-left: 5px;
            line-height: 20px;
            display: block;
        }

        .line-box {
            border-bottom: 1px solid black;
            height: 16px;
            width: 100%;
        }

        .small-box {
            border: 1px solid black;
            width: 15px;
            height: 15px;
            display: inline-block;
            vertical-align: middle;
        }

        .dpa-box {
            border: 1px solid black;
            width: 18px;
            height: 18px;
            display: inline-block;
            margin-right: -1px;
        }

        .signature-box {
            border: 1px solid black;
            height: 35px;
            width: 100%;
        }

        .note {
            font-style: italic;
            font-size: 10px;
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
        }

        .table-bordered th {
            font-weight: bold;
            background-color: #d9d9d9;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <div class="page">

        <div class="page-number">helaian 1</div>
        <div style="clear: both;"></div>

        <div class="top-title">D.A.3 (JKR.PATA.F6/8a rev.2)</div>
        <div class="main-title">KAD PENDAFTARAN ASET TAK ALIH (PREMIS HAK MILIK)</div>

        <table class="no-border">
            <tr>
                <td class="label">Nama Premis</td>
                <td class="colon">:</td>
                <td>
                    <div class="input-box">{!! $premis->nama_premis ?? '&nbsp;' !!}</div>
                </td>
            </tr>
            <tr>
                <td class="label">Alamat Premis</td>
                <td class="colon">:</td>
                <td>
                    <div class="input-box">{!! $premis->alamat_premis ?? '&nbsp;' !!}</div>
                </td>
            </tr>
        </table>

        <table class="no-border" style="margin-top: 2px;">
            <tr>
                <td class="label">Poskod</td>
                <td class="colon">:</td>
                <td width="150px">
                    <div class="input-box">{{ $premis->poskod ?? '' }}</div>
                </td>
                <td style="font-weight:bold; text-align:right; white-space:nowrap; width:130px;">Koordinat GPS : X :</td>
                <td width="100px">
                    <div class="input-box">{{ $premis->koordinat_x ?? '' }}</div>
                </td>
                <td style="font-weight:bold; text-align:center; width:30px;">; Y :</td>
                <td width="100px">
                    <div class="input-box">{{ $premis->koordinat_y ?? '' }}</div>
                </td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td width="48%" valign="top">
                    <table class="no-border">
                        <tr>
                            <td class="label">Kumpulan Agensi</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->kumpulan_agensi ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Kementerian</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->kementerian ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Jabatan</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->jabatan ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Negara</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->negara ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Negeri</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->negeri ?? '' }}</div></td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td width="48%" valign="top">
                    <table class="no-border">
                        <tr>
                            <td class="label">Daerah</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->daerah ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Mukim/ Bandar</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->mukim_bandar ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Kategori Premis</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->kategori_premis ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Sub Kategori</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->sub_kategori ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Jumlah Keluasan Premis</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->jumlah_keluasan ?? '' }}</div></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td width="48%">
                    <table class="no-border">
                        <tr>
                            <td class="label">Status Premis</td>
                            <td class="colon">:</td>
                            <td>{{ $premis->status_premis ?? 'Aktif' }}</td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td width="48%">
                    <table class="no-border">
                        <tr>
                            <td class="label">Aset Warisan</td>
                            <td class="colon">:</td>
                            <td>
                                <span class="small-box">{{ $premis->aset_warisan ? '✓' : '' }}</span>
                                <span class="note" style="margin-left: 5px;">(tandakan jika Ya)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td width="48%" valign="top">
                    <table class="no-border">
                        <tr>
                            <td class="label">Kos Siap Bina Asal</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">RM {{ $premis->kos_siap_bina_asal ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">*Kos Tambahan (PPUN)</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">RM {{ $premis->kos_tambahan_ppun ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Kos Keseluruhan Aset</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->kos_keseluruhan ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Tarikh Siap Bina</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->tarikh_siap_bina ? $premis->tarikh_siap_bina->format('d/m/Y') : '' }}</div></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding-top: 15px;">
                                <div class="note">*Pemulihan, Pemuliharaan, Ubahsuai &amp; Naiktaraf</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                <td width="48%" valign="top">
                    <table class="no-border">
                        <tr>
                            <td class="label">Sumber Pembiayaan</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->sumber_pembiayaan ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Kod PTJ</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->kod_ptj ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Nilai Semasa</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->nilai_semasa ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Tarikh Penilaian</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->tarikh_penilaian ? $premis->tarikh_penilaian->format('d/m/Y') : '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Bil. Blok Bangunan</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->bil_blok_bangunan ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label">Bil. Binaan Luar</td>
                            <td class="colon">:</td>
                            <td><div class="input-box">{{ $premis->bil_binaan_luar ?? '' }}</div></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td class="label">Catatan</td>
                <td class="colon">:</td>
                <td><div class="line-box">{{ $premis->catatan ?? '' }}</div></td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td class="label">Gambar Premis</td>
                <td class="colon">:</td>
                <td>Pastikan gambar premis diambil dan dimuat naik ke dalam sistem pengurusan aset tak alih</td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td class="label"><b>**NO DPA</b></td>
                <td class="colon">:</td>
                <td style="white-space: nowrap;">
                    @php $dpa = str_split(str_pad((string)($premis->no_dpa ?? ''), 24)); @endphp
                    @for ($i = 0; $i < 24; $i++)
                        <span class="dpa-box">{{ $dpa[$i] ?? '' }}</span>
                    @endfor
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <div class="note" style="margin-top: 5px;">
                        **diperolehi selepas pendaftaran ke dalam sistem pengurusan aset tak alih
                    </div>
                </td>
            </tr>
        </table>

        <br>

        <table class="no-border">
            <tr>
                <td width="45%" valign="top">
                    <h3 style="text-align:left; margin-bottom: 10px; font-size: 12px;">PENGUMPUL DATA:</h3>
                    <table class="no-border">
                        <tr>
                            <td class="label" style="width: 80px;">Tandatangan</td>
                            <td class="colon">:</td>
                            <td><div class="signature-box"></div></td>
                        </tr>
                        <tr>
                            <td class="label" style="width: 80px;">Nama</td>
                            <td class="colon">:</td>
                            <td><div class="line-box">{{ $premis->pengumpul_nama ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label" style="width: 80px;">Jawatan</td>
                            <td class="colon">:</td>
                            <td><div class="line-box">{{ $premis->pengumpul_jawatan ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label" style="width: 80px;">Tarikh</td>
                            <td class="colon">:</td>
                            <td><div class="line-box">{{ $premis->pengumpul_tarikh ?? '' }}</div></td>
                        </tr>
                    </table>
                </td>
                <td width="10%"></td>
                <td width="45%" valign="top">
                    <h3 style="text-align:left; margin-bottom: 10px; font-size: 12px;">PENGESAH DATA:</h3>
                    <table class="no-border">
                        <tr>
                            <td class="label" style="width: 80px;">Tandatangan</td>
                            <td class="colon">:</td>
                            <td><div class="signature-box"></div></td>
                        </tr>
                        <tr>
                            <td class="label" style="width: 80px;">Nama</td>
                            <td class="colon">:</td>
                            <td><div class="line-box">{{ $premis->pengesah_nama ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label" style="width: 80px;">Jawatan</td>
                            <td class="colon">:</td>
                            <td><div class="line-box">{{ $premis->pengesah_jawatan ?? '' }}</div></td>
                        </tr>
                        <tr>
                            <td class="label" style="width: 80px;">Tarikh</td>
                            <td class="colon">:</td>
                            <td><div class="line-box">{{ $premis->pengesah_tarikh ?? '' }}</div></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </div>

    <div class="page-break"></div>

    <div class="page">

        <div class="page-number">helaian 2</div>
        <div style="clear: both;"></div>

        <div class="top-title">D.A.3 (JKR.PATA.F6/8a rev.2)</div>
        <h2 style="text-align:center; font-size: 12px; margin-top: 30px;">Maklumat Tanah (jika ada)</h2>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%;">Bil</th>
                    <th rowspan="2" style="width: 10%;">No. Lot</th>
                    <th style="width: 20%;">Status Hak Milik Tanah</th>
                    <th rowspan="2" style="width: 10%;">Keluasan Tanah</th>
                    <th rowspan="2" style="width: 10%;">No. Hakmilik</th>
                    <th style="width: 15%;">Jenis Hakmilik</th>
                    <th rowspan="2" style="width: 10%;">Kegunaan Tanah</th>
                    <th colspan="2" style="width: 20%;">Nilai Tanah</th>
                </tr>
                <tr>
                    <th style="font-weight: normal; font-size: 9px; font-style: italic;">* Hakmilik / Rizab / Strata / Lain-lain</th>
                    <th style="font-weight: normal; font-size: 9px; font-style: italic;">*Kekal / Pajak ( &nbsp;&nbsp;&nbsp; ) Tahun</th>
                    <th>Harga Perolehan (RM)</th>
                    <th>Harga Semasa (RM)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($premis->tanah as $index => $tanah)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tanah->no_lot }}</td>
                    <td>{{ $tanah->status_hakmilik }}</td>
                    <td>{{ $tanah->keluasan_tanah }}</td>
                    <td>{{ $tanah->no_hakmilik }}</td>
                    <td>{{ $tanah->jenis_hakmilik }}</td>
                    <td>{{ $tanah->kegunaan_tanah }}</td>
                    <td>{{ $tanah->harga_perolehan }}</td>
                    <td>{{ $tanah->harga_semasa }}</td>
                </tr>
                @empty
                @for ($i = 0; $i < 3; $i++)
                <tr>
                    <td height="25">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
                @endforelse
            </tbody>
        </table>

        <br><br>

        <h2 style="text-align:center; font-size: 12px;">Senarai Lukisan Siap Bina</h2>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">Bil</th>
                    <th style="width: 20%;">Bidang</th>
                    <th style="width: 35%;">Tajuk Lukisan</th>
                    <th style="width: 20%;">No Rujukan</th>
                    <th style="width: 20%;">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($premis->lukisan as $index => $lukisan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lukisan->bidang }}</td>
                    <td>{{ $lukisan->tajuk_lukisan }}</td>
                    <td>{{ $lukisan->no_rujukan }}</td>
                    <td>{{ $lukisan->catatan }}</td>
                </tr>
                @empty
                @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td height="25">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
                @endforelse
            </tbody>
        </table>

    </div>

</body>

</html>