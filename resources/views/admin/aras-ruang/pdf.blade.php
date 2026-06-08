<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>D.A.5 — Borang Pengumpulan Data Daftar Aset Khusus (DAK)</title>
<style>
/* ── Reset ── */
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, sans-serif; font-size: 11px; color: #000; line-height: 1.3; }
table { border-collapse: collapse; }

/* ── Helpers ── */
.bold      { font-weight: bold; }
.underline { text-decoration: underline; }
.italic    { font-style: italic; }
.center    { text-align: center; }
.right     { text-align: right; }
.strike    { text-decoration: line-through; }
.nowrap    { white-space: nowrap; }

/* ── helaian badge (top right) ── */
.h-wrap  { text-align: right; margin-bottom: 2px; }
.h-badge { border: 1px solid #000; padding: 2px 10px; font-style: italic; font-size: 10px; display: inline-block; }

/* ── Field types ── */
/* Full-bordered box */
.fb { border: 1px solid #000; height: 20px; width: 100%; display: block; }
/* Bottom-border only (underline field) */
.fl-field { border-bottom: 1px solid #000; height: 18px; width: 100%; display: block; }
/* Individual DPA character box */
.dpa { display: inline-block; border: 1px solid #000; width: 17px; height: 18px; margin-right: -1px; vertical-align: middle; }
/* Small checkbox */
.chk { display: inline-block; border: 1px solid #000; width: 14px; height: 14px; vertical-align: middle; }

/* ── Form layout table ── */
.ft    { width: 100%; border-collapse: collapse; }
.ft td { border: none; vertical-align: middle; padding: 2px 1px; font-size: 11px; }
.lbl   { white-space: nowrap; }
.cln   { width: 12px; text-align: center; padding: 0 2px !important; white-space: nowrap; }

/* ── Data grid table ── */
.dt { width: 100%; border-collapse: collapse; table-layout: fixed; }
.dt th {
    border: 1px solid #000;
    background-color: #cccccc;
    font-weight: bold;
    font-size: 11px;
    text-align: center;
    vertical-align: middle;
    padding: 4px 2px;
    line-height: 1.2;
}
.dt td {
    border: 1px solid #000;
    font-size: 11px;
    vertical-align: middle;
    padding: 0 3px;
    height: 26px;
}
.dt td.c { text-align: center; }

/* ── Section heading ── */
.sec { font-weight: bold; text-decoration: underline; font-size: 12px; text-transform: uppercase; margin-bottom: 4px; }

/* ── Signature row ── */
.sig-box  { border: 1px solid #000; height: 28px; display: block; }
.sig-line { border-bottom: 1px solid #000; height: 18px; display: block; }
.sig-head { font-weight: bold; text-align: center; font-size: 11px; text-transform: uppercase; margin-bottom: 3px; }

/* ── Muka surat footer ── */
.ms-blank { border-bottom: 1px solid #000; display: inline-block; width: 28px; height: 14px; vertical-align: bottom; }
</style>
</head>
<body>

{{-- ================================================================
     HELAIAN 1  (Portrait A4)
================================================================ --}}
<div class="h-wrap"><span class="h-badge">helaian 1</span></div>
<div class="right bold" style="font-size:13px; margin-bottom:3px;">D.A. 5 (JKR.PATA.F6/12 rev 1)</div>
<div class="center bold underline" style="font-size:15px; margin-bottom:12px;">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS (DAK)</div>

{{-- MAKLUMAT PREMIS --}}
<div class="sec">MAKLUMAT PREMIS</div>

<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:95px;">Nama Premis</td>
    <td class="cln">:</td>
    <td><div class="fl-field"></div></td>
  </tr>
</table>

<table class="ft" style="margin-bottom:10px;">
  <tr>
    <td class="lbl" style="width:95px;">No. DPA</td>
    <td class="cln">:</td>
    <td style="white-space:nowrap;">
      @for ($i = 0; $i < 24; $i++)
        <span class="dpa"></span>
      @endfor
    </td>
  </tr>
</table>

{{-- Sub heading --}}
<div class="center bold" style="font-size:12px; margin-bottom:6px;">Maklumat Blok / Binaan Luar</div>

<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:135px;">Kod Blok/ Binaan Luar</td>
    <td class="cln">:</td>
    <td style="width:165px;"><div class="fb"></div></td>
    <td></td>
  </tr>
</table>

<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:135px; vertical-align:top; padding-top:2px;">Nama Blok/ Binaan<br>Luar</td>
    <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
    <td><div class="fl-field"></div></td>
  </tr>
</table>

<table class="ft" style="margin-bottom:3px;">
  <tr>
    <td class="lbl" style="width:135px;">Fungsi Binaan (Blok)</td>
    <td class="cln">:</td>
    <td style="width:150px;"><div class="fb"></div></td>
    <td style="width:14px;"></td>
    <td class="lbl" style="width:102px;">Jenis Binaan Luar</td>
    <td class="cln">:</td>
    <td><div class="fb"></div></td>
  </tr>
</table>

<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td class="lbl" style="width:135px;">Koordinat GPS</td>
    <td class="cln">:</td>
    <td class="nowrap">
      <span class="bold">X:</span>
      <span style="border-bottom:1px solid #000; display:inline-block; width:100px; height:15px; vertical-align:bottom; margin:0 5px 0 4px;"></span>
      <span class="bold">;</span>
      <span class="bold" style="margin:0 4px;">Y:</span>
      <span style="border-bottom:1px solid #000; display:inline-block; width:100px; height:15px; vertical-align:bottom;"></span>
    </td>
  </tr>
</table>

{{-- Kontraktor section (2 columns) --}}
<table class="ft" style="margin-bottom:2px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">Kontraktor Utama</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:78px;">Bidang Kerja</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table class="ft" style="margin-bottom:4px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">*Kontraktor</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr><td style="height:20px; padding:0 4px; border-bottom:1px solid #000; font-size:11px;">1.</td></tr>
              <tr><td style="height:20px; padding:0 4px; font-size:11px;">2.</td></tr>
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
              <tr><td style="height:20px; padding:0 4px; border-bottom:1px solid #000; font-size:11px;">1.</td></tr>
              <tr><td style="height:20px; padding:0 4px; font-size:11px;">2.</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Juru Perunding section (2 columns) --}}
<table class="ft" style="margin-bottom:2px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">Juru Perunding Utama</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:78px;">Bidang Kerja</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:125px;">*Juru Perunding</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr><td style="height:20px; padding:0 4px; border-bottom:1px solid #000; font-size:11px;">1.</td></tr>
              <tr><td style="height:20px; padding:0 4px; font-size:11px;">2.</td></tr>
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
              <tr><td style="height:20px; padding:0 4px; border-bottom:1px solid #000; font-size:11px;">1.</td></tr>
              <tr><td style="height:20px; padding:0 4px; font-size:11px;">2.</td></tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div style="font-style:italic; font-size:9.5px; margin-bottom:8px;">Nota: *Sila sediakan lampiran jika ada tambahan</div>

{{-- Bottom two-column data grid --}}
<table class="ft">
  <tr>
    {{-- Left column --}}
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:148px;">Tahun Siap Bina Asal</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Tarikh Siap Bina Asal</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:20px; padding:0 3px;">&nbsp;</td>
                <td style="text-align:right; padding-right:3px; font-style:italic; font-size:9px; white-space:nowrap;">( hh / bb / tttt )</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Fungsi Asal</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Jenis Struktur (blok)</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">No. Siri Pendaftaran</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Jangka hayat (Tahun)</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Kapasiti Penghuni Asal</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:148px;">Kos Bina Asal (RM)</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
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
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Tahun Penilaian</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:20px; padding:0 3px;">&nbsp;</td>
                <td style="text-align:right; padding-right:3px; font-style:italic; font-size:9px; white-space:nowrap;">( hh / bb / tttt )</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Sumber Pembiayaan</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Kod PTJ</td>
          <td class="cln">:</td>
          <td><div class="fb"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px;">Penggunaan Tenaga</td>
          <td class="cln">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:20px; padding:0 3px;">&nbsp;</td>
                <td style="text-align:right; padding-right:3px; font-style:italic; font-size:9px; white-space:nowrap;">(kiloWatt/jam)/tahun</td>
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
                <td style="height:20px; padding:0 3px;">&nbsp;</td>
                <td style="text-align:right; padding-right:3px; font-style:italic; font-size:9px; white-space:nowrap;">m&#179;/tahun</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="lbl" style="width:125px; vertical-align:top; padding-top:2px;">Jenis Milikan</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td style="font-size:11px; padding:2px 1px; line-height:1.4;">Pajakan/ Pegangan<br>Bebas</td>
        </tr>
      </table>
    </td>
  </tr>
</table>


{{-- ================================================================
     HELAIAN 2  (Portrait A4)
================================================================ --}}
<pagebreak orientation="portrait" sheet-size="A4" />

<div class="h-wrap"><span class="h-badge">helaian 2</span></div>

<div style="margin-bottom:10px;"></div>

{{-- Row: Aset Warisan | Status Blok --}}
<table class="ft" style="margin-bottom:8px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:85px;">Aset Warisan</td>
          <td class="cln">:</td>
          <td class="nowrap">
            <span class="chk"></span>
            <span style="font-style:italic; font-size:9.5px; margin-left:5px;">(tandakan jika Ya)</span>
          </td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:130px; vertical-align:top;">Status Blok /<br>Binaan Luar</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td style="padding:2px 1px;">Aktif / Tidak Aktif</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Row: Bil. Aras Atas Tanah | Jumlah Luas Lantai Blok --}}
<table class="ft" style="margin-bottom:4px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:152px;">** Bil. Aras Atas Tanah</td>
          <td class="cln">:</td>
          <td style="width:110px;"><div class="fb"></div></td>
          <td></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:130px; vertical-align:top;">** Jumlah Luas<br>&nbsp;&nbsp;&nbsp;Lantai Blok</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:20px; padding:0 3px;">&nbsp;</td>
                <td style="text-align:right; padding-right:3px; font-size:11px; white-space:nowrap;">m&#178;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

{{-- Row: Bil. Aras Bawah Tanah | Luas Tapak Blok --}}
<table class="ft" style="margin-bottom:4px;">
  <tr>
    <td style="width:50%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:152px; vertical-align:top;">** Bil. Aras Bawah<br>&nbsp;&nbsp;&nbsp;&nbsp;Tanah</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td style="width:110px;"><div class="fb"></div></td>
          <td></td>
        </tr>
      </table>
    </td>
    <td style="width:2%;"></td>
    <td style="width:48%; vertical-align:top;">
      <table class="ft">
        <tr>
          <td class="lbl" style="width:130px; vertical-align:top;">Luas Tapak Blok /<br>&nbsp;&nbsp;Binaan Luar</td>
          <td class="cln" style="vertical-align:top; padding-top:2px;">:</td>
          <td>
            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
              <tr>
                <td style="height:20px; padding:0 3px;">&nbsp;</td>
                <td style="text-align:right; padding-right:3px; font-size:11px; white-space:nowrap;">m&#178;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div style="font-style:italic; font-size:9.5px; margin-bottom:12px;">
  **Diisi sekiranya binaan&nbsp; luar merupakan blok<br>
  &nbsp;&nbsp;&nbsp;(mempunyai aras dan ruang).
</div>

{{-- Gambar Blok / Binaan Luar --}}
<table class="ft" style="margin-bottom:14px;">
  <tr>
    <td class="lbl bold" style="width:130px; vertical-align:top; padding-top:1px;">Gambar Blok / Binaan<br>Luar</td>
    <td class="cln" style="vertical-align:top; padding-top:1px;">:</td>
    <td style="font-size:11px; line-height:1.5;">
      Pastikan dua (2) gambar blok diambil (pandangan sudut hadapan dan
      pandangan sudut belakang) bagi setiap blok/ binaan luar dan dimuat naik ke
      dalam aplikasi mySPATA
    </td>
  </tr>
</table>

{{-- Senarai Lukisan Siap Bina --}}
<div class="center" style="font-size:11px; margin-bottom:5px;">Senarai Lukisan Siap Bina</div>

<table class="dt" style="margin-bottom:30px;">
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
    @for ($i = 0; $i < 9; $i++)
    <tr>
      <td style="height:32px;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    @endfor
  </tbody>
</table>

<div class="right" style="font-size:10px; margin-top:10px;">
  Muka surat <span class="ms-blank">&nbsp;</span> dari <span class="ms-blank">&nbsp;</span>
</div>


{{-- ================================================================
     HELAIAN 3  (Landscape A4)
================================================================ --}}
<pagebreak orientation="landscape" sheet-size="A4-L" />

<div class="h-wrap"><span class="h-badge">helaian 3</span></div>

<div class="sec">MAKLUMAT ARAS</div>

<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td class="lbl bold" style="width:28px;">Blok</td>
    <td class="cln">:</td>
    <td style="width:62px;"><div class="fb"></div></td>
    <td style="width:16px;"></td>
    <td class="lbl bold" style="width:28px;">Aras</td>
    <td class="cln">:</td>
    <td style="width:125px;"><div class="fb"></div></td>
    <td style="width:20px;"></td>
    <td class="lbl bold" style="width:62px;">Nama Aras</td>
    <td class="cln">:</td>
    <td><div class="fb"></div></td>
  </tr>
</table>

<table class="dt">
  <colgroup>
    <col style="width:9%;">
    <col style="width:9%;">
    <col style="width:28%;">
    <col style="width:9%;">
    <col style="width:8%;">
    <col style="width:24%;">
    <col style="width:13%;">
  </colgroup>
  <thead>
    <tr>
      <th rowspan="2">KOD<br>RUANG</th>
      <th rowspan="2">KOD<br>SUB<br>RUANG</th>
      <th rowspan="2">NAMA RUANG</th>
      <th colspan="2" style="border-bottom:1px solid #000;">UKURAN RUANG</th>
      <th rowspan="2">FUNGSI RUANG</th>
      <th rowspan="2" style="font-size:10px; font-weight:bold; line-height:1.3;">
        KEMASAN<br>
        <span style="font-size:9px; font-weight:normal; font-style:italic;">(Jika ADA,<br>perlu diisi<br>helaian 4)</span>
      </th>
    </tr>
    <tr>
      <th>LUAS (m&#178;)</th>
      <th>TINGGI (m)</th>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < 12; $i++)
    <tr>
      <td style="height:25px;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="c" style="font-size:10px; white-space:nowrap;">ADA / <span class="strike">TIADA</span></td>
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
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:115px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:4%;"></td>
    <td style="width:38%; vertical-align:top;">
      <div class="sig-head">PENGESAH DATA :</div>
      <table class="ft">
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:115px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:10%;"></td>
  </tr>
</table>

<div class="right" style="font-size:10px; margin-top:12px;">
  Muka surat <span class="ms-blank">&nbsp;</span> dari <span class="ms-blank">&nbsp;</span>
</div>


{{-- ================================================================
     HELAIAN 4  (Landscape A4)
================================================================ --}}
<pagebreak orientation="landscape" sheet-size="A4-L" />

<div class="h-wrap"><span class="h-badge">helaian 4</span></div>

<div class="sec">*MAKLUMAT KEMASAN DALAM RUANG</div>

<table class="ft" style="margin-bottom:5px;">
  <tr>
    <td class="lbl bold" style="width:28px;">Blok</td>
    <td class="cln">:</td>
    <td style="width:62px;"><div class="fb"></div></td>
    <td style="width:16px;"></td>
    <td class="lbl bold" style="width:28px;">Aras</td>
    <td class="cln">:</td>
    <td style="width:125px;"><div class="fb"></div></td>
    <td style="width:20px;"></td>
    <td class="lbl bold" style="width:62px;">Nama Aras</td>
    <td class="cln">:</td>
    <td><div class="fb"></div></td>
  </tr>
</table>

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
      <th>LUAS (m&#178;)</th>
    </tr>
  </thead>
  <tbody>
    @for ($i = 0; $i < 13; $i++)
    <tr>
      <td style="height:26px;">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:115px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:4%;"></td>
    <td style="width:38%; vertical-align:top;">
      <div class="sig-head">PENGESAH DATA :</div>
      <table class="ft">
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tandatangan</td>
          <td class="cln">:</td>
          <td style="width:115px;"><div class="sig-box"></div></td>
          <td></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Nama</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Jawatan</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
        <tr>
          <td class="lbl" style="width:82px; text-align:right; padding-right:4px;">Tarikh</td>
          <td class="cln">:</td>
          <td><div class="sig-line"></div></td>
        </tr>
      </table>
    </td>
    <td style="width:10%;"></td>
  </tr>
</table>

<div class="right" style="font-size:10px; margin-top:12px;">
  Muka surat <span class="ms-blank">&nbsp;</span> dari <span class="ms-blank">&nbsp;</span>
</div>

</body>
</html>
