<?php

namespace App\Exports\Sheets;

use App\Models\KemasanRuang;
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

class KemasanSheet implements
    FromCollection,
    WithHeadings,
    WithTitle,
    WithStyles,
    WithMapping,
    ShouldAutoSize
{
    /**
     * Sheet tab name.
     */
    public function title(): string
    {
        return 'Kemasan';
    }

    /**
     * Fetch all finishing records associated with active rooms.
     */
    public function collection()
    {
        return KemasanRuang::whereHas('ruang', function ($query) {
            $query->where('is_active', true);
        })
        ->with('ruang')
        ->orderBy('kod_ruang')
        ->get();
    }

    /**
     * Columns matching precisely the user request.
     */
    public function headings(): array
    {
        return [
            'KOD RUANG',
            'KEMASAN LANTAI',
            'LUAS(m^2)',
            'KEMASAN DINDING',
            'LUAS(m^2)',
            'KEMASAN SYILING',
            'LUAS(m^2)',
            'NAMA RUANG',
        ];
    }

    /**
     * Map each row to the specified column values.
     */
    public function map($row): array
    {
        $kodRuang = $row->kod_ruang ?? ($row->ruang->kod ?? '');
        $kemasanLantai = $row->kemasan_lantai ?? '';
        $luasLantai = $row->luas_lantai ?? '';
        $kemasanDinding = $row->kemasan_dinding ?? '';
        $luasDinding = $row->luas_dinding ?? '';
        $kemasanSiling = $row->kemasan_siling ?? '';
        $luasSiling = $row->luas_siling ?? '';
        $namaRuang = $row->ruang->nama ?? '';

        return [
            $kodRuang,
            $kemasanLantai,
            $luasLantai,
            $kemasanDinding,
            $luasDinding,
            $kemasanSiling,
            $luasSiling,
            $namaRuang,
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
                'startColor' => ['argb' => 'FFE0B297'], // Pastel Orange/Peach
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
