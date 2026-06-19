<?php

namespace App\Exports\Sheets;

use App\Models\KodRuang;
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

class DAKRuangSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    WithMapping,
    ShouldAutoSize
{
    private int $rowNumber = 0;
    private array $luasArasMap = [];

    /**
     * Sheet tab name.
     */
    public function title(): string
    {
        return 'DAK Ruang';
    }

    /**
     * Fetch all active room records.
     */
    public function collection()
    {
        // Pre-calculate sum of room areas grouped by level (aras_id)
        $this->luasArasMap = KodRuang::where('is_active', true)
            ->groupBy('aras_id')
            ->selectRaw('aras_id, SUM(luas) as total_luas')
            ->pluck('total_luas', 'aras_id')
            ->toArray();

        return KodRuang::where('is_active', true)
            ->with(['aras.blok'])
            ->orderBy('aras_id')
            ->orderBy('kod')
            ->get();
    }

    /**
     * Columns matching precisely the user request.
     */
    public function headings(): array
    {
        return [
            'BIL',
            'NAMA ARAS',
            'KOD ARAS',
            'LUAS ARAS(m^2)',
            'KOD BLOK',
            'NAMA RUANG',
            'KOD RUANG',
            'FUNGSI RUANG',
            'KOD FUNGSI',
            'LUAS RUANG (m^2)',
            'TINGGI (m)',
            'TEG RUANG',
        ];
    }

    /**
     * Map each row to the specified column values.
     */
    public function map($row): array
    {
        $this->rowNumber++;

        $namaAras = $row->aras->nama ?? '';
        $kodAras = $row->aras->kod ?? '';
        $luasAras = isset($row->aras_id) ? ($this->luasArasMap[$row->aras_id] ?? 0) : 0;
        $kodBlok = $row->aras->blok->kod ?? '';
        $namaRuang = $row->nama ?? '';
        $kodRuang = $row->kod ?? '';
        $fungsiRuang = $row->fungsi_ruang ?? '';
        $kodFungsi = $row->kod_sub_ruang ?? '';
        $luasRuang = $row->luas ?? '';
        $tinggi = $row->tinggi ?? '';
        $tegRuang = $row->kategori ?? '';

        return [
            $this->rowNumber,
            $namaAras,
            $kodAras,
            $luasAras,
            $kodBlok,
            $namaRuang,
            $kodRuang,
            $fungsiRuang,
            $kodFungsi,
            $luasRuang,
            $tinggi,
            $tegRuang,
        ];
    }

    /**
     * Style the worksheet.
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
                'startColor' => ['argb' => 'FFC8E6C9'], // Pastel Green
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

        // Data rows styling
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

            // Zebra striping
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

        // Freeze header pane & row height
        $sheet->freezePane('A2');
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Autofilter
        $sheet->setAutoFilter('A1:' . $lastCol . '1');

        return [];
    }
}
