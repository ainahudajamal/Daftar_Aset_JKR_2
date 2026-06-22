<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>D.A.5 — Borang Pengumpulan Data Daftar Aset Khusus (DAK)</title>
<style>
/* ===== Reset ===== */
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, sans-serif; font-size: 11px; color: #000; line-height: 1.3; }

/* ===== Helpers ===== */
.bold      { font-weight: bold; }
.underline { text-decoration: underline; }
.italic    { font-style: italic; }
.center    { text-align: center; }
.right     { text-align: right; }
.strike    { text-decoration: line-through; }

/* ===== Helaian badge ===== */
.h-wrap  { text-align: right; margin-bottom: 2px; }
.h-badge { border: 1px solid #000; padding: 2px 10px; font-style: italic; font-size: 10px; display: inline-block; }

/* ===== Input field types ===== */
/* Full-border box */
.fb { border: 1px solid #000; height: 20px; width: 100%; box-sizing: border-box; display: block; }
/* Bottom-border only (underline field) */
.fline { border-bottom: 1px solid #000; height: 16px; width: 100%; display: block; }
/* Small checkbox box */
.small-box { border: 1px solid #000; width: 15px; height: 15px; display: inline-block; vertical-align: middle; margin-right: 4px; }

/* ===== Form layout table ===== */
.ft    { width: 100%; border-collapse: collapse; }
.ft td { vertical-align: middle; padding: 4px 2px; border: none; font-size: 11px; }
.lbl   { white-space: nowrap; }
.cln   { width: 10px; text-align: center; padding: 0 2px !important; white-space: nowrap; }

/* ===== Data grid table ===== */
.dt    { width: 100%; border-collapse: collapse; table-layout: fixed; }
.dt th {
    border: 1px solid #000;
    background-color: #d9d9d9;
    font-weight: bold;
    font-size: 10px;
    text-align: center;
    vertical-align: middle;
    padding: 10px 8px;
    line-height: 1.25;
}
.dt td {
    border: 1px solid #000;
    font-size: 10px;
    vertical-align: middle;
    padding: 0 3px;
    height: 28px;
}
.dt td.c { text-align: center; }

/* ===== Section heading ===== */
.sec { font-weight: bold; text-decoration: underline; font-size: 12px; text-transform: uppercase; margin-bottom: 4px; }

/* ===== Signature ===== */
.sig-box  { border: 1px solid #000; height: 35px; display: block; }
.sig-line { border-bottom: 1px solid #000; height: 16px; display: block; }
.sig-head { font-weight: bold; text-align: center; text-transform: uppercase; margin-bottom: 3px; }

/* ===== Hint text inside boxes ===== */
.hint { font-style: italic; font-size: 9px; color: #555; white-space: nowrap; vertical-align: middle; }
</style>
</head>
<body>

{{-- ================================================================
     HELAIAN 1  —  Portrait A4
     MAKLUMAT PREMIS + MAKLUMAT BLOK/BINAAN LUAR + DATA FIELDS
================================================================ --}}
@php
    $dpaStr = str_replace(' ', '', $da5_data['no_dpa'] ?? '');
    $dpaChars = str_split($dpaStr);

    $kontraktorList = $da5_data['kontraktor_list'] ?? [];
    $perundingList = $da5_data['juru_perunding_list'] ?? [];

    $tarikhSiapBinaFormatted = '';
    if (!empty($da5_data['tarikh_siap_bina'])) {
        $tarikhSiapBinaFormatted = date('d/m/Y', strtotime($da5_data['tarikh_siap_bina']));
    }

    $tarikhPenilaianFormatted = '';
    if (!empty($da5_data['tarikh_penilaian'])) {
        $tarikhPenilaianFormatted = date('d/m/Y', strtotime($da5_data['tarikh_penilaian']));
    }

    $kosBinaAsalFormatted = '';
    if (isset($da5_data['kos_bina_asal']) && $da5_data['kos_bina_asal'] !== '') {
        $kosBinaAsalFormatted = number_format((float)$da5_data['kos_bina_asal'], 2);
    }

    $nilaiSemasaFormatted = '';
    if (isset($da5_data['nilai_semasa']) && $da5_data['nilai_semasa'] !== '') {
        $nilaiSemasaFormatted = number_format((float)$da5_data['nilai_semasa'], 2);
    }

    $penggunaanTenagaFormatted = '';
    if (isset($da5_data['penggunaan_tenaga']) && $da5_data['penggunaan_tenaga'] !== '') {
        $penggunaanTenagaFormatted = number_format((float)$da5_data['penggunaan_tenaga'], 2);
    }

    $penggunaanAirFormatted = '';
    if (isset($da5_data['penggunaan_air']) && $da5_data['penggunaan_air'] !== '') {
        $penggunaanAirFormatted = number_format((float)$da5_data['penggunaan_air'], 2);
    }

    $jumlahLuasLantaiFormatted = '';
    if (isset($da5_data['jumlah_luas_lantai']) && $da5_data['jumlah_luas_lantai'] !== '') {
        $jumlahLuasLantaiFormatted = number_format((float)$da5_data['jumlah_luas_lantai'], 2);
    }

    $luasTapakFormatted = '';
    if (isset($da5_data['luas_tapak']) && $da5_data['luas_tapak'] !== '') {
        $luasTapakFormatted = number_format((float)$da5_data['luas_tapak'], 2);
    }
@endphp

<div class="h-wrap"><span class="h-badge">helaian 1</span></div>
<div style="text-align:right; font-weight:bold; font-size:12px; margin-bottom:3px;">D.A. 5 (JKR.PATA.F6/12 rev 1)</div>
<div style="text-align:center; font-weight:bold; text-decoration:underline; font-size:14px; margin-bottom:12px; text-transform:uppercase;">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS (DAK)</div>

{{-- ── MAKLUMAT PREMIS ── --}}
<div class="sec">MAKLUMAT PREMIS</div>

{{-- Nama Premis : underline field --}}
<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:82px;">Nama Premis</td>
    <td class="cln">:</td>
    <td><div class="fline" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['nama_premis'] ?? '' }}</div></td>
  </tr>
</table>

{{-- No. DPA : 24 individual bordered cells (nested table) --}}
<table class="ft" style="margin-bottom:10px;">
  <tr>
    <td class="lbl" style="width:82px;">No. DPA</td>
    <td class="cln">:</td>
    <td>
      <table style="border-collapse:collapse; margin:0; padding:0; font-size:0;">
        <tr>
          @for ($i = 0; $i < 24; $i++)
          <td style="border:1px solid #000; width:18px; height:22px; padding:0; font-size:11px; text-align:center; vertical-align:middle; line-height:22px; font-family: monospace; font-weight: bold;">
            {{ $dpaChars[$i] ?? '' }}
          </td>
          @endfor
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- ── Maklumat Blok / Binaan Luar heading ── --}}
<div style="text-align:center; font-weight:bold; font-size:12px; margin-bottom:6px;">Maklumat Blok / Binaan Luar</div>

{{-- Kod Blok/ Binaan Luar : bordered box (fixed width ~160px) --}}
<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:132px;">Kod Blok/ Binaan Luar</td>
    <td class="cln">:</td>
    <td style="width:162px;"><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['kod_blok'] ?? '' }}</div></td>
    <td></td>
  </tr>
</table>

{{-- Nama Blok/ Binaan Luar : label wraps 2 lines, underline field --}}
<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:132px; vertical-align:top; padding-top:2px;">Nama Blok/ Binaan<br>Luar</td>
    <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
    <td><div class="fline" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['nama_blok'] ?? '' }}</div></td>
  </tr>
</table>

{{-- Fungsi Binaan (Blok) | Jenis Binaan Luar — 2 bordered boxes side-by-side --}}
<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:132px;">Fungsi Binaan (Blok)</td>
    <td class="cln">:</td>
    <td style="width:152px;"><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['fungsi_binaan'] ?? '' }}</div></td>
    <td style="width:12px;"></td>
    <td class="lbl" style="width:100px;">Jenis Binaan Luar</td>
    <td class="cln">:</td>
    <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['jenis_binaan'] ?? '' }}</div></td>
  </tr>
</table>

{{-- Koordinat GPS : X underline ; Y underline  (nested table, td border-bottom) --}}
<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td class="lbl" style="width:132px;">Koordinat GPS</td>
    <td class="cln">:</td>
    <td>
      <table style="border-collapse:collapse; font-size:11px;">
        <tr>
          <td style="border:none; font-weight:bold; padding:0 4px 0 0; white-space:nowrap;">X:</td>
          <td style="border:none; border-bottom:1px solid #000; width:150px; height:22px; padding-left: 5px; font-weight: bold;">{{ $da5_data['gps_x'] ?? '' }}</td>
          <td style="border:none; font-weight:bold; padding:0 5px; white-space:nowrap;">;</td>
          <td style="border:none; font-weight:bold; padding:0 4px 0 0; white-space:nowrap;">Y:</td>
          <td style="border:none; border-bottom:1px solid #000; width:150px; height:22px; padding-left: 5px; font-weight: bold;">{{ $da5_data['gps_y'] ?? '' }}</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- ── Kontraktor section (2 columns) ── --}}
{{-- Row A: Kontraktor Utama | Bidang Kerja --}}
<table class="ft" style="margin-bottom:2px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">Kontraktor Utama</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['kontraktor_utama'] ?? '' }}</div></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:78px;">Bidang Kerja</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['bidang_kontraktor_utama'] ?? '' }}</div></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Row B: *Kontraktor 2-row box | *Bidang Kerja 2-row box --}}
<table class="ft" style="margin-bottom:4px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">*Kontraktor</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr><td style="height:22px; padding:0 4px; border-bottom:1px solid #000; font-size:11px; vertical-align:middle; font-weight: bold;">1. {{ $kontraktorList[0]['nama'] ?? '' }}</td></tr>
              <tr><td style="height:22px; padding:0 4px; font-size:11px; vertical-align:middle; font-weight: bold;">2. {{ $kontraktorList[1]['nama'] ?? '' }}</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:78px;">*Bidang Kerja</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr><td style="height:22px; padding:0 4px; border-bottom:1px solid #000; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $kontraktorList[0]['bidang'] ?? '' }}</td></tr>
              <tr><td style="height:22px; padding:0 4px; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $kontraktorList[1]['bidang'] ?? '' }}</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- ── Juru Perunding section (2 columns) ── --}}
{{-- Row A: Juru Perunding Utama | Bidang Kerja --}}
<table class="ft" style="margin-bottom:2px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">Juru Perunding Utama</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['juru_perunding_utama'] ?? '' }}</div></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:78px;">Bidang Kerja</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['bidang_juru_perunding_utama'] ?? '' }}</div></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Row B: *Juru Perunding 2-row box | *Bidang Kerja 2-row box --}}
<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">*Juru Perunding</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr><td style="height:22px; padding:0 4px; border-bottom:1px solid #000; font-size:11px; vertical-align:middle; font-weight: bold;">1. {{ $perundingList[0]['nama'] ?? '' }}</td></tr>
              <tr><td style="height:22px; padding:0 4px; font-size:11px; vertical-align:middle; font-weight: bold;">2. {{ $perundingList[1]['nama'] ?? '' }}</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:78px;">*Bidang Kerja</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr><td style="height:22px; padding:0 4px; border-bottom:1px solid #000; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $perundingList[0]['bidang'] ?? '' }}</td></tr>
              <tr><td style="height:22px; padding:0 4px; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $perundingList[1]['bidang'] ?? '' }}</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div style="font-style:italic; font-size:9.5px; margin-bottom:8px;">Nota: *Sila sediakan lampiran jika ada tambahan</div>

{{-- ── Bottom two-column data fields (8 rows × 2 columns) ── --}}
<table class="ft">
  <tr>
    {{-- Left column --}}
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:148px;">Tahun Siap Bina Asal</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['tahun_siap_bina'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Tarikh Siap Bina Asal</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:22px; padding:0 5px; width:50%; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $tarikhSiapBinaFormatted }}</td>
                <td class="hint" style="padding-right:3px; text-align:right;">( hh / bb / tttt )</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Fungsi Asal</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['fungsi_asal'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Jenis Struktur (blok)</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['jenis_struktur'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">No. Siri Pendaftaran</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['no_siri_pendaftaran'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Jangka hayat (Tahun)</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['jangka_hayat'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Kapasiti Penghuni Asal</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['kapasiti_penghuni'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Kos Bina Asal (RM)</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $kosBinaAsalFormatted }}</div></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    {{-- Right column --}}
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">Nilai Semasa (RM)</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $nilaiSemasaFormatted }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Tahun Penilaian</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:22px; padding:0 5px; width:40%; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $tarikhPenilaianFormatted }}</td>
                <td class="hint" style="padding-right:3px; text-align:right;">( hh / bb / tttt )</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Sumber Pembiayaan</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['sumber_pembiayaan'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Kod PTJ</td>
          <td class="cln">:</td>
          <td><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['kod_ptj'] ?? '' }}</div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Penggunaan Tenaga</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:22px; padding:0 5px; width:30%; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $penggunaanTenagaFormatted }}</td>
                <td class="hint" style="padding-right:3px; text-align:right;">(kiloWatt/jam/tahun)</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Penggunaan Air</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:22px; padding:0 5px; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $penggunaanAirFormatted }}</td>
                <td class="hint" style="padding-right:3px; text-align:right;">m&#179;/tahun</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px; vertical-align:top; padding-top:2px;">Jenis Milikan</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td style="padding:2px 1px; line-height:1.4; font-weight: bold;">
            @if(($da5_data['jenis_milikan'] ?? '') === 'Pajakan')
              <u>Pajakan</u> / <span style="text-decoration: line-through; font-weight: normal; color: #555;">Pegangan Bebas</span>
            @elseif(($da5_data['jenis_milikan'] ?? '') === 'Pegangan Bebas')
              <span style="text-decoration: line-through; font-weight: normal; color: #555;">Pajakan</span> / <u>Pegangan Bebas</u>
            @else
              Pajakan / Pegangan Bebas
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>


{{-- ================================================================
     HELAIAN 2  —  Portrait A4
     ASET WARISAN / STATUS / BIL. ARAS / GAMBAR BLOK / SENARAI LUKISAN
================================================================ --}}
<pagebreak orientation="portrait" sheet-size="A4" />

<div class="h-wrap"><span class="h-badge">helaian 2</span></div>

<div style="height:10px;"></div>

{{-- Row 1: Aset Warisan (checkbox) | Status Blok / Binaan Luar --}}
<table class="ft" style="margin-bottom:8px;">
  <tr>
    <td style="width:50%; vertical-align:middle;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:85px;">Aset Warisan</td>
          <td class="cln">:</td>
          <td style="vertical-align:middle;">
            <span class="small-box" style="text-align:center; line-height:12px; font-weight:bold; font-size:12px;">
              {{ ($da5_data['aset_warisan'] ?? '') == '1' ? '✓' : '' }}
            </span>
            <span style="font-style:italic; font-size:9.5px; vertical-align:middle;">(tandakan jika Ya)</span>
          </td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:128px; vertical-align:top;">Status Blok /<br>Binaan Luar</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td style="padding:2px 1px; font-weight: bold;">
            @if(($da5_data['status_blok'] ?? '') === 'aktif')
              <u>Aktif</u> / <span style="text-decoration: line-through; font-weight: normal; color: #555;">Tidak Aktif</span>
            @elseif(($da5_data['status_blok'] ?? '') === 'tidak_aktif')
              <span style="text-decoration: line-through; font-weight: normal; color: #555;">Aktif</span> / <u>Tidak Aktif</u>
            @else
              Aktif / Tidak Aktif
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Row 2: Bil. Aras Atas Tanah | Jumlah Luas Lantai Blok --}}
<table class="ft" style="margin-bottom:4px;">
  <tr>
    <td style="width:50%; vertical-align:middle;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:152px;">** Bil. Aras Atas Tanah</td>
          <td class="cln">:</td>
          <td style="width:115px;"><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['bil_aras_atas'] ?? '' }}</div></td>
          <td></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:128px; vertical-align:top;">** Jumlah Luas<br>&nbsp;&nbsp;&nbsp;Lantai Blok</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:22px; padding:0 5px; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $jumlahLuasLantaiFormatted }}</td>
                <td style="text-align:right; padding-right:4px; font-size:11px; white-space:nowrap; width:25px;">m&#178;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Row 3: Bil. Aras Bawah Tanah (label wraps) | Luas Tapak Blok (label wraps) --}}
<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:152px; vertical-align:top;">** Bil. Aras Bawah<br>&nbsp;&nbsp;&nbsp;&nbsp;Tanah</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td style="width:115px;"><div class="fb" style="padding-left: 5px; line-height: 20px; font-weight: bold;">{{ $da5_data['bil_aras_bawah'] ?? '' }}</div></td>
          <td></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:128px; vertical-align:top;">Luas Tapak Blok /<br>&nbsp;&nbsp;Binaan Luar</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:22px; padding:0 5px; font-size:11px; vertical-align:middle; font-weight: bold;">{{ $luasTapakFormatted }}</td>
                <td style="text-align:right; padding-right:4px; font-size:11px; white-space:nowrap; width:25px;">m&#178;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Note --}}
<div style="font-style:italic; font-size:9.5px; margin-bottom:12px; line-height:1.5;">
  **Diisi sekiranya binaan&nbsp; luar merupakan blok<br>
  &nbsp;&nbsp;&nbsp;(mempunyai aras dan ruang).
</div>

{{-- Gambar Blok / Binaan Luar (bold label, wraps 2 lines) --}}
<table class="ft" style="margin-bottom:14px;">
  <tr>
    <td class="lbl bold" style="width:128px; vertical-align:top; padding-top:1px;">Gambar Blok / Binaan<br>Luar</td>
    <td class="cln" style="vertical-align:top; padding-top:1px;">:</td>
    <td style="font-size:11px; line-height:1.5;">
      Pastikan dua (2) gambar blok diambil (pandangan sudut hadapan dan
      pandangan sudut belakang) bagi setiap blok/ binaan luar dan dimuat naik ke
      dalam aplikasi mySPATA
    </td>
  </tr>
</table>

{{-- Senarai Lukisan Siap Bina (plain centered, bold) --}}
<div style="text-align:center; font-weight:bold; font-size:11px; margin-bottom:5px;">Senarai Lukisan Siap Bina</div>

<table class="dt" style="margin-bottom:50px;">
  <colgroup>
    <col style="width:7%;">
    <col style="width:17%;">
    <col style="width:40%;">
    <col style="width:18%;">
    <col style="width:18%;">
  </colgroup>
  <thead>
    <tr>
      <th>Bil</th>
      <th>Bidang</th>
      <th>Tajuk Lukisan</th>
      <th>No Rujukan</th>
      <th>Catatan</th>
    </tr>
  </thead>
  <tbody>
    @php
      $lukisanList = $da5_data['lukisan_list'] ?? [];
    @endphp
    @for ($i = 0; $i < 9; $i++)
    @php
      $l = $lukisanList[$i] ?? null;
    @endphp
    <tr>
      <td style="height:32px;" class="center">{{ $i + 1 }}</td>
      <td style="padding-left: 5px; font-weight: bold;">{{ $l['bidang'] ?? '' }}</td>
      <td style="padding-left: 5px; font-weight: bold;">{{ $l['tajuk'] ?? '' }}</td>
      <td style="padding-left: 5px; font-weight: bold;">{{ $l['no_rujukan'] ?? '' }}</td>
      <td style="padding-left: 5px; font-weight: bold;">{{ $l['catatan'] ?? '' }}</td>
    </tr>
    @endfor
  </tbody>
</table>

{{-- Muka surat footer --}}
<table class="ft" style="margin-top:8px;">
  <tr>
    <td></td>
    <td style="text-align:right; font-size:10px; white-space:nowrap; width:auto;">
      Muka surat
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
      dari
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
    </td>
  </tr>
</table>


@if(!empty($gambarHadapanPath) || !empty($gambarBelakangPath))
<pagebreak orientation="portrait" sheet-size="A4" />

<div class="h-wrap"><span class="h-badge">helaian 2a</span></div>
<div style="text-align:right; font-weight:bold; font-size:12px; margin-bottom:3px;">D.A. 5 (JKR.PATA.F6/12 rev 1)</div>
<div style="text-align:center; font-weight:bold; text-decoration:underline; font-size:14px; margin-bottom:20px; text-transform:uppercase;">GAMBAR BLOK / BINAAN LUAR</div>

<table class="dt" style="width:100%; border-collapse:collapse; margin-top:20px; table-layout:fixed;">
  <colgroup>
    <col style="width:50%;">
    <col style="width:50%;">
  </colgroup>
  <tbody>
    <tr>
      <td style="text-align:center; padding:15px; border:1px solid #000; vertical-align:top; height:500px;">
        <div style="font-weight:bold; font-size:12px; margin-bottom:15px; text-decoration:underline;">PANDANGAN SUDUT HADAPAN</div>
        @if(!empty($gambarHadapanPath))
          <div style="margin-top:20px; text-align:center;">
            <img src="{{ $gambarHadapanPath }}" style="max-width:95%; max-height:430px; border:1px solid #000; padding:3px;">
          </div>
        @else
          <div style="margin-top:150px; color:#666; font-style:italic; font-size:12px;">Tiada Gambar Hadapan Dimuat Naik</div>
        @endif
      </td>
      <td style="text-align:center; padding:15px; border:1px solid #000; vertical-align:top; height:500px;">
        <div style="font-weight:bold; font-size:12px; margin-bottom:15px; text-decoration:underline;">PANDANGAN SUDUT BELAKANG</div>
        @if(!empty($gambarBelakangPath))
          <div style="margin-top:20px; text-align:center;">
            <img src="{{ $gambarBelakangPath }}" style="max-width:95%; max-height:430px; border:1px solid #000; padding:3px;">
          </div>
        @else
          <div style="margin-top:150px; color:#666; font-style:italic; font-size:12px;">Tiada Gambar Belakang Dimuat Naik</div>
        @endif
      </td>
    </tr>
  </tbody>
</table>

<table class="ft" style="margin-top:20px;">
  <tr>
    <td></td>
    <td style="text-align:right; font-size:10px; white-space:nowrap; width:auto;">
      Muka surat
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
      dari
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
    </td>
  </tr>
</table>
@endif


{{-- ================================================================
     HELAIAN 3  —  Landscape A4
     MAKLUMAT ARAS — 12-row table + signatures
================================================================ --}}
<pagebreak orientation="landscape" sheet-size="A4-L" />

<div class="h-wrap"><span class="h-badge">helaian 3</span></div>

<div class="sec">MAKLUMAT ARAS</div>

{{-- Blok / Aras / Nama Aras header row --}}
<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td class="lbl bold" style="width:28px;">Blok</td>
    <td class="cln">:</td>
    <td style="width:62px;"><div class="fb"></div></td>
    <td style="width:14px;"></td>
    <td class="lbl bold" style="width:28px;">Aras</td>
    <td class="cln">:</td>
    <td style="width:126px;"><div class="fb"></div></td>
    <td style="width:18px;"></td>
    <td class="lbl bold" style="width:62px;">Nama Aras</td>
    <td class="cln">:</td>
    <td><div class="fb"></div></td>
  </tr>
</table>

{{-- Main data table — 2-row header --}}
<table class="dt">
  <colgroup>
    <col style="width:9%;">
    <col style="width:9%;">
    <col style="width:27%;">
    <col style="width:9%;">
    <col style="width:8%;">
    <col style="width:25%;">
    <col style="width:13%;">
  </colgroup>
  <thead>
    <tr>
      <th rowspan="2">KOD<br>RUANG</th>
      <th rowspan="2">KOD<br>SUB<br>RUANG</th>
      <th rowspan="2">NAMA RUANG</th>
      <th colspan="2">UKURAN RUANG</th>
      <th rowspan="2">FUNGSI RUANG</th>
      <th rowspan="2" style="font-size:10.5px; line-height:1.3;">
        KEMASAN<br>
        <span style="font-size:9px; font-weight:normal; font-style:italic;">(Jika ADA,<br>perlu diisi<br>helaian 4)</span>
      </th>
    </tr>
    <tr>
      <th>LUAS (m&#178;)</th>
      <th>TINGGI<br>(m)</th>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < 12; $i++)
    <tr>
      <td style="height:28px;"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="c" style="font-size:10px; white-space:nowrap;">ADA / TIADA</td>
    </tr>
    @endfor
  </tbody>
</table>

{{-- Signature section --}}
<table class="ft" style="margin-top:14px;">
  <tr>
    <td style="width:10%;"></td>
    <td style="width:38%; vertical-align:top;">
      <div class="sig-head">PENGUMPUL DATA :</div>
      <table class="ft">
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:120px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:4%;"></td>
    <td style="width:38%; vertical-align:top;">
      <div class="sig-head">PENGESAH DATA :</div>
      <table class="ft">
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:120px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:10%;"></td>
  </tr>
</table>

<table class="ft" style="margin-top:10px;">
  <tr>
    <td></td>
    <td style="text-align:right; font-size:10px; white-space:nowrap; width:auto;">
      Muka surat
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
      dari
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
    </td>
  </tr>
</table>


{{-- ================================================================
     HELAIAN 4  —  Landscape A4
     *MAKLUMAT KEMASAN DALAM RUANG — 13-row table + signatures
================================================================ --}}
<pagebreak orientation="landscape" sheet-size="A4-L" />

<div class="h-wrap"><span class="h-badge">helaian 4</span></div>

<div class="sec">*MAKLUMAT KEMASAN DALAM RUANG</div>

{{-- Blok / Aras / Nama Aras header row (same as page 3) --}}
<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td class="lbl bold" style="width:28px;">Blok</td>
    <td class="cln">:</td>
    <td style="width:62px;"><div class="fb"></div></td>
    <td style="width:14px;"></td>
    <td class="lbl bold" style="width:28px;">Aras</td>
    <td class="cln">:</td>
    <td style="width:126px;"><div class="fb"></div></td>
    <td style="width:18px;"></td>
    <td class="lbl bold" style="width:62px;">Nama Aras</td>
    <td class="cln">:</td>
    <td><div class="fb"></div></td>
  </tr>
</table>

{{-- Main data table — single header row --}}
<table class="dt">
  <colgroup>
    <col style="width:8%;">
    <col style="width:23%;">
    <col style="width:9%;">
    <col style="width:22%;">
    <col style="width:9%;">
    <col style="width:21%;">
    <col style="width:8%;">
  </colgroup>
  <thead>
    <tr>
      <th>KOD<br>RUANG</th>
      <th>KEMASAN LANTAI</th>
      <th>LUAS (m&#178;)</th>
      <th>KEMASAN DINDING</th>
      <th>LUAS (m&#178;)</th>
      <th>KEMASAN SILING</th>
      <th>LUAS<br>(m&#178;)</th>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < 13; $i++)
    <tr>
      <td style="height:28px;"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    @endfor
  </tbody>
</table>

{{-- Signature section (identical to page 3) --}}
<table class="ft" style="margin-top:14px;">
  <tr>
    <td style="width:10%;"></td>
    <td style="width:38%; vertical-align:top;">
      <div class="sig-head">PENGUMPUL DATA :</div>
      <table class="ft">
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:120px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:4%;"></td>
    <td style="width:38%; vertical-align:top;">
      <div class="sig-head">PENGESAH DATA :</div>
      <table class="ft">
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:120px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:80px; text-align:left; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td colspan="2"><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:10%;"></td>
  </tr>
</table>

<table class="ft" style="margin-top:10px;">
  <tr>
    <td></td>
    <td style="text-align:right; font-size:10px; white-space:nowrap; width:auto;">
      Muka surat
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
      dari
      <span style="display:inline-block; border-bottom:1px solid #000; width:28px; height:14px; vertical-align:bottom;">&nbsp;</span>
    </td>
  </tr>
</table>

</body>
</html>
