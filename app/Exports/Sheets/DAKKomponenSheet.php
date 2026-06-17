<?php

namespace App\Exports\Sheets;

use App\Models\MainComponent;
use App\Models\Sistem;
use App\Models\Subsistem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DAKKomponenSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    WithMapping,
    ShouldAutoSize
{
    /** Row counter for BIL column */
    private int $rowNumber = 0;
    /**
     * Sheet tab name.
     */
    public function title(): string
    {
        return 'DAKKomponen';
    }

    /**
     * Fetch all main components with relations.
     */
    public function collection()
    {
        $components = MainComponent::with([
            'component',
            'measurements',
            'relatedComponents',
            'relatedDocuments',
            'bidangRef',  // Renamed from bidangKejuruteraan to avoid accessor conflict
        ])
        ->orderBy('sistem')
        ->orderBy('subsistem')
        ->orderBy('id')
        ->get();

        // ── Pre-compute Label Komponen & Bilangan Turutan ────────────────────
        // Kumpulan = bidang + sistem.
        // Bila mana-mana satu berubah (sistem atau bidang) → no siri reset ke 1.
        // Bila subsistem berbeza tapi sistem sama → no siri sambung naik (1, 2, 3, 4…).
        $groupCounters = [];

        foreach ($components as $mc) {
            $bidangChar   = $this->getPrimaryBidangChar($mc);
            $kodSistem    = $mc->sistem    ?? '';
            $kodSubsistem = $mc->subsistem ?? '';

            // Group key: bidang + sistem
            // Contoh: "T" + "44" = "T44"  →  counter berkongsi antara "T4402" dan "T4403"
            $groupKey = $bidangChar . $kodSistem;

            if (!isset($groupCounters[$groupKey])) {
                $groupCounters[$groupKey] = 0;
            }
            $groupCounters[$groupKey]++;
            $seq = $groupCounters[$groupKey];

            // Label = prefix + . + 5-digit sequence
            // Prefix = bidang + sistem + subsistem  →  e.g. T4402
            if ($bidangChar === '-' || empty($kodSistem)) {
                $this->labelMap[$mc->id] = '-';
            } else {
                $prefix = $bidangChar . $kodSistem . $kodSubsistem;
                $this->labelMap[$mc->id] = $prefix . '.' . str_pad($seq, 5, '0', STR_PAD_LEFT);
            }

            $this->turutanMap[$mc->id] = $seq;
        }

        return $components;
    }

    /**
     * Column headers — exact structure per borang DAK Komponen.
     */
    public function headings(): array
    {
        return [
            'BIL', 'KOD LOKASI', 'LOKASI', 'NAMA KOMPONEN', 'BILANGAN (SAMA JENIS)',
            'KOD BIDANG KEJURUTERAAN', 'BIDANG KEJURUTERAAN', 'KOD SISTEM', 'SISTEM',
            'KOD SUBSISTEM', 'SUB SISTEM', 'NO. PEROLEHAN (1GFMAS)', 'TARIKH PEROLEHAN',
            "KOS PEROLEHAN\n(RM)", 'NO PESANAN RASMI KERAJAAN /KONTRAK', 'KOD PTJ',
            'TARIKH DIPASANG', 'TARIKH WARANTI TAMAT', 'TARIKH TAMAT DLP', 'JANGKA HAYAT',
            'PENGILANG', 'PEMBEKAL', 'ALAMAT', 'NO. TELEFON', 'KONTRAKTOR', 'ALAMAT',
            'NO. TELEFON', 'CATATAN', 'DISKRIPSI', 'STATUS KOMPONEN', 'JENAMA', 'MODEL',
            'NO SIRI', 'LABEL KOMPONEN', 'NO SIJIL PENDAFTARAN', 'CATATAN', 'JENIS',
            'BEKALAN ELEKTRIK (MSB/SSB/FP/DB)', 'BAHAN', 'KAEDAH PEMASANGAN', 'SAIZ FIZIKAL',
            'UNIT', 'KAPASITI', 'UNIT', 'KADARAN', 'UNIT', 'CATATAN',
            'PREMIS / KOMPONEN', 'DPA / KOD RUANG / BINAAN LUAR', 'NO. TAG / LABEL ASET',
            'NAMA DOKUMEN', 'NO. RUJUKAN BERKAITAN', 'CATATAN', 'LABEL KOMPONEN',
            'BILANGAN TURUTAN KOMPONEN SAMA JENIS',
        ];
    }

    /**
     * Map each MainComponent row to columns.
     */
    public function map($mc): array
    {
        $this->rowNumber++;

        // ── Bidang Kejuruteraan ──────────────────────────────────────────────
        $kodBidang  = $this->getPrimaryBidangChar($mc);
        $namaBidang = $this->deriveNamaBidang($mc);

        // ── Sistem & Subsistem ────────────────────────────────────────────────
        $kodSistem     = $mc->sistem    ?? '-';
        $namaSistem    = $this->getNamaSistem($kodSistem);
        $kodSubsistem  = $mc->subsistem ?? '-';
        $namaSubsistem = $this->getNamaSubsistem($kodSubsistem);

        // ── Measurements (value + unit split) ────────────────────────────────
        $saizMeasurements     = $mc->saizMeasurements;
        $kapasitiMeasurements = $mc->kapasitiMeasurements;
        $kadaranMeasurements  = $mc->kadaranMeasurements;

        $saizValue    = $saizMeasurements->pluck('value')->implode(' x ') ?: '-';
        $saizUnit     = $saizMeasurements->first()?->unit ?? '-';
        $kapasitiValue= $kapasitiMeasurements->pluck('value')->implode(', ') ?: '-';
        $kapasitiUnit = $kapasitiMeasurements->first()?->unit ?? '-';
        $kadaranValue = $kadaranMeasurements->pluck('value')->implode(', ') ?: '-';
        $kadaranUnit  = $kadaranMeasurements->first()?->unit ?? '-';

        return [
            $this->rowNumber,                                          // BIL
            $mc->kod_lokasi                          ?? '-',           // KOD LOKASI
            $mc->component->nama_premis              ?? '-',           // LOKASI
            $mc->nama_komponen_utama                 ?? '-',           // NAMA KOMPONEN
            $mc->komponen_sama_jenis ?? $mc->kuantiti ?? '-',          // BILANGAN (SAMA JENIS)
            $kodBidang,                                                // KOD BIDANG KEJURUTERAAN
            $namaBidang,                                               // BIDANG KEJURUTERAAN
            $kodSistem,                                                // KOD SISTEM
            $namaSistem,                                               // SISTEM
            $kodSubsistem,                                             // KOD SUBSISTEM
            $namaSubsistem,                                            // SUB SISTEM
            $mc->no_perolehan_1gfmas                 ?? '-',           // NO. PEROLEHAN (1GFMAS)
            $mc->tarikh_perolehan
                ? $mc->tarikh_perolehan->format('d/m/Y') : '-',        // TARIKH PEROLEHAN
            $mc->kos_perolehan                       ?? '-',           // KOS PEROLEHAN (RM)
            $mc->no_pesanan_rasmi_kontrak            ?? '-',           // NO PESANAN RASMI KERAJAAN /KONTRAK
            $mc->kod_ptj                             ?? '-',           // KOD PTJ
            $mc->tarikh_dipasang
                ? $mc->tarikh_dipasang->format('d/m/Y') : '-',         // TARIKH DIPASANG
            $mc->tarikh_waranti_tamat
                ? $mc->tarikh_waranti_tamat->format('d/m/Y') : '-',    // TARIKH WARANTI TAMAT
            $mc->tarikh_tamat_dlp
                ? $mc->tarikh_tamat_dlp->format('d/m/Y') : '-',        // TARIKH TAMAT DLP
            $mc->jangka_hayat                        ?? '-',           // JANGKA HAYAT
            $mc->nama_pengilang                      ?? '-',           // PENGILANG
            $mc->nama_pembekal                       ?? '-',           // PEMBEKAL
            $mc->alamat_pembekal                     ?? '-',           // ALAMAT (pembekal)
            $mc->no_telefon_pembekal                 ?? '-',           // NO. TELEFON (pembekal)
            $mc->nama_kontraktor                     ?? '-',           // KONTRAKTOR
            $mc->alamat_kontraktor                   ?? '-',           // ALAMAT (kontraktor)
            $mc->no_telefon_kontraktor               ?? '-',           // NO. TELEFON (kontraktor)
            $mc->catatan_maklumat ?? $mc->catatan    ?? '-',           // CATATAN (H)
            $mc->deskripsi                           ?? '-',           // DISKRIPSI
            $mc->status_komponen                     ?? '-',           // STATUS KOMPONEN
            $mc->jenama                              ?? '-',           // JENAMA
            $mc->model                               ?? '-',           // MODEL
            $mc->no_siri                             ?? '-',           // NO SIRI
            $mc->no_tag_label                        ?? '-',           // LABEL KOMPONEN
            $mc->no_sijil_pendaftaran                ?? '-',           // NO SIJIL PENDAFTARAN
            $mc->catatan_atribut                     ?? '-',           // CATATAN (pendaftaran)
            $mc->jenis                               ?? '-',           // JENIS
            $mc->bekalan_elektrik                    ?? '-',           // BEKALAN ELEKTRIK
            $mc->bahan                               ?? '-',           // BAHAN
            $mc->kaedah_pemasangan                   ?? '-',           // KAEDAH PEMASANGAN
            $saizValue,                                                // SAIZ FIZIKAL
            $saizUnit,                                                 // UNIT
            $kapasitiValue,                                            // KAPASITI
            $kapasitiUnit,                                             // UNIT
            $kadaranValue,                                             // KADARAN
            $kadaranUnit,                                              // UNIT
            $mc->catatan_atribut                     ?? '-',           // CATATAN (teknikal)
            $mc->component->nama_premis              ?? '-',           // PREMIS / KOMPONEN
            $mc->relatedComponents->pluck('no_dpa_kod_ruang')->filter()->implode(', ') ?: '-', // DPA / KOD RUANG
            $mc->relatedComponents->pluck('no_tag_label')->filter()->implode(', ') ?: '-',     // NO. TAG / LABEL ASET
            $mc->relatedDocuments->pluck('nama_dokumen')->filter()->implode(', ') ?: '-',       // NAMA DOKUMEN
            $mc->relatedDocuments->pluck('no_rujukan_berkaitan')->filter()->implode(', ') ?: '-', // NO. RUJUKAN
            $mc->catatan_dokumen                     ?? '-',           // CATATAN (dokumen)
            $this->labelMap[$mc->id]   ?? '-',           // LABEL KOMPONEN (auto-generated)
            $this->turutanMap[$mc->id] ?? '-',           // BILANGAN TURUTAN KOMPONEN SAMA JENIS
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // STYLES
    // ─────────────────────────────────────────────────────────────────────────

    public function styles(Worksheet $sheet): array
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn();

        // ── Section header row colours (row 1) ──────────────────────────────
        $sectionColors = [
            'A1:E1'   => 'FFB3D4F5',  // Pastel Blue     — Lokasi & Komponen
            'F1:K1'   => 'FFD4B8E8',  // Pastel Lavender — Klasifikasi Kejuruteraan
            'L1:P1'   => 'FFAEE8F5',  // Pastel Sky      — Maklumat Perolehan
            'Q1:T1'   => 'FFFFD5AA',  // Pastel Peach    — Tarikh & Waranti
            'U1:X1'   => 'FFB2F0E4',  // Pastel Mint     — Pembekal & Pengilang
            'Y1:AA1'  => 'FFFFCCE4',  // Pastel Pink     — Kontraktor
            'AB1:AJ1' => 'FFD8D8F0',  // Pastel Lilac    — Pendaftaran Aset
            'AK1:AU1' => 'FFCCDAE8',  // Pastel Steel    — Spesifikasi Teknikal
            'AV1:BC1' => 'FFFFF0B3',  // Pastel Yellow   — Maklumat Tambahan
        ];

        foreach ($sectionColors as $range => $color) {
            $sheet->getStyle($range)->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FF1A1A2E'],  // Dark navy — readable on pastel
                    'size'  => 9,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $color],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'   => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFAAAAAA'],
                    ],
                ],
            ]);
        }

        // ── Data rows ────────────────────────────────────────────────────────
        if ($lastRow > 1) {
            $sheet->getStyle('A2:' . $lastCol . $lastRow)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'   => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFD0D0D0'],
                    ],
                ],
            ]);

            // Alternate row shading
            for ($row = 2; $row <= $lastRow; $row++) {
                if ($row % 2 === 0) {
                    $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF5F5F5'],
                        ],
                    ]);
                }
            }
        }

        // ── Freeze header ────────────────────────────────────────────────────
        $sheet->freezePane('A2');
        $sheet->getRowDimension(1)->setRowHeight(40);

        // ── AutoFilter — enable filter dropdown on all header columns ─────────
        $sheet->setAutoFilter('A1:' . $lastCol . '1');

        return [];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    private function getPrimaryBidangChar(MainComponent $mc): string
    {
        // Priority 1: Use dynamic bidang from bidangs table (via bidangRef relationship)
        if ($mc->bidangRef) {
            return strtoupper($mc->bidangRef->kod);
        }

        // Priority 2: Fallback to legacy boolean flags (for old records)
        if ($mc->elv_ict)       return 'T';
        if ($mc->elektrikal)    return 'E';
        if ($mc->mekanikal)     return 'M';
        if ($mc->awam_arkitek)  return 'A';
        if ($mc->bio_perubatan) return 'B';
        return '-';
    }

    private function deriveNamaBidang(MainComponent $mc): string
    {
        // Priority 1: Use dynamic bidang nama from bidangs table
        if ($mc->bidangRef) {
            return $mc->bidangRef->nama;
        }

        // Priority 2: Fallback to legacy boolean flags
        $names = [];
        if ($mc->awam_arkitek)  $names[] = 'Awam/Arkitek';
        if ($mc->elektrikal)    $names[] = 'Elektrikal';
        if ($mc->elv_ict)       $names[] = 'ICT dan ELV';
        if ($mc->mekanikal)     $names[] = 'Mekanikal';
        if ($mc->bio_perubatan) $names[] = 'Bio Perubatan';
        if ($mc->lain_lain)     $names[] = $mc->lain_lain;
        return empty($names) ? '-' : implode(', ', $names);
    }

    private function getNamaSistem(string $kod): string
    {
        if ($kod === '-' || empty($kod)) return '-';
        $sistem = Sistem::where('kod', $kod)->first();
        return $sistem ? $sistem->nama : $kod;
    }

    private function getNamaSubsistem(string $kod): string
    {
        if ($kod === '-' || empty($kod)) return '-';
        $subsistem = Subsistem::where('kod', $kod)->first();
        return $subsistem ? $subsistem->nama : $kod;
    }
}
