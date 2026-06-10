<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>D.A.4 PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 10px;
        }
        .page { width: 100%; }
        .page-number {
            border: 1px solid #000;
            width: 80px;
            padding: 8px;
            text-align: center;
            float: right;
            font-size: 10px;
            font-style: italic;
        }
        .top-title {
            text-align: right;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
        }
        .main-title {
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .center-title {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        table { width: 100%; border-collapse: collapse; }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }
        .table-bordered th {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: center;
        }
        .note-line {
            border-bottom: 1px solid #000;
            height: 25px;
            width: 100%;
            margin-bottom: 10px;
        }
        .big-box {
            border: 1px solid #000;
            height: 400px;
            width: 100%;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <!-- PAGE 1 — Bahagian A: Blok -->
    <div class="page">
        <div class="page-number">helaian 1</div>
        <div style="clear: both;"></div>

        <div class="top-title">D.A.4 (JKR.PATA.F6/12 rev 1)</div>
        <div class="main-title">BORANG SENARAI BLOK & BINAAN LUAR DALAM PREMIS</div>
        <div class="section-title">A. Senarai Blok Bangunan Dalam Premis</div>
        <div class="center-title">Maklumat Premis</div>

        <table style="margin-bottom:15px;">
            <tr>
                <td width="20%" style="padding-bottom:8px; border:none;">Nama Premis</td>
                <td width="5%" style="padding-bottom:8px; border:none;">:</td>
                <td style="padding-bottom:8px; border:none;">
                    <div style="border-bottom:1px solid #000; height:20px; padding-left:5px;">
                        {{ $premis->nama_premis ?? '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:none;">No. DPA</td>
                <td style="border:none;">:</td>
                <td style="border:none;">
                    <table cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        <tr>
                            @php $dpa = str_split(str_pad((string)($premis->no_dpa ?? ''), 24)); @endphp
                            @for($i = 0; $i < 24; $i++)
                            <td style="border:1px solid #000; width:22px; height:28px; text-align:center;">
                                {{ $dpa[$i] ?? '' }}
                            </td>
                            @endfor
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="center-title">Senarai Blok</div>

        <table class="table-bordered">
            <tr>
                <th width="8%">BIL</th>
                <th width="28%">NAMA BLOK</th>
                <th width="28%">FUNGSI BINAAN</th>
                <th width="18%">LUAS TAPAK (m²)</th>
                <th width="18%">KOD BLOK mySPATA</th>
            </tr>
            @forelse($premis->blok as $index => $blok)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>{{ $blok->nama_blok }}</td>
                <td>{{ $blok->fungsi_binaan }}</td>
                <td style="text-align:center;">{{ $blok->luas_tapak }}</td>
                <td style="text-align:center;">{{ $blok->kod_blok_myspata }}</td>
            </tr>
            @empty
            @for($i = 0; $i < 17; $i++)
            <tr>
                <td height="30">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
            @endforelse
            @if($premis->blok->count() > 0 && $premis->blok->count() < 17)
            @for($i = $premis->blok->count(); $i < 17; $i++)
            <tr>
                <td height="30">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
            @endif
        </table>
    </div>

    <div class="page-break"></div>

    <!-- PAGE 2 — Catatan Blok + Bahagian B: Binaan Luar -->
    <div class="page">

        <div style="margin-top:20px; margin-bottom:20px;">
            <strong>Perihal/Catatan :</strong>
            <div class="note-line"></div>
            <div class="note-line"></div>
        </div>

        <div style="text-align:right; margin-bottom:10px; font-size:10px;">
            Muka surat _____ dari ______
        </div>

        <div class="page-number">helaian 2</div>
        <div style="clear: both;"></div>

        <div class="section-title">B. Senarai Binaan Luar Dalam Premis</div>
        <div class="center-title">Maklumat Premis</div>

        <table style="margin-bottom:15px;">
            <tr>
                <td width="20%" style="padding-bottom:8px; border:none;">Nama Premis</td>
                <td width="5%" style="padding-bottom:8px; border:none;">:</td>
                <td style="padding-bottom:8px; border:none;">
                    <div style="border-bottom:1px solid #000; height:20px; padding-left:5px;">
                        {{ $premis->nama_premis ?? '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="border:none;">No. DPA</td>
                <td style="border:none;">:</td>
                <td style="border:none;">
                    <table cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        <tr>
                            @for($i = 0; $i < 24; $i++)
                            <td style="border:1px solid #000; width:22px; height:28px; text-align:center;">
                                {{ $dpa[$i] ?? '' }}
                            </td>
                            @endfor
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="center-title">Senarai Binaan Luar</div>

        <table class="table-bordered">
            <tr>
                <th width="8%">BIL</th>
                <th width="28%">NAMA BINAAN LUAR</th>
                <th width="28%">JENIS BINAAN LUAR</th>
                <th width="18%">LUAS TAPAK (m²)</th>
                <th width="18%">KOD BINAAN LUAR mySPATA</th>
            </tr>
            @forelse($premis->binaanLuar as $index => $binaan)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>{{ $binaan->nama_binaan_luar }}</td>
                <td>{{ $binaan->jenis_binaan_luar }}</td>
                <td style="text-align:center;">{{ $binaan->luas_tapak }}</td>
                <td style="text-align:center;">{{ $binaan->kod_binaan_luar_myspata }}</td>
            </tr>
            @empty
            @for($i = 0; $i < 17; $i++)
            <tr>
                <td height="30">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
            @endforelse
            @if($premis->binaanLuar->count() > 0 && $premis->binaanLuar->count() < 17)
            @for($i = $premis->binaanLuar->count(); $i < 17; $i++)
            <tr>
                <td height="30">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
            @endif
        </table>
    </div>

    <div class="page-break"></div>

    <!-- PAGE 3 — Pelan Tapak -->
    <div class="page">

        <div style="margin-top:20px; margin-bottom:20px;">
            <strong>Perihal/Catatan :</strong>
            <div class="note-line"></div>
            <div class="note-line"></div>
        </div>

        <div style="text-align:right; margin-bottom:10px; font-size:10px;">
            Muka surat _____ dari ______
        </div>

        <div class="page-number">helaian 3</div>
        <div style="clear: both;"></div>

        <div class="big-box" style="margin-top:20px;">
            <div style="padding:30px; color:#999; font-style:italic; line-height:2;">
                Sila lampirkan Pelan Tapak Siap bina dengan label mengikut aturan dalam helaian 1 dan helaian 2:
                <br><br>
                <strong>atau</strong>
                <br><br>
                Lakar (Lukis / Google / Cerapan & dan lain-lain kaedah bagi menerangkan susunatur blok / binaan luar) jika perlu
            </div>
        </div>

        <div style="margin-top:30px;">
            <strong>Perihal/Catatan :</strong>
            <div class="note-line"></div>
            <div class="note-line"></div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PAGE 4 — Tandatangan -->
    <div class="page">
        <div class="page-number">helaian 4</div>
        <div style="clear: both;"></div>

        <table width="100%" style="margin-top:60px; border:none;">
            <tr>
                <td width="45%" valign="top" style="border:none;">
                    <table width="100%">
                        <tr>
                            <td colspan="3" style="font-weight:bold; padding-bottom:20px; border:none;">PENGUMPUL DATA</td>
                        </tr>
                        <tr>
                            <td width="38%" valign="top" style="padding-bottom:12px; border:none;">Tandatangan</td>
                            <td width="8%" style="border:none;">:</td>
                            <td style="border:none;">
                                <div style="border:1px solid #000; height:60px;">&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;">Nama</td>
                            <td style="border:none;">:</td>
                            <td style="border:none;"><div class="note-line"></div></td>
                        </tr>
                        <tr>
                            <td style="border:none;">Jawatan</td>
                            <td style="border:none;">:</td>
                            <td style="border:none;"><div class="note-line"></div></td>
                        </tr>
                        <tr>
                            <td style="border:none;">Tarikh</td>
                            <td style="border:none;">:</td>
                            <td style="border:none;"><div class="note-line"></div></td>
                        </tr>
                    </table>
                </td>
                <td width="10%" style="border:none;"></td>
                <td width="45%" valign="top" style="border:none;">
                    <table width="100%">
                        <tr>
                            <td colspan="3" style="font-weight:bold; padding-bottom:20px; border:none;">PENGESAH DATA</td>
                        </tr>
                        <tr>
                            <td width="38%" valign="top" style="padding-bottom:12px; border:none;">Tandatangan</td>
                            <td width="8%" style="border:none;">:</td>
                            <td style="border:none;">
                                <div style="border:1px solid #000; height:60px;">&nbsp;</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;">Nama</td>
                            <td style="border:none;">:</td>
                            <td style="border:none;"><div class="note-line"></div></td>
                        </tr>
                        <tr>
                            <td style="border:none;">Jawatan</td>
                            <td style="border:none;">:</td>
                            <td style="border:none;"><div class="note-line"></div></td>
                        </tr>
                        <tr>
                            <td style="border:none;">Tarikh</td>
                            <td style="border:none;">:</td>
                            <td style="border:none;"><div class="note-line"></div></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>