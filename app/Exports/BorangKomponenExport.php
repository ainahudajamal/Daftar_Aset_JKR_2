<?php

namespace App\Exports;

use App\Exports\Sheets\DAKKomponenSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BorangKomponenExport implements WithMultipleSheets
{
    /**
     * Return all sheets for the Excel file.
     *
     * Tab 1 — DAKKomponen : Main component full data (done ✅)
     * Tab 2 — DAKRuang    : Room data               (TODO: rakan)
     * Tab 3 — Kemasan     : Room finishings          (TODO: rakan)
     * Tab 4 — DAK Blok    : Blok data                (TODO: rakan)
     */
    public function sheets(): array
    {
        return [
            new DAKKomponenSheet(),   // Tab 1 ✅
            // new DAKRuangSheet(),   // Tab 2 — TODO rakan
            // new KemasanSheet(),    // Tab 3 — TODO rakan
            // new DAKBlokSheet(),    // Tab 4 — TODO rakan
        ];
    }
}
