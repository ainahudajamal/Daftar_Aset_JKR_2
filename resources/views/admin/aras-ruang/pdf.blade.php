<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>DA5 - Konfigurasi Aras dan Ruang</title>
    <style>
        /* ============================================================
           DomPDF-SAFE CSS — No flexbox, no grid, table-based layouts
           A4 Landscape: 297mm x 210mm
           Usable area (after 15mm margins): ~267mm x 180mm
        ============================================================ */

        @page {
            size: A4 landscape;
            margin: 12mm 15mm 12mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8.5pt;
            color: #1a1a1a;
            background: #fff;
            width: 100%;
        }

        /* ===== TOP HEADER BAND ===== */
        .header-band {
            width: 100%;
            border-bottom: 3px solid #1e3a5f;
            padding-bottom: 6px;
            margin-bottom: 7px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .header-logo-cell {
            width: 60px;
            text-align: left;
        }

        .header-logo-box {
            width: 50px;
            height: 50px;
            border: 2px solid #1e3a5f;
            text-align: center;
            line-height: 50px;
            font-size: 7pt;
            font-weight: bold;
            color: #1e3a5f;
            background: #eef2ff;
        }

        .header-title-cell {
            text-align: center;
            vertical-align: middle;
        }

        .header-org {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e3a5f;
            text-decoration: underline;
        }

        .header-subtitle {
            font-size: 9pt;
            color: #333;
            margin-top: 3px;
        }

        .header-code-cell {
            width: 70px;
            text-align: right;
            vertical-align: top;
        }

        .doc-code-box {
            display: inline-block;
            border: 2px solid #1e3a5f;
            background: #1e3a5f;
            color: #fff;
            font-size: 11pt;
            font-weight: bold;
            padding: 4px 10px;
            letter-spacing: 1px;
        }

        /* ===== META INFO BAR ===== */
        .meta-bar {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000000;
            background: #f0f4fa;
            margin-bottom: 15px;
        }

        .meta-bar td {
            border: none;
            padding: 7px 10px;
            font-size: 8.5pt;
            vertical-align: middle;
            white-space: nowrap;
        }

        .meta-label {
            font-weight: bold;
            color: #1e3a5f;
        }

        .meta-sep {
            color: #555;
            padding: 7px 2px;
        }

        .meta-value {
            color: #222;
        }

        .meta-divider {
            border-left: 1px solid #000000 !important;
        }

        /* ===== SECTION HEADING ===== */
        .section-heading {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000000;
            margin-bottom: 0;
        }

        .section-heading td {
            padding: 8px 12px;
            font-size: 9.5pt;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .section-aras-bg  { background-color: #1e3a5f; }
        .section-ruang-bg { background-color: #14532d; }

        .section-badge {
            display: inline-block;
            background: rgba(255,255,255,0.25);
            border: 1px solid rgba(255,255,255,0.4);
            padding: 2px 8px;
            font-size: 8pt;
            margin-right: 8px;
            vertical-align: middle;
        }

        /* ===== DATA TABLE ===== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 0;
            border: 1px solid #000000;
        }

        .data-table th {
            background-color: #2d3748;
            color: #fff;
            border: 1px solid #000000;
            padding: 8px 10px;
            font-size: 8.5pt;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .data-table td {
            border: 1px solid #000000;
            padding: 8px 10px;
            font-size: 8.5pt;
            vertical-align: middle;
        }

        .data-table tbody tr:nth-child(even) td {
            background-color: #f5f7fb;
        }

        .data-table tbody tr:nth-child(odd) td {
            background-color: #fff;
        }

        /* Column widths — Aras table — must sum to 100% */
        .col-no    { width: 4%;  text-align: center; color: #666; }
        .col-blok  { width: 20%; }
        .col-aras-cell { width: 24%; }
        .col-kod   { width: 9%;  text-align: center; font-family: 'Courier New', monospace; font-weight: bold; font-size: 9pt; }
        .col-nama  { width: 49%; }

        /* Column widths — Ruang table — must sum to 100% */
        .col-ruang-aras { width: 24%; }
        .col-ruang-kod  { width: 9%;  text-align: center; font-family: 'Courier New', monospace; font-weight: bold; font-size: 9pt; }
        .col-ruang-nama { width: 49%; }

        .col-status { width: 9%;  text-align: center; }

        .badge-aktif {
            color: #14532d;
            font-weight: bold;
            font-size: 8pt;
        }

        .badge-inactive {
            color: #666;
            font-size: 8pt;
        }

        .blok-code {
            font-weight: bold;
            color: #1e3a5f;
        }

        .aras-code {
            font-weight: bold;
            color: #14532d;
        }

        .empty-row td {
            text-align: center;
            padding: 12px;
            color: #888;
            font-style: italic;
            background: #fafafa;
        }

        /* ===== SUMMARY ROW ===== */
        .summary-row {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000000;
            border-top: 2px solid #000000;
            background: #eef2fa;
            margin-bottom: 15px;
        }

        .summary-row td {
            border: none;
            border-right: 1px solid #000000;
            padding: 8px 10px;
            font-size: 8.5pt;
            white-space: nowrap;
        }

        .summary-row td:last-child {
            border-right: none;
        }

        .sum-label { font-weight: bold; color: #333; }
        .sum-val   { color: #1e3a5f; font-weight: bold; }

        /* ===== SECTION SEPARATOR ===== */
        .section-gap {
            height: 15px;
        }

        /* ===== FILTER TAG ===== */
        .filter-tag {
            font-size: 8pt;
            color: #444;
            font-style: italic;
            padding: 4px 0 6px 4px;
        }

        /* ===== SIGNATURE SECTION ===== */
        .sig-section {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .sig-section > tbody > tr > td {
            border: none;
            width: 50%;
            vertical-align: top;
            padding: 0 12px 0 0;
        }

        .sig-section > tbody > tr > td:last-child {
            padding: 0 0 0 12px;
        }

        .sig-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e3a5f;
            border-bottom: 2.5px solid #000000;
            padding-bottom: 4px;
            margin-bottom: 5px;
        }

        .sig-inner {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000000;
        }

        .sig-inner td {
            border: none;
            border-bottom: 1px solid #000000;
            padding: 0;
            font-size: 8.5pt;
            vertical-align: middle;
        }

        .sig-inner tr:last-child td {
            border-bottom: none;
        }

        .sig-label-td {
            width: 90px;
            padding: 8px 10px;
            white-space: nowrap;
            color: #333;
            background: #f5f7fb;
            border-right: 1px solid #000000 !important;
            font-weight: bold;
        }

        .sig-value-td {
            padding: 8px 10px;
        }

        .sig-sign-row td {
            height: 60px;
        }

        /* ===== FOOTER ===== */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border-top: 1.5px solid #000000;
            padding-top: 5px;
        }

        .footer-table td {
            border: none;
            padding: 6px 0;
            font-size: 8pt;
        }

        .footer-left {
            color: #666;
            font-style: italic;
        }

        .footer-right {
            text-align: right;
            color: #333;
        }

        .page-box {
            display: inline-block;
            border: 1.5px solid #000000;
            padding: 3px 12px;
            font-size: 8pt;
            font-weight: bold;
        }

        /* ===== PAGE BREAK ===== */
        .page-break-after  { page-break-after: always; }
        .page-break-before { page-break-before: always; }
        .no-break { page-break-inside: avoid; }
    </style>
</head>
<body>

{{-- ================================================================
     DOCUMENT HEADER
================================================================ --}}
<table class="header-table">
    <tr>
        <td class="header-logo-cell">
            <div class="header-logo-box">JKR</div>
        </td>
        <td class="header-title-cell">
            <div class="header-org">Jabatan Kerja Raya Malaysia</div>
            <div class="header-subtitle">Senarai Konfigurasi Aras dan Ruang</div>
        </td>
        <td class="header-code-cell">
            <div class="doc-code-box">D.A 5</div>
        </td>
    </tr>
</table>
<div class="header-band"></div>

{{-- ================================================================
     META INFO BAR
================================================================ --}}
<table class="meta-bar">
    <tr>
        <td class="meta-label">Tarikh Cetak</td>
        <td class="meta-sep">:</td>
        <td class="meta-value">{{ now()->format('d/m/Y  H:i') }}</td>
        <td class="meta-divider meta-label">Jumlah Aras</td>
        <td class="meta-sep">:</td>
        <td class="meta-value"><strong>{{ $arasAll->count() }}</strong> rekod</td>
        <td class="meta-divider meta-label">Jumlah Ruang</td>
        <td class="meta-sep">:</td>
        <td class="meta-value"><strong>{{ $ruangsAll->count() }}</strong> rekod</td>
        @if($filterInfo)
        <td class="meta-divider meta-label">Penapis</td>
        <td class="meta-sep">:</td>
        <td class="meta-value" style="font-style:italic;">{{ $filterInfo }}</td>
        @endif
    </tr>
</table>

{{-- ================================================================
     BAHAGIAN 1 : SENARAI ARAS
================================================================ --}}
<div class="no-break">
    <table class="section-heading">
        <tr>
            <td class="section-aras-bg">
                <span class="section-badge">BAHAGIAN 1</span>
                SENARAI ARAS (TINGKAT / LEVEL)
            </td>
        </tr>
    </table>

    @if($filterArasBlok || $filterArasStatus)
    <div class="filter-tag">Penapis: {{ implode(' | ', array_filter([$filterArasBlok ? 'Blok: '.$filterArasBlok : '', $filterArasStatus ? 'Status: '.$filterArasStatus : ''])) }}</div>
    @endif

    <table class="data-table">
        <colgroup>
            <col style="width:4%">
            <col style="width:20%">
            <col style="width:9%">
            <col style="width:58%">
            <col style="width:9%">
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th style="text-align:left;">Blok</th>
                <th>Kod Aras</th>
                <th style="text-align:left;">Nama Aras</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arasAll as $i => $item)
            <tr>
                <td class="col-no">{{ $i + 1 }}</td>
                <td>
                    @if($item->blok)
                        <span class="blok-code">{{ $item->blok->kod }}</span>
                        &nbsp;{{ $item->blok->nama }}
                    @else
                        <span style="color:#bbb;">—</span>
                    @endif
                </td>
                <td class="col-kod">{{ $item->kod }}</td>
                <td>{{ $item->nama }}</td>
                <td class="col-status">
                    @if($item->is_active)
                        <span class="badge-aktif">Aktif</span>
                    @else
                        <span class="badge-inactive">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="5">Tiada rekod aras dijumpai</td></tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary-row">
        <tr>
            <td><span class="sum-label">Jumlah:</span> <span class="sum-val">{{ $arasAll->count() }} rekod</span></td>
            <td><span class="sum-label">Aktif:</span> <span class="sum-val">{{ $arasAll->where('is_active', true)->count() }}</span></td>
            <td><span class="sum-label">Tidak Aktif:</span> <span class="sum-val">{{ $arasAll->where('is_active', false)->count() }}</span></td>
            <td><span class="sum-label">Bilangan Blok:</span> <span class="sum-val">{{ $arasAll->pluck('blok_id')->filter()->unique()->count() }}</span></td>
            <td style="width:100%;"></td>
        </tr>
    </table>
</div>

<div class="section-gap"></div>

{{-- ================================================================
     BAHAGIAN 2 : SENARAI RUANG
================================================================ --}}
<div class="no-break">
    <table class="section-heading">
        <tr>
            <td class="section-ruang-bg">
                <span class="section-badge">BAHAGIAN 2</span>
                SENARAI RUANG (BILIK / RUANGAN)
            </td>
        </tr>
    </table>

    @if($filterRuangAras || $filterRuangStatus)
    <div class="filter-tag">Penapis: {{ implode(' | ', array_filter([$filterRuangAras ? 'Aras: '.$filterRuangAras : '', $filterRuangStatus ? 'Status: '.$filterRuangStatus : ''])) }}</div>
    @endif

    <table class="data-table">
        <colgroup>
            <col style="width:4%">
            <col style="width:24%">
            <col style="width:9%">
            <col style="width:54%">
            <col style="width:9%">
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th style="text-align:left;">Aras</th>
                <th>Kod Ruang</th>
                <th style="text-align:left;">Nama Ruang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruangsAll as $i => $ruang)
            <tr>
                <td class="col-no">{{ $i + 1 }}</td>
                <td>
                    @if($ruang->aras)
                        <span class="aras-code">{{ $ruang->aras->kod }}</span>
                        &nbsp;{{ $ruang->aras->nama }}
                    @else
                        <span style="color:#bbb;">—</span>
                    @endif
                </td>
                <td class="col-kod">{{ $ruang->kod }}</td>
                <td>{{ $ruang->nama }}</td>
                <td class="col-status">
                    @if($ruang->is_active)
                        <span class="badge-aktif">Aktif</span>
                    @else
                        <span class="badge-inactive">Tidak Aktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="5">Tiada rekod ruang dijumpai</td></tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary-row">
        <tr>
            <td><span class="sum-label">Jumlah:</span> <span class="sum-val">{{ $ruangsAll->count() }} rekod</span></td>
            <td><span class="sum-label">Aktif:</span> <span class="sum-val">{{ $ruangsAll->where('is_active', true)->count() }}</span></td>
            <td><span class="sum-label">Tidak Aktif:</span> <span class="sum-val">{{ $ruangsAll->where('is_active', false)->count() }}</span></td>
            <td><span class="sum-label">Bilangan Aras:</span> <span class="sum-val">{{ $ruangsAll->pluck('aras_id')->filter()->unique()->count() }}</span></td>
            <td style="width:100%;"></td>
        </tr>
    </table>
</div>

{{-- ================================================================
     SIGNATURE SECTION — pure <table> for DomPDF compatibility
================================================================ --}}
<table class="sig-section">
    <tr>
        <td style="width:50%; padding-right:12px; vertical-align:top;">
            <div class="sig-title">Disediakan Oleh :</div>
            <table class="sig-inner">
                <tr class="sig-sign-row">
                    <td class="sig-label-td">Tandatangan</td>
                    <td class="sig-value-td"></td>
                </tr>
                <tr>
                    <td class="sig-label-td">Nama</td>
                    <td class="sig-value-td"></td>
                </tr>
                <tr>
                    <td class="sig-label-td">Jawatan</td>
                    <td class="sig-value-td"></td>
                </tr>
                <tr>
                    <td class="sig-label-td">Tarikh</td>
                    <td class="sig-value-td"></td>
                </tr>
            </table>
        </td>
        <td style="width:50%; padding-left:12px; vertical-align:top;">
            <div class="sig-title">Disahkan Oleh :</div>
            <table class="sig-inner">
                <tr class="sig-sign-row">
                    <td class="sig-label-td">Tandatangan</td>
                    <td class="sig-value-td"></td>
                </tr>
                <tr>
                    <td class="sig-label-td">Nama</td>
                    <td class="sig-value-td"></td>
                </tr>
                <tr>
                    <td class="sig-label-td">Jawatan</td>
                    <td class="sig-value-td"></td>
                </tr>
                <tr>
                    <td class="sig-label-td">Tarikh</td>
                    <td class="sig-value-td"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ================================================================
     FOOTER
================================================================ --}}
<table class="footer-table">
    <tr>
        <td class="footer-left" style="width:70%;">
            Dijana oleh Sistem Daftar Aset JKR &mdash; {{ now()->format('d/m/Y H:i:s') }}
        </td>
        <td class="footer-right" style="width:30%;">
            <span class="page-box">Muka Surat 1 dari 1</span>
        </td>
    </tr>
</table>

</body>
</html>
