<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Borang 2 - Komponen Utama</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'DejaVu Sans', 'sans-serif';
            font-size: 7pt;
            line-height: 1.0;
            color: #000;
            padding: 8mm;
            background: #fff;
        }
        
        .page-wrapper {
            transform: scale(0.85);
            transform-origin: top center;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 4px;
            border-bottom: 2px solid #ffffffff;
            padding-bottom: 2px;
        }
        
        .page-header h1 {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 1px;
            text-decoration: underline;
        }
        
        .page-header h2 {
            font-size: 8pt;
            font-weight: normal;
            text-decoration: underline;
        }
        
        .section-title {
            background-color: #000;
            color: white;
            padding: 2px 4px;
            font-weight: bold;
            font-size: 7pt;
            margin-top: 2px;
            margin-bottom: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        
        table td {
            border: 1px solid #000;
            padding: 1px 3px;
            vertical-align: top;
            font-size: 7pt;
        }
        
        .label-cell {
            background-color: #f5f5f5;
            font-weight: normal;
            width: 25%;
        }
        
        .value-cell {
            background-color: #fff;
        }
        
        .checkbox-row {
            padding: 2px 4px;
        }
        
        .checkbox {
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
        
        .inline-field {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 80px;
            padding: 0 3px;
        }
        
        div > strong {
            font-size: 7pt;
        }
        
        @media print {
            body { 
                padding: 8mm;
            }
            .page-wrapper { 
                transform: scale(0.95);
                page-break-inside: avoid;
            }
            @page {
                size: A4;
                margin: 8mm;
            }
        }
    </style>
</head>
<body>
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
        <td>
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
<div style="margin-top: 4px; text-align: right; font-size: 7pt; font-style: italic; border: 1px solid #000; padding: 3px 8px; display: inline-block; float: right;">
    Muka surat _____ dari _____
</div>

</div>
</body>
</html>