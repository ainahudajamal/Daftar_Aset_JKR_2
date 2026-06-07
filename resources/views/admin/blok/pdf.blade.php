<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>D.A.4 PDF</title>

    <style>
        body {
            font-family: 'fredoka';
            font-size: 11px;
            color: #000;
            margin: 10px;
        }

        .page {
            width: 100%;
        }

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
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .main-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 40px;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 25px;
            margin-bottom: 20px;
        }

        .center-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
        }

        .table-bordered th {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: center;
        }

        .input-line {
            border-bottom: 1px solid #000;
            height: 20px;
            width: 100%;
        }

        .dpa-box:last-child {
            border-right: none;
        }

        .note-line {
            border-bottom: 1px solid #000;
            height: 25px;
            width: 100%;
            margin-bottom: 10px;
        }

        .big-box {
            border: 1px solid #000;
            height: 500px;
            width: 100%;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            height: 30px;
            width: 100%;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

</head>

<body>

    <!-- PAGE 1 -->

    <div class="page">

        <div class="page-number">
            helaian 1
        </div>

        <div style="clear: both;"></div>

        <div class="top-title">
            D.A.4 (JKR.PATA.F6/12 rev 1)
        </div>

        <div class="main-title">
            BORANG SENARAI BLOK & BINAAN LUAR DALAM PREMIS
        </div>

        <div class="section-title">
            A. Senarai Blok Bangunan Dalam Premis
        </div>

        <div class="center-title">
            Maklumat Premis
        </div>

        <table style="margin-bottom:20px;">
            <tr>
                <td width="20%" style="padding-bottom:10px;">Nama Premis</td>
                <td width="5%" style="padding-bottom:10px;">:</td>
                <td style="padding-bottom:10px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="20%">No. DPA</td>
                <td width="5%">:</td>
                <td>
                    <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                        <tr>
                            @for ($i = 0; $i < 24; $i++)
                                <td style="border:1px solid #000; width:22px; height:28px;"></td>
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
            @for ($i = 1; $i <= 17; $i++)
                <tr>
                    <td height="35"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </table>

    </div>

    <div class="page-break"></div>

    <!-- PAGE 2 -->

    <div class="page">

        <div style="margin-top:20px; margin-bottom:20px;">
            <strong>Perihal/Catatan :</strong>
            <div class="note-line"></div>
            <div class="note-line"></div>
        </div>

        <div style="text-align:right; margin-bottom:10px;">
            Muka surat _____ dari______
        </div>

        <div class="page-number">helaian 2</div>
        <div style="clear: both;"></div>

        <div class="section-title">B. Senarai Binaan Luar Dalam Premis</div>
        <div class="center-title">Maklumat Premis</div>

        <table style="margin-bottom:20px;">
            <tr>
                <td width="20%" style="padding-bottom:10px;">Nama Premis</td>
                <td width="5%" style="padding-bottom:10px;">:</td>
                <td style="padding-bottom:10px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="20%">No. DPA</td>
                <td width="5%">:</td>
                <td>
                    <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                        <tr>
                            @for ($i = 0; $i < 24; $i++)
                                <td style="border:1px solid #000; width:22px; height:28px;"></td>
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
            @for ($i = 1; $i <= 17; $i++)
                <tr>
                    <td height="35"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </table>

    </div>

    <div class="page-break"></div>

    <!-- PAGE 3 -->

    <div class="page">

        <div style="margin-top:20px; margin-bottom:20px;">
            <strong>Perihal/Catatan :</strong>
            <div class="note-line"></div>
            <div class="note-line"></div>
        </div>

        <div style="text-align:right; margin-bottom:10px;">
            Muka surat _____ dari______
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

        <div style="margin-top:40px; margin-bottom:20px;">
            <strong>Perihal/Catatan :</strong>
            <div class="note-line"></div>
            <div class="note-line"></div>
        </div>

    </div>

    <div class="page-break"></div>

    <!-- PAGE 4 -->

    <div class="page">

        <div class="page-number">helaian 4</div>
        <div style="clear: both;"></div>

        <table width="100%" style="margin-top:60px;">
            <tr>

                <!-- PENGUMPUL DATA -->
                <td width="45%" valign="top">
                    <table width="100%">

                        <tr>
                            <td colspan="3" style="font-weight:bold; padding-bottom:20px;">
                                PENGUMPUL DATA
                            </td>
                        </tr>

                        <tr>
                            <td width="38%" valign="top" style="padding-bottom:12px;">Tandatangan</td>
                            <td width="8%" valign="top" style="padding-bottom:12px;">:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border:1px solid #000; height:60px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Jawatan</td>
                            <td>:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Tarikh</td>
                            <td>:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>

                <td width="10%"></td>

                <!-- PENGESAH DATA -->
                <td width="45%" valign="top">
                    <table width="100%">

                        <tr>
                            <td colspan="3" style="font-weight:bold; padding-bottom:20px;">
                                PENGESAH DATA
                            </td>
                        </tr>

                        <tr>
                            <td width="38%" valign="top" style="padding-bottom:12px;">Tandatangan</td>
                            <td width="8%" valign="top" style="padding-bottom:12px;">:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border:1px solid #000; height:60px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Jawatan</td>
                            <td>:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Tarikh</td>
                            <td>:</td>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="border-bottom:1px solid #000; height:20px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>

            </tr>
        </table>

    </div>

</body>

</html>