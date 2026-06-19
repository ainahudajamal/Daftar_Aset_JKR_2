<?php

namespace App\Exports\Sheets;

use App\Models\Da5Record;
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

class DAKBlokSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    WithMapping,
    ShouldAutoSize
{
    private int $rowNumber = 0;

    /**
     * Sheet tab name.
     */
    public function title(): string
    {
        return 'DAK Blok';
    }

    /**
     * Fetch all Da5Record records directly.
     */
    public function collection()
    {
        // Fetch only records associated with active premises (status_premis = 'Aktif')
        // Or manual premises where nama_premis_id is null.
        return Da5Record::where(function ($q) {
            $q->whereNull('nama_premis_id')
              ->orWhereHas('premis', function ($query) {
                  $query->where('status_premis', 'Aktif');
              });
        })->with('premis')->get();
    }

    /**
     * Headings penuh — 52 kolum ikut TEPAT sheet "DAK Blok".
     */
    public function headings(): array
    {
        return [
            'BIL',
            'KOD BLOK / BINAAN LUAR',
            'NAMA BLOK',
            'FUNGSI BINAAN',
            'KOORDINAT GPS, X',
            'KOORDINAT GPS, Y',
            'KONTRAKTOR UTAMA',
            'BIDANG KERJA',
            '1. KONTRAKTOR',
            '1. BIDANG KERJA',
            '2. KONTRAKTOR',
            '2. BIDANG KERJA',
            '3. KONTRAKTOR',
            '3. BIDANG KERJA',
            '4. KONTRAKTOR',
            '4. BIDANG KERJA',
            '5. KONTRAKTOR',
            '5. BIDANG KERJA',
            '6. KONTRAKTOR',
            '6. BIDANG KERJA',
            'JURU PERUNDING UTAMA',
            'BIDANG KERJA2',
            '1. JURU PERUNDING',
            '1. BIDANG KERJA3',
            '2. JURU PERUNDING',
            '2. BIDANG KERJA4',
            '3. JURU PERUNDING',
            '3. BIDANG KERJA5',
            '4. JURU PERUNDING',
            '4. BIDANG KERJA6',
            '5. JURU PERUNDING',
            '5. BIDANG KERJA7',
            'TAHUN SIAP BINA ASAL',
            'TARIKH SIAP BINA ASAL',
            'FUNGSI ASAL',
            'JENIS STRUKTUR',
            'NO. SIRI PENDAFTARAN',
            'JANGKA HAYAT (TAHUN)',
            'KAPASITI PENGHUNI',
            'KOS SIAP BINA ASAL (RM)',
            'NILAI SEMASA (RM)',
            'TAHUN PENILAIAN',
            'SUMBER PEMBIAYAAN',
            'KOT PTJ',
            'PENGGUNAAN TENAGA (kW/tahun)',
            'PENGGUNAAN AIR (m3/tahun)',
            'JENIS MILIKAN',
            'STATUS BLOK',
            'BIL. ARAS ATAS TANAH',
            'BIL. ARAS BAWAH TANAH',
            'JUMLAH LUAS LANTAI',
            'LUAS TAPAK',
        ];
    }

    /**
     * Map setiap rekod Da5Record kepada 52 kolum.
     */
    public function map($row): array
    {
        $this->rowNumber++;

        // Get coordinates from record, fallback to premis coordinates
        $gpsX = $row->gps_x ?? ($row->premis->koordinat_x ?? '');
        $gpsY = $row->gps_y ?? ($row->premis->koordinat_y ?? '');

        // Determine correct function (uses fungsi_binaan or jenis_binaan as fallback)
        $fungsiBinaan = $row->fungsi_binaan ?: $row->jenis_binaan ?: '';

        return [
            $this->rowNumber,
            $row->kod_blok ?? '',
            $row->nama_blok ?? '',
            $fungsiBinaan,
            $gpsX,
            $gpsY,
            $row->kontraktor_utama ?? '',
            $row->bidang_kontraktor_utama ?? '',
            isset($row->kontraktor_list[0]['nama']) ? $row->kontraktor_list[0]['nama'] : '',
            isset($row->kontraktor_list[0]['bidang']) ? $row->kontraktor_list[0]['bidang'] : '',
            isset($row->kontraktor_list[1]['nama']) ? $row->kontraktor_list[1]['nama'] : '',
            isset($row->kontraktor_list[1]['bidang']) ? $row->kontraktor_list[1]['bidang'] : '',
            isset($row->kontraktor_list[2]['nama']) ? $row->kontraktor_list[2]['nama'] : '',
            isset($row->kontraktor_list[2]['bidang']) ? $row->kontraktor_list[2]['bidang'] : '',
            isset($row->kontraktor_list[3]['nama']) ? $row->kontraktor_list[3]['nama'] : '',
            isset($row->kontraktor_list[3]['bidang']) ? $row->kontraktor_list[3]['bidang'] : '',
            isset($row->kontraktor_list[4]['nama']) ? $row->kontraktor_list[4]['nama'] : '',
            isset($row->kontraktor_list[4]['bidang']) ? $row->kontraktor_list[4]['bidang'] : '',
            isset($row->kontraktor_list[5]['nama']) ? $row->kontraktor_list[5]['nama'] : '',
            isset($row->kontraktor_list[5]['bidang']) ? $row->kontraktor_list[5]['bidang'] : '',
            $row->juru_perunding_utama ?? '',
            $row->bidang_juru_perunding_utama ?? '',
            isset($row->juru_perunding_list[0]['nama']) ? $row->juru_perunding_list[0]['nama'] : '',
            isset($row->juru_perunding_list[0]['bidang']) ? $row->juru_perunding_list[0]['bidang'] : '',
            isset($row->juru_perunding_list[1]['nama']) ? $row->juru_perunding_list[1]['nama'] : '',
            isset($row->juru_perunding_list[1]['bidang']) ? $row->juru_perunding_list[1]['bidang'] : '',
            isset($row->juru_perunding_list[2]['nama']) ? $row->juru_perunding_list[2]['nama'] : '',
            isset($row->juru_perunding_list[2]['bidang']) ? $row->juru_perunding_list[2]['bidang'] : '',
            isset($row->juru_perunding_list[3]['nama']) ? $row->juru_perunding_list[3]['nama'] : '',
            isset($row->juru_perunding_list[3]['bidang']) ? $row->juru_perunding_list[3]['bidang'] : '',
            isset($row->juru_perunding_list[4]['nama']) ? $row->juru_perunding_list[4]['nama'] : '',
            isset($row->juru_perunding_list[4]['bidang']) ? $row->juru_perunding_list[4]['bidang'] : '',
            $row->tahun_siap_bina ?? ($row->premis && $row->premis->tarikh_siap_bina ? $row->premis->tarikh_siap_bina->format('Y') : ''),
            $row->tarikh_siap_bina ? ($row->tarikh_siap_bina instanceof \Carbon\Carbon ? $row->tarikh_siap_bina->format('Y-m-d') : date('Y-m-d', strtotime($row->tarikh_siap_bina))) : ($row->premis && $row->premis->tarikh_siap_bina ? $row->premis->tarikh_siap_bina->format('Y-m-d') : ''),
            $row->fungsi_asal ?? '',
            $row->jenis_struktur ?? '',
            $row->no_siri_pendaftaran ?? '',
            $row->jangka_hayat ?? '',
            $row->kapasiti_penghuni ?? '',
            $row->kos_bina_asal ?? ($row->premis->kos_siap_bina_asal ?? ''),
            $row->nilai_semasa ?? ($row->premis->nilai_semasa ?? ''),
            $row->tarikh_penilaian ? ($row->tarikh_penilaian instanceof \Carbon\Carbon ? $row->tarikh_penilaian->format('Y') : date('Y', strtotime($row->tarikh_penilaian))) : ($row->premis && $row->premis->tarikh_penilaian ? $row->premis->tarikh_penilaian->format('Y') : ''),
            $row->sumber_pembiayaan ?? ($row->premis->sumber_pembiayaan ?? ''),
            $row->kod_ptj ?? ($row->premis->kod_ptj ?? ''),
            $row->penggunaan_tenaga ?? '',
            $row->penggunaan_air ?? '',
            $row->jenis_milikan ?? '',
            $row->status_blok ?? ($row->premis->status_premis ?? ''),
            $row->bil_aras_atas ?? '',
            $row->bil_aras_bawah ?? '',
            $row->jumlah_luas_lantai ?? '',
            $row->luas_tapak ?? '',
        ];
    }

    /**
     * Apply premium styling to the sheet.
     */
    public function styles(Worksheet $sheet): array
    {
        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn();

        // Heading styling (row 1)
        $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FF1A1A2E'],
                'size'  => 10,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD1C4E9'], // Pastel Purple
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

        // Data row styling
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

            // Alternate row shading (Zebra striping)
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

        // Freeze pane and set row height
        $sheet->freezePane('A2');
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Enable Autofilter
        $sheet->setAutoFilter('A1:' . $lastCol . '1');

        return [];
    }
}
