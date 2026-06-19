<?php

namespace App\Exports;

use App\Exports\Sheets\DAKKomponenSheet;
use App\Exports\Sheets\DAKRuangSheet;
use App\Exports\Sheets\KemasanSheet;
use App\Exports\Sheets\DAKBlokSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BorangKomponenExport implements WithMultipleSheets
{
    /**
     * Return all sheets for the Excel file.
     *
     * Tab 1 — DAKKomponen : Main component full data (done ✅)
     * Tab 2 — DAKRuang    : Room data               (done ✅)
     * Tab 3 — Kemasan     : Room finishings          (done ✅)
     * Tab 4 — DAK Blok    : Blok data                (done ✅)
     */
    public function sheets(): array
    {
        return [
            new DAKKomponenSheet(),   // Tab 1 ✅
            new DAKRuangSheet(),      // Tab 2 ✅
            new KemasanSheet(),       // Tab 3 ✅
            new DAKBlokSheet(),       // Tab 4 ✅
        ];
    }
}
