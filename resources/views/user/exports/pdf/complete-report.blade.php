<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Lengkap - {{ $component->nama_premis }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'DejaVu Sans', 'sans-serif';
            color: #000;
            background: #fff;
            counter-reset: page-counter;
        }
        
        /* Page break after each section */
        .page-break {
            page-break-after: always;
        }
        
        .no-break {
            page-break-inside: avoid;
        }

        /* Page counter styling */
        .page-number {
            margin-top: 12px;
            text-align: right;
            font-size: 8pt;
            font-style: italic;
            border: 1px solid #000;
            padding: 5px 10px;
            display: inline-block;
            float: right;
        }

        .page-number::before {
            counter-increment: page-counter;
            content: "Muka surat " counter(page-counter) " dari {{ $totalPages ?? '_____' }}";
        }
        
        /* ==================== COMPONENT STYLES (BORANG 1) ==================== */
        .component-section {
            font-size: 9pt;
            line-height: 1.2;
            padding: 50px 30px;
        }
        
        .component-section .page-wrapper {
            transform: scale(0.95);
            transform-origin: center;
            width: 100%;
        }
        
        .component-section .page-header {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .component-section .page-header h1 {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: underline;
        }
        
        .component-section .page-header h2 {
            font-size: 10pt;
            font-weight: normal;
            text-decoration: underline;
        }
        
        .component-section .doc-code {
            position: absolute;
            top: 50px;
            right: 30px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .component-section .info-row {
            display: table;
            width: 100%;
            margin-bottom: 2px;
        }
        
        .component-section .info-label {
            display: table-cell;
            width: 100px;
            font-weight: normal;
            padding-right: 8px;
            vertical-align: top;
            font-size: 9pt;
        }
        
        .component-section .info-separator {
            display: table-cell;
            width: 8px;
            text-align: center;
            vertical-align: top;
        }
        
        .component-section .info-value {
            display: table-cell;
            border-bottom: 1px solid #000;
            padding: 0 4px 1px 4px;
            min-height: 16px;
            font-size: 9pt;
        }
        
        .component-section .checkbox-section {
            padding: 5px 8px;
            margin: 8px 0;
        }
        
        .component-section .checkbox-header {
            margin-bottom: 5px;
        }
        
        .component-section .checkbox-box {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #000;
            margin-right: 6px;
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
            line-height: 12px;
        }
        
        .component-section .checkbox-label {
            font-weight: bold;
            display: inline-block;
            vertical-align: middle;
        }
        
        .component-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        
        .component-section table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
            font-size: 9pt;
        }
        
        .component-section table th {
            border: 1px solid #000;
            background-color: #000;
            color: white;
            padding: 4px 6px;
            font-weight: bold;
            text-align: center;
            font-size: 9pt;
        }
        
        .component-section .label-col {
            width: 30%;
            background-color: #f5f5f5;
            font-weight: normal;
        }
        
        .component-section .value-col {
            width: 70%;
            background-color: #fff;
        }
        
        .component-section .catatan-row {
            min-height: 50px;
        }
        
        /* ==================== MAIN COMPONENT STYLES (BORANG 2) ==================== */
        .main-component-section {
            font-size: 7pt;
            line-height: 1.0;
            padding: 8mm;
        }
        
        .main-component-section .page-wrapper {
            transform: scale(0.85);
            transform-origin: top center;
        }
        
        .main-component-section .page-header {
            text-align: center;
            margin-bottom: 4px;
            border-bottom: 2px solid #fff;
            padding-bottom: 2px;
        }
        
        .main-component-section .page-header h1 {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 1px;
            text-decoration: underline;
        }
        
        .main-component-section .page-header h2 {
            font-size: 8pt;
            font-weight: normal;
            text-decoration: underline;
        }
        
        .main-component-section .section-title {
            background-color: #000;
            color: white;
            padding: 2px 4px;
            font-weight: bold;
            font-size: 7pt;
            margin-top: 2px;
            margin-bottom: 0;
            text-align: center;
        }
        
        .main-component-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        
        .main-component-section table td {
            border: 1px solid #000;
            padding: 1px 3px;
            vertical-align: top;
            font-size: 7pt;
        }
        
        .main-component-section .label-cell {
            background-color: #f5f5f5;
            font-weight: normal;
            width: 25%;
        }
        
        .main-component-section .value-cell {
            background-color: #fff;
        }
        
        .main-component-section .checkbox {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            margin-right: 3px;
            vertical-align: middle;
            text-align: center;
            line-height: 9px;
            font-size: 8px;
        }
        
        .main-component-section .inline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            padding: 0 3px;
        }

        .main-component-section .checkbox-row {
            padding: 2px 4px;
        }
        
        /* ==================== SUB COMPONENT STYLES (BORANG 3) ==================== */
        .sub-component-section {
            font-size: 8pt;
            line-height: 1.0;
            padding: 8mm;
        }
        
        .sub-component-section .page-wrapper {
            transform: scale(0.85);
            transform-origin: top center;
        }
        
        .sub-component-section .page-header {
            text-align: center;
            margin-bottom: 4px;
            border-bottom: 2px solid #fff;
            padding-bottom: 2px;
        }
        
        .sub-component-section .page-header h1 {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 1px;
            text-decoration: underline;
        }
        
        .sub-component-section .page-header h2 {
            font-size: 8pt;
            font-weight: normal;
            text-decoration: underline;
        }
        
        .sub-component-section .section-title {
            background-color: #000;
            color: white;
            padding: 2px 4px;
            font-weight: bold;
            font-size: 8pt;
            margin-top: 2px;
            margin-bottom: 0;
            text-align: center;
        }
        
        .sub-component-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        
        .sub-component-section table td {
            border: 1px solid #000;
            padding: 1px 3px;
            vertical-align: top;
            font-size: 8pt;
        }
        
        .sub-component-section .label-cell {
            background-color: #f5f5f5;
            font-weight: normal;
        }
        
        .sub-component-section .value-cell {
            background-color: #fff;
        }

        .sub-component-section .checkbox {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            margin-right: 3px;
            vertical-align: middle;
            text-align: center;
            line-height: 9px;
            font-size: 8px;
        }

        .sub-component-section .inline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            padding: 0 3px;
        }

        .sub-component-section .checkbox-row {
            padding: 2px 4px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .page-number::before {
                content: "Muka surat " counter(page) " dari {{ $totalPages ?? '_____' }}";
            }
        }
    </style>
</head>
<body>

<!-- SECTION 1: COMPONENT (BORANG 1) -->
<div class="component-section page-break">
    <div class="page-wrapper">
        <!-- Document Code -->
        <div class="doc-code">D.A 6</div>
        
        <!-- Header -->
    <div class="page-header">
        <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
        <h2>Peringkat Komponen</h2>
    </div>

    <!-- MAKLUMAT LOKASI KOMPONEN -->
    <div style="margin-top: 10px;">
        <div style="font-weight: bold; margin-bottom: 5px; font-size: 9pt;text-decoration: underline;">MAKLUMAT LOKASI KOMPONEN</div>
        
        <div class="info-row">
            <span class="info-label">Nama Premis</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $component->nama_premis ?? '' }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Nombor DPA</span>
            <span class="info-separator">:</span>
            <span class="info-value">{{ $component->nombor_dpa ?? '' }}</span>
        </div>
    </div>

    <!-- BLOK Section -->
    <div class="checkbox-section">
        <div class="checkbox-header">
            <span class="checkbox-box">
                @if($component->ada_blok)
                    ✓
                @endif
            </span>
            <span class="checkbox-label">Blok   (Tandakan '✓' jika berkenaan)</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Kod Blok</td>
                    <td class="value-col">
                        @if($component->ada_blok == 1)
                            @if(!empty($component->kod_blok) && !empty($component->nama_blok))
                                {{ $component->kod_blok }} - {{ $component->nama_blok }}
                            @elseif(!empty($component->kod_blok))
                                {{ $component->kod_blok }}
                            @elseif(!empty($component->nama_blok))
                                {{ $component->nama_blok }}
                            @endif
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">{{ $component->ada_blok == 1 ? ($component->kod_aras ?? '') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">{{ $component->ada_blok == 1 ? ($component->kod_ruang ?? '') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">{{ $component->ada_blok == 1 ? ($component->nama_ruang ?? '') : '' }}</td>
                </tr>
                <!-- CATATAN MERGED DALAM TABLE -->
                <tr>
                    <td colspan="2" class="catatan-row">
                        <strong>Catatan:</strong><br>
                        {{ $component->ada_blok == 1 ? ($component->catatan_blok ?? '') : '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- BINAAN LUAR Section -->
    <div class="checkbox-section">
        <div class="checkbox-header">
            <span class="checkbox-box">
                @if($component->ada_binaan_luar)
                    ✓
                @endif
            </span>
            <span class="checkbox-label">Binaan Luar (Tandakan '✓' jika berkenaan)</span>
            <span style="margin-left: 10px; font-size: 10pt;"></span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th colspan="2">Maklumat Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label-col">Nama Binaan Luar</td>
                    <td class="value-col">{{ $component->ada_binaan_luar == 1 ? ($component->nama_binaan_luar ?? '') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Binaan Luar</td>
                    <td class="value-col">{{ $component->ada_binaan_luar == 1 ? ($component->kod_binaan_luar ?? '') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Koordinat GPS (WGS 84)</td>
                    <td class="value-col">
                        @if($component->ada_binaan_luar == 1)
                            @if($component->koordinat_x || $component->koordinat_y)
                                X : {{ $component->koordinat_x ?? '' }}<br>
                                Y : {{ $component->koordinat_y ?? '' }}
                            @else
                                X : <span style="margin-left: 100px;"></span> <br>
                                Y : <span style="margin-left: 100px;"></span> 
                            @endif
                        @else
                            X : <span style="margin-left: 100px;"></span> <br>
                            Y : <span style="margin-left: 100px;"></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #ffffffff; font-weight: bold; text-align: left;">
                        Diisi Jika Binaan Luar Mempunyai Aras dan Ruang
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Kod Aras</td>
                    <td class="value-col">{{ $component->ada_binaan_luar == 1 ? ($component->kod_aras_binaan ?? '') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Kod Ruang</td>
                    <td class="value-col">{{ $component->ada_binaan_luar == 1 ? ($component->kod_ruang_binaan ?? '') : '' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Nama Ruang</td>
                    <td class="value-col">{{ $component->ada_binaan_luar == 1 ? ($component->nama_ruang_binaan ?? '') : '' }}</td>
                </tr>
                <!-- CATATAN MERGED DALAM TABLE -->
                <tr>
                    <td colspan="2" class="catatan-row">
                        <strong>Catatan:</strong><br>
                        {{ $component->ada_binaan_luar == 1 ? ($component->catatan_binaan ?? '') : '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SIGNATURE SECTION -->
    <div style="margin-top: 18px; width: 100%;">
        <table style="width: 100%; border-collapse: collapse; border: none;">
            <tr>
                <!-- PENGUMPUL DATA -->
                <td style="width: 50%; vertical-align: top; padding-right: 20px; border: none;">
                    <div style="position: relative; margin-left: 90px;">
                        <!-- Title tanpa border atas, kiri, kanan -->
                        <div style="font-weight: bold; text-transform: uppercase; font-size: 9pt; padding: 6px 0; text-align: left; border-bottom: 1px solid #ffffffff;">
                            PENGUMPUL DATA :
                        </div>
                        
                        <!-- Kotak dengan border penuh -->
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #ffffffff; border-top: none;">
                            <tr>
                                <td style="height: 55px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px;"></td>
                            </tr>
                        </table>
                        
                        <!-- Labels di luar kotak (sebelah kiri, rapat dengan row) -->
                        <div style="position: absolute; top: 47px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tandatangan :
                        </div>
                        <div style="position: absolute; top: 107px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Nama :
                        </div>
                        <div style="position: absolute; top: 147px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Jawatan :
                        </div>
                        <div style="position: absolute; top: 187px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tarikh :
                        </div>
                    </div>
                </td>
                
                <!-- PENGESAH DATA -->
                <td style="width: 50%; vertical-align: top; padding-left: 20px; border: none;">
                    <div style="position: relative; margin-left: 90px;">
                        <!-- Title tanpa border atas, kiri, kanan -->
                        <div style="font-weight: bold; text-transform: uppercase; font-size: 9pt; padding: 6px 0; text-align: left; border-bottom: 1px solid #ffffffff;">
                            PENGESAH DATA :
                        </div>
                        
                        <!-- Kotak dengan border penuh -->
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #ffffffff; border-top: none;">
                            <tr>
                                <td style="height: 55px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px; border-bottom: 1px solid #000;"></td>
                            </tr>
                            <tr>
                                <td style="height: 30px;"></td>
                            </tr>
                        </table>
                        
                        <!-- Labels di luar kotak (sebelah kiri, rapat dengan row) -->
                        <div style="position: absolute; top: 47px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tandatangan :
                        </div>
                        <div style="position: absolute; top: 107px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Nama :
                        </div>
                        <div style="position: absolute; top: 147px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Jawatan :
                        </div>
                        <div style="position: absolute; top: 187px; left: -90px; font-size: 9pt; white-space: nowrap;">
                            Tarikh :
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

        <!-- FOOTER PAGE COUNT -->
        <div class="page-number"></div>
    </div>
</div>

<!-- SECTION 2: MAIN COMPONENTS (BORANG 2) -->
@foreach($component->mainComponents as $index => $mainComponent)
<div class="main-component-section {{ $loop->last && $component->mainComponents->sum(fn($mc) => $mc->subComponents->count()) == 0 ? '' : 'page-break' }}">
    <div class="page-wrapper">
        <!-- Header -->
        <div class="page-header">
            <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
    <h2>Peringkat Komponen Utama</h2>
    </div>

    <!-- MAKLUMAT LOKASI KOMPONEN -->
    <div style="margin-top: 4px; margin-bottom: 3px;">
        <div style="font-weight: bold; margin-bottom: 3px; font-size: 7.4pt; text-decoration: underline;">
            MAKLUMAT LOKASI KOMPONEN
        </div>

        <!-- Nama Premis -->
        <div style="margin-bottom: 2px; font-size: 7.4pt;">
            <span>Nama Premis</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 95px); min-height: 12px; padding-left: 5px;">{{ $mainComponent->component?->nama_premis ?? '' }}</span>
        </div>

        <!-- Nombor DPA + Kod Lokasi (SEBARIS) -->
        <div style="font-size: 7.4pt;">
            <span>Nombor DPA</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; min-height: 12px; padding-left: 5px;">{{ $mainComponent->component?->nombor_dpa ?? '' }}</span>
            
            <span style="margin-left: 40px;">Kod Lokasi</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 410px); min-height: 12px; padding-left: 5px;">{{ $mainComponent->kod_lokasi ?? '' }}</span>
        </div>
    </div>

<table>
<!-- MAKLUMAT KOMPONEN UTAMA -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Maklumat Utama</td>
    </tr>
    <tr>
        <td class="label-cell">Nama Komponen Utama</td>
        <td colspan="6" class="value-cell">{{ $mainComponent->nama_komponen_utama ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Sistem</td>
        <td colspan="6"class="value-cell">{{ $mainComponent->sistem ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">SubSistem</td>
        <td colspan="6"class="value-cell">{{ $mainComponent->subsistem ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kuantiti<br><small>(Komponen yang sama jenis)</small></td>
        <td colspan="1" class="value-cell">{{ $mainComponent->kuantiti ?? '' }}</td>
        <td class="label-cell" rowspan="2" style="vertical-align: middle;">Gambar Komponen</td>
        <td colspan="4" class="value-cell" rowspan="2"><span>Sila Lampirkan gambar jika perlu dan pastikan dimuat naik ke dalam Sistem mySPATA</span></td>
    </tr>
    <tr>
        <td colspan="1" class="label-cell">No Perolehan (1GFMAS)</td>
        <td colspan="1" class="value-cell">{{ $mainComponent->no_perolehan_1gfmas ?? '' }}</td>
    </tr>

<!-- Bidang Kejuruteraan -->
    <tr>
        <td colspan="1" class="checkbox-row">
            <strong>Bidang Kejuruteraan</strong><br><strong>Komponen:</strong>
        </td>
        <td colspan="6" class="value-cell">
            <div style="margin-top: 2px;">
                <span class="checkbox">{{ $mainComponent->awam_arkitek ? '✓' : '' }}</span> Awam/Arkitek
                <span style="margin-left: 10px;" class="checkbox">{{ $mainComponent->elektrikal ? '✓' : '' }}</span> Elektrikal
                <span style="margin-left: 10px;" class="checkbox">{{ $mainComponent->elv_ict ? '✓' : '' }}</span> ELV/ICT
                <span style="margin-left: 10px;" class="checkbox">{{ $mainComponent->mekanikal ? '✓' : '' }}</span> Mekanikal<br>
                <span class="checkbox">{{ $mainComponent->bio_perubatan ? '✓' : '' }}</span> Bio Perubatan
                <span style="margin-left: 10px;" class="checkbox">{{ $mainComponent->lain_lain ? '✓' : '' }}</span> Lain-lain: 
                <span class="inline-field">{{ $mainComponent->lain_lain ?? '' }}</span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="7" style="min-height: 15px;">
            <strong>Catatan:</strong> {{ $mainComponent->catatan ?? '' }}
        </td>
    </tr>

<!-- MAKLUMAT PEROLEHAN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Maklumat Perolehan</td>
    </tr>
    <tr>
        <td class="label-cell">Tarikh Perolehan</td>
        <td class="value-cell">{{ $mainComponent->tarikh_perolehan?->format('d/m/Y') ?? '' }}</td>
        <td class="label-cell">Tarikh Dipasang</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->tarikh_dipasang?->format('d/m/Y') ?? '' }}</td>
    </tr>
    <tr>
    <td class="label-cell">Kos Perolehan/Kontrak</td>
    <td class="value-cell">
        @php
            $kosBersih = preg_replace('/[^0-9.]/', '', $mainComponent->kos_perolehan ?? '');
            $kosFloat = (float) $kosBersih;
            echo $kosFloat > 0 ? 'RM ' . number_format($kosFloat, 2) : '';
        @endphp
    </td>
    <td class="label-cell">Tarikh Waranti Tamat</td>
    <td colspan="4" class="value-cell">{{ $mainComponent->tarikh_waranti_tamat?->format('d/m/Y') ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">No. Pesanan Rasmi Kerajaan/Kontrak</td>
        <td class="value-cell">{{ $mainComponent->no_pesanan_rasmi_kontrak ?? '' }}</td>
        <td class="label-cell">Tarikh Tamat DLP</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->tarikh_tamat_dlp?->format('d/m/Y') ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="1" class="label-cell">Kod PTJ</td>
        <td colspan="1" class="value-cell">{{ $mainComponent->kod_ptj ?? '' }}</td>
        <td class="label-cell">Jangka Hayat</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->jangka_hayat ? $mainComponent->jangka_hayat . ' Tahun' : '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Pengilang</td>
        <td colspan="6" class="value-cell">{{ $mainComponent->nama_pengilang ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Pembekal</td>
        <td class="value-cell">{{ $mainComponent->nama_pembekal ?? '' }}</td>
        <td class="label-cell">No. Telefon</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->no_telefon_pembekal ?? '' }}</td>        
    </tr>
    <tr>
        <td class="label-cell">Alamat Pembekal</td>
        <td colspan="6" class="value-cell">{{ $mainComponent->alamat_pembekal ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kontraktor</td>
        <td class="value-cell">{{ $mainComponent->nama_kontraktor ?? '' }}</td>
        <td class="label-cell">No. Telefon</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->no_telefon_kontraktor ?? '' }}</td>        
    </tr>
    <tr>
        <td class="label-cell">Alamat Kontraktor</td>
        <td colspan="6" class="value-cell">{{ $mainComponent->alamat_kontraktor ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="7" style="min-height: 15px;"><strong>Catatan:</strong> {{ $mainComponent->catatan_maklumat ?? '' }}</td>
    </tr>

<!-- MAKLUMAT KOMPONEN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Komponen</td>
    </tr>
    <tr>
        <td class="label-cell" style="width: 15%;">Deskripsi</td>
        <td class="value-cell" style="width: 35%;">{{ $mainComponent->deskripsi ?? '' }}</td>
        <td class="label-cell" style="width: 15%;">Status Komponen</td>
        <td colspan="4" class="value-cell" style="width: 35%;">
            @switch($mainComponent->status_komponen)
                @case('operational') Operational @break
                @case('under_maintenance') Under Maintenance @break
                @case('rosak') Rosak @break
                @case('retired') Retired @break
                @default {{ $mainComponent->status_komponen ?? '' }}
            @endswitch
        </td>
    </tr>
    <tr>
        <td class="label-cell">Jenama</td>
        <td class="value-cell">{{ $mainComponent->jenama ?? '' }}</td>
        <td class="label-cell">No. Siri</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->no_siri ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Model</td>
        <td class="value-cell">{{ $mainComponent->model ?? '' }}</td>
        <td class="label-cell">No. Tag / Label (Jika berkenaan)</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->no_tag_label ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell" colspan="2"></td>
        <td class="label-cell">No Sijil Pendaftaran (Jika ada)</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->no_sijil_pendaftaran ?? '' }}</td>
    </tr>

<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">** Maklumat Atribut Spesifikasi</td>
    </tr>
    <tr>
        <td class="label-cell" style="width: 15%;">Jenis</td>
        <td class="value-cell" style="width: 35%;">{{ $mainComponent->jenis ?? '' }}</td>
        <td class="label-cell" style="width: 15%;">Bahan</td>
        <td colspan="4" class="value-cell" style="width: 35%;">{{ $mainComponent->bahan ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Bekalan Elektrik<br><small>(MSB/SSB/PP/DB...)</small></td>
        <td class="value-cell">{{ $mainComponent->bekalan_elektrik ?? '' }}</td>
        <td class="label-cell">Kaedah Pemasangan</td>
        <td colspan="4" class="value-cell">{{ $mainComponent->kaedah_pemasangan ?? '' }}</td>
    </tr>
    <tr style="background-color: #f5f5f5;">
        <td style="text-align: center; font-weight: bold;" colspan="1">Saiz Fizikal</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Unit</td>
        <td style="text-align: center; font-weight: bold;" colspan="1">Kadaran</td>
        <td style="text-align: center; font-weight: bold;" colspan="3">Unit</td>
    </tr>
    @php
        // FIXED: Use correct type values matching MainComponentMeasurement model
        $saizFizikalData = isset($mainComponent->measurements) && is_object($mainComponent->measurements) 
            ? $mainComponent->measurements->where('type', 'saiz')->sortBy('order')
            : collect();
        
        $kadaranData = isset($mainComponent->measurements) && is_object($mainComponent->measurements)
            ? $mainComponent->measurements->where('type', 'kadaran')->sortBy('order')
            : collect();
        
        $hasSaiz = $saizFizikalData->count() > 0;
        $hasKadaran = $kadaranData->count() > 0;
        $maxRows = max(
            $hasSaiz ? $saizFizikalData->count() : 0,
            $hasKadaran ? $kadaranData->count() : 0,
            4
        );
    @endphp
    @for($i = 0; $i < $maxRows; $i++)
    <tr>
        <td style="text-align: center; width: 120px;">
            {{ $hasSaiz && isset($saizFizikalData->values()[$i]) ? $saizFizikalData->values()[$i]->value ?? '' : '' }}
        </td>
        <td style="text-align: center; width: 120px;">
            {{ $hasSaiz && isset($saizFizikalData->values()[$i]) ? $saizFizikalData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td style="width: 120px;" rowspan="{{ $maxRows }}"><span>(Panjang/Lebar/Tinggi/Lebar/Luas/<br>Dalam/Tebal/Diameter/Jejari dll)</span></td>
        @endif
        <td style="text-align: center;">
            {{ $hasKadaran && isset($kadaranData->values()[$i]) ? $kadaranData->values()[$i]->value ?? '' : '' }}
        </td>
        <td style="text-align: center;">
            {{ $hasKadaran && isset($kadaranData->values()[$i]) ? $kadaranData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td colspan="2" rowspan="{{ $maxRows }}"><span>(Voltan/Arus/Kuasa/<br>Rating/Ratio/Keamatan Bunyi/Fluks/Faktor/Kuasa/<br>Kecekapan/Fotometri/<br>Bandwidth dll)</span></td>
        @endif
    </tr>
    @endfor
    <tr>
        <td style="text-align: center; font-weight: bold;" colspan="1">Kapasiti</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Unit</td>
        @php
            $kapasitiData = isset($mainComponent->measurements) && is_object($mainComponent->measurements)
                ? $mainComponent->measurements->where('type', 'kapasiti')->sortBy('order')
                : collect();
            
            $hasKapasiti = $kapasitiData->count() > 0;
            $kapastiRows = max($hasKapasiti ? $kapasitiData->count() : 0, 4);
        @endphp
        <td colspan="4" class="value-cell" rowspan="{{ $kapastiRows + 1 }}" style="min-height: 15px;"><strong>Catatan:</strong> {{ $mainComponent->catatan_atribut ?? '' }}</td>
    </tr>
    @for($i = 0; $i < $kapastiRows; $i++)
    <tr>
        <td style="text-align: center;">
            {{ $hasKapasiti && isset($kapasitiData->values()[$i]) ? $kapasitiData->values()[$i]->value ?? '' : '' }}
        </td>
        <td style="text-align: center;">
            {{ $hasKapasiti && isset($kapasitiData->values()[$i]) ? $kapasitiData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td rowspan="{{ $kapastiRows }}"><span>(Isipadu/Head/Berat/Btu/Velocity/Speed dll)</span></td>
        @endif
    </tr>
    @endfor

<!-- KOMPONEN YANG BERHUBUNGKAIT -->
    <tr>
        <td colspan="7" class="section-title"style="text-align: center;">** Komponen Yang Berhubungkait (Jika Ada)</td>
    </tr>
    <tr style="background-color: #f5f5f5; font-weight: bold;">
        <td colspan="1" style="width: 5%; text-align: center;">Bil</td>
        <td colspan="2" style="width: 45%; text-align: center;">Nama Komponen</td>
        <td colspan="2" style="width: 30%; text-align: center;">No. DPA / Kod Ruang / Kod Binaan Luar</td>
        <td colspan="2" style="width: 20%; text-align: center;">No. Tag / Label</td>
    </tr>
    @if($mainComponent->relatedComponents && $mainComponent->relatedComponents->count() > 0)
        @foreach($mainComponent->relatedComponents->take(7) as $related)
        <tr>
            <td colspan="1" style="text-align: center;">{{ $related->bil ?? '' }}</td>
            <td colspan="2"style="text-align: center;">{{ $related->nama_komponen ?? '' }}</td>
            <td colspan="2" style="text-align: center;">{{ $related->no_dpa_kod_ruang ?? '' }}</td>
            <td colspan="2" style="text-align: center;">{{ $related->no_tag_label ?? '' }}</td>
        </tr>
        @endforeach
    @else
        @for($i = 0; $i < 2; $i++)
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        @endfor
    @endif
    <tr>
        <td colspan="7" style="min-height: 15px;"><strong>Catatan:</strong> {{ $mainComponent->catatan_komponen_berhubung ?? '' }}</td>
    </tr>

<!-- DOKUMEN BERKAITAN -->
    <tr>
        <td colspan="7" class="section-title"style="text-align: center;">** Dokumen Berkaitan (Jika Ada)</td>
    </tr>
    <tr style="background-color: #f5f5f5; font-weight: bold;">
        <td colspan="1" style="width: 5%; text-align: center;">Bil</td>
        <td colspan="2" style="width: 35%; text-align: center;">Nama Dokumen</td>
        <td colspan="2" style="width: 30%; text-align: center;">No Rujukan Berkaitan</td>
        <td colspan="2" style="width: 30%; text-align: center;">Catatan</td>
    </tr>
    @if($mainComponent->relatedDocuments && $mainComponent->relatedDocuments->count() > 0)
        @foreach($mainComponent->relatedDocuments->take(3) as $doc)
        <tr>
            <td colspan="1" style="text-align: center;">{{ $doc->bil ?? '' }}</td>
            <td colspan="2" style="text-align: center;">{{ $doc->nama_dokumen ?? '' }}</td>
            <td colspan="2" style="text-align: center;">{{ $doc->no_rujukan_berkaitan ?? '' }}</td>
            <td colspan="2" style="text-align: center;">{{ $doc->catatan ?? '' }}</td>
        </tr>
        @endforeach
    @else
        @for($i = 0; $i < 2; $i++)
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        @endfor
    @endif
</table>

<!-- Nota -->
<div style="margin-top: 3px; font-size: 7pt;">
    <strong>Nota:</strong><br>
    * Sila gunakan lampiran jika Maklumat Aset / Komponen diperolehi bagi kuantiti yang melebihi 1.<br>
    ** Maklumat Spesifikasi itu merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.
</div>

        <!-- Muka Surat -->
        <div class="page-number"></div>
    </div>
</div>

    <!-- SECTION 3: SUB COMPONENTS for this Main Component -->
    @foreach($mainComponent->subComponents as $subIndex => $subComponent)
    <div class="sub-component-section {{ $loop->parent->last && $loop->last ? '' : 'page-break' }}">
        <div class="page-wrapper">
            <!-- Header -->
            <div class="page-header">
                <h1>BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h1>
    <h2>Peringkat Komponen Sub Komponen</h2>
</div>

    <!-- MAKLUMAT SUB Komponen -->
    <div style="margin-top: 4px; margin-bottom: 3px;">
        <div style="font-weight: bold; margin-bottom: 3px; font-size: 7.4pt; text-decoration: underline;">
            MAKLUMAT SUB KOMPONEN
        </div>

    <!-- Nama Komponen Utama -->
        <div style="margin-bottom: 2px; font-size: 7.4pt;">
            <span>Nama Komponen Utama</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 200px); min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->nama_komponen_utama ?? '' }}</span>
        </div>

        <!-- Id Komponen Utama + Kod Lokasi (SEBARIS) -->
        <div style="font-size: 7.4pt;">
            <span>Id Komponen Utama</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->id ?? '' }}</span>
            
            <span style="margin-left: 40px;">Kod Lokasi</span>
            <span style="margin: 0 5px;">:</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; width: calc(100% - 450px); min-height: 12px; padding-left: 5px;">{{ $subComponent->mainComponent->kod_lokasi ?? '' }}</span>
        </div>
    </div>

<table>
<!-- MAKLUMAT SUB KOMPONEN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Maklumat Sub Komponen</td>
    </tr>
    <tr>
        <td class="label-cell">Nama Sub Komponen</td>
        <td colspan="6" class="value-cell">{{ $subComponent->nama_sub_komponen ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Deskripsi</td>
        <td colspan="6" class="value-cell">{{ $subComponent->deskripsi ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Status Komponen</td>
        <td colspan="1" class="value-cell">
            @switch($subComponent->status_komponen)
                @case('operational') Operational @break
                @case('under_maintenance') Under Maintenance @break
                @case('rosak') Rosak @break
                @default {{ $subComponent->status_komponen ?? '' }}
            @endswitch
        </td>
        <td class="label-cell">No. Siri</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_siri ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Jenama</td>
        <td colspan="1" class="value-cell">{{ $subComponent->jenama ?? '' }}</td>
        <td class="label-cell">No. Sijil Pendaftaran (Jika ada)</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_sijil_pendaftaran ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Model</td>
        <td colspan="1" class="value-cell">{{ $subComponent->model ?? '' }}</td>
        <td class="label-cell">Kuantiti (Sama Jenis)</td>
        <td colspan="4" class="value-cell">{{ $subComponent->kuantiti ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="7" style="min-height: 15px;">
            <strong>Catatan:</strong> {{ $subComponent->catatan ?? '' }}
        </td>
    </tr>

<!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">** Maklumat Atribut Spesifikasi</td>
    </tr>
    <tr>
        <td class="label-cell" style="width: 15%;">Jenis</td>
        <td class="value-cell" style="width: 35%;">{{ $subComponent->jenis ?? '' }}</td>
        <td class="label-cell" style="width: 15%;">Bahan</td>
        <td colspan="4" class="value-cell" style="width: 35%;">{{ $subComponent->bahan ?? '' }}</td>
    </tr>
    <tr style="background-color: #f5f5f5;">
        <td style="text-align: center; font-weight: bold;" colspan="1">Saiz Fizikal</td>
        <td style="text-align: center; font-weight: bold;" colspan="1">Unit</td>
        <td style="text-align: center; font-weight: bold;" colspan="1">Kadaran</td>
        <td style="text-align: center; font-weight: bold;" colspan="4">Unit</td>
    </tr>
    @php
        // FIXED: Use correct relationship and field names
        $saizFizikalData = isset($subComponent->measurements) && is_object($subComponent->measurements) 
            ? $subComponent->measurements->where('type', 'saiz')->sortBy('order')
            : collect();
        
        $kadaranData = isset($subComponent->measurements) && is_object($subComponent->measurements)
            ? $subComponent->measurements->where('type', 'kadaran')->sortBy('order')
            : collect();
        
        $hasSaiz = $saizFizikalData->count() > 0;
        $hasKadaran = $kadaranData->count() > 0;
        $maxRows = max(
            $hasSaiz ? $saizFizikalData->count() : 0,
            $hasKadaran ? $kadaranData->count() : 0,
            4
        );
    @endphp
    @for($i = 0; $i < $maxRows; $i++)
    <tr>
        <td colspan="1" style="text-align: center;">
            {{-- FIXED: Use 'value' instead of 'nilai' --}}
            {{ $hasSaiz && isset($saizFizikalData->values()[$i]) ? $saizFizikalData->values()[$i]->value ?? '' : '' }}
        </td>
        <td colspan="1" style="width: 150px;">
            {{ $hasSaiz && isset($saizFizikalData->values()[$i]) ? $saizFizikalData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td colspan="1" rowspan="{{ $maxRows }}"><span>(Panjang/Tinggi/<br>Lebar/Luas/<br>Dalam/Lebar/Tebal/<br>Diameter/Jarak dll)</span></td>
        @endif
        <td style="text-align: center;">
            {{-- FIXED: Use 'value' instead of 'nilai' --}}
            {{ $hasKadaran && isset($kadaranData->values()[$i]) ? $kadaranData->values()[$i]->value ?? '' : '' }}
        </td>
        <td colspan="1">
            {{ $hasKadaran && isset($kadaranData->values()[$i]) ? $kadaranData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td colspan="2" rowspan="{{ $maxRows }}"><span>(Voltan/Arus/Kuasa/<br>Rating/Ratio/Keamatan Bunyi/Fluks/<br>Faktor Kuasa/Kecekapan/<br>Fotometri/Bandwidth dll)</span></td>
        @endif
    </tr>
    @endfor
    <tr style="background-color: #ffffffff;">
        <td style="text-align: center; font-weight: bold;" colspan="1">Kapasiti</td>
        <td style="text-align: center; font-weight: bold;" colspan="2">Unit</td>
        @php
            // FIXED: Use correct type value
            $kapasitiData = isset($subComponent->measurements) && is_object($subComponent->measurements)
                ? $subComponent->measurements->where('type', 'kapasiti')->sortBy('order')
                : collect();
            
            $hasKapasiti = $kapasitiData->count() > 0;
            $kapastiRows = max($hasKapasiti ? $kapasitiData->count() : 0, 4);
        @endphp
        <td colspan="2" class="value-cell" rowspan="{{ $kapastiRows + 1 }}" style="min-height: 15px; vertical-align: top;">
            <strong>Gambar Sub Komponen</strong><br>
        </td>
        <td colspan="2" class="value-cell" rowspan="{{ $kapastiRows + 1 }}">
            <span style="font-size: 7pt;">Sila lampirkan gambar jika perlu, dan pastikan dimuat naik ke dalam Sistem mySPATA</span>
        </td>
    </tr>
    @for($i = 0; $i < $kapastiRows; $i++)
    <tr>
        <td style="text-align: center;">
            {{-- FIXED: Use 'value' instead of 'nilai' --}}
            {{ $hasKapasiti && isset($kapasitiData->values()[$i]) ? $kapasitiData->values()[$i]->value ?? '' : '' }}
        </td>
        <td>
            {{ $hasKapasiti && isset($kapasitiData->values()[$i]) ? $kapasitiData->values()[$i]->unit ?? '' : '' }}
        </td>
        @if($i === 0)
        <td rowspan="{{ $kapastiRows }}"><span>(Isipadu/Head/Berat/Btu/ Velocity/Speed dll)</span></td>
        @endif
    </tr>
    @endfor
    <tr>
        <td colspan="7" style="min-height: 15px;"><strong>Catatan:</strong> {{ $subComponent->catatan_atribut ?? '' }}</td>
    </tr>

<!-- MAKLUMAT PEMBELIAN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Maklumat Pembelian</td>
    </tr>
    <tr>
        <td class="label-cell">Tarikh Pembelian</td>
        <td class="value-cell">{{ $subComponent->tarikh_pembelian ? \Carbon\Carbon::parse($subComponent->tarikh_pembelian)->format('d/m/Y') : '' }}</td>
        <td class="label-cell">Tarikh Dipasang</td>
        <td colspan="4" class="value-cell">{{ $subComponent->tarikh_dipasang ? \Carbon\Carbon::parse($subComponent->tarikh_dipasang)->format('d/m/Y') : '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kos Perolehan/Kontrak</td>
        <td class="value-cell">{{ $subComponent->kos_perolehan ? 'RM ' . number_format($subComponent->kos_perolehan, 2) : '' }}</td>
        <td class="label-cell">Tarikh Waranti Tamat</td>
        <td colspan="4" class="value-cell">{{ $subComponent->tarikh_waranti_tamat ? \Carbon\Carbon::parse($subComponent->tarikh_waranti_tamat)->format('d/m/Y') : '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">No. Pesanan Rasmi Kerajaan/Kontrak</td>
        <td colspan="1" class="value-cell">{{ $subComponent->no_pesanan_rasmi_kontrak ?? '' }}</td>
        <td class="label-cell">Jangka Hayat</td>
        <td colspan="4" class="value-cell">{{ $subComponent->jangka_hayat ? $subComponent->jangka_hayat . ' Tahun' : '' }}</td>
    </tr>
    <tr>
        <td colspan="1" class="label-cell">Kod PTJ</td>
        <td colspan="1" class="value-cell">{{ $subComponent->kod_ptj ?? '' }}</td>
        <td></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td class="label-cell">Pengilang</td>
        <td colspan="6" class="value-cell">{{ $subComponent->nama_pengilang ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Pembekal</td>
        <td colspan="1" class="value-cell">{{ $subComponent->nama_pembekal ?? '' }}</td>
        <td class="label-cell">No. Telefon</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_telefon_pembekal ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Alamat</td>
        <td colspan="6" class="value-cell">{{ $subComponent->alamat_pembekal ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Kontraktor</td>
        <td colspan="1" class="value-cell">{{ $subComponent->nama_kontraktor ?? '' }}</td>
        <td class="label-cell">No. Telefon</td>
        <td colspan="4" class="value-cell">{{ $subComponent->no_telefon_kontraktor ?? '' }}</td>
    </tr>
    <tr>
        <td class="label-cell">Alamat</td>
        <td colspan="6" class="value-cell">{{ $subComponent->alamat_kontraktor ?? '' }}</td>
    </tr>
    <tr>
        <td colspan="7" style="min-height: 15px;"><strong>Catatan:</strong> {{ $subComponent->catatan_pembelian ?? '' }}</td>
    </tr>

<!-- DOKUMEN BERKAITAN -->
    <tr>
        <td colspan="7" class="section-title" style="text-align: center;">Dokumen Berkaitan (Jika Ada)</td>
    </tr>
    <tr style="background-color: #ffffffff; font-weight: bold;">
        <td colspan="1" style="width: 5%; text-align: center;">Bil</td>
        <td colspan="2" style="width: 45%; text-align: center;">Nama Dokumen</td>
        <td colspan="2" style="width: 30%; text-align: center;">No Rujukan Berkaitan</td>
        <td colspan="2" style="width: 20%; text-align: center;">Catatan</td>
    </tr>
    @php
        $documents = is_string($subComponent->dokumen_berkaitan) 
            ? json_decode($subComponent->dokumen_berkaitan, true) 
            : $subComponent->dokumen_berkaitan;
        
        $hasData = is_array($documents) && !empty($documents) && collect($documents)->contains(function($doc) {
            return !empty($doc['nama']) || !empty($doc['rujukan']);
        });
        
        $minRows = 4;
    @endphp
    
    @if($hasData)
        @foreach($documents as $doc)
            @if(!empty($doc['nama']) || !empty($doc['rujukan']))
            <tr>
                <td colspan="1" style="text-align: center;">{{ $doc['bil'] ?? '' }}</td>
                <td colspan="2">{{ $doc['nama'] ?? '' }}</td>
                <td colspan="2">{{ $doc['rujukan'] ?? '' }}</td>
                <td colspan="2">{{ $doc['catatan'] ?? '' }}</td>
            </tr>
            @endif
        @endforeach
    @else
        @for($i = 0; $i < $minRows; $i++)
        <tr>
            <td colspan="1" style="text-align: center;">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        @endfor
    @endif

</table>

<!-- Nota -->
<div style="margin-top: 3px; font-size: 7pt;">
    <strong>Nota:</strong><br>
    * Sila gunakan lampiran jika Maklumat Sub Komponen diperolehi bagi kuantiti yang melebihi 1.<br>
    ** Maklumat Spesifikasi diisi merujuk kepada Kategori Aset Khusus yang telah dan berkaitan spesifikasi sahaja.
</div>

            <!-- Muka Surat -->
            <div class="page-number"></div>
        </div>
    </div>
    @endforeach
@endforeach

</body>
</html>