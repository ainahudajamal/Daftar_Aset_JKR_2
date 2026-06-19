<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\MainComponent;
use App\Models\SubComponent;
use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComponentExport;
use App\Exports\MainComponentExport;
use App\Exports\SubComponentExport;
use App\Exports\CompleteReportExport;
use App\Exports\BorangKomponenExport;
use App\Exports\Sheets\DAKBlokSheet;

class ExportController extends Controller
{
    /**
     * Export Component to PDF
     */
    public function exportComponentPDF(Component $component)
    {
        $component->load(['mainComponents.subComponents']);
        
        $pdf = PDF::loadView('user.exports.pdf.component', compact('component'));
        
        // Set paper size dan options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'Arial');
        
        // Generate filename
        $filename = 'Borang-1-Komponen-' . $component->id . '-' . date('YmdHis') . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * Export Main Component to PDF
     */
    public function exportMainComponentPDF(MainComponent $mainComponent)
    {
        $mainComponent->load(['component', 'subComponents']);
        
        $pdf = PDF::loadView('user.exports.pdf.main-component', compact('mainComponent'));
        
        // Set paper size dan options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'Arial');
        
        $filename = 'Borang-2-Komponen-Utama-' . $mainComponent->id . '-' . date('YmdHis') . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * Export Sub Component to PDF
     */
    public function exportSubComponentPDF(SubComponent $subComponent)
    {
        $subComponent->load(['mainComponent.component']);
        
        $pdf = PDF::loadView('user.exports.pdf.sub-component', compact('subComponent'));
        
        // Set paper size dan options
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'Arial');
        
        $filename = 'Borang-3-Sub-Komponen-' . $subComponent->id . '-' . date('YmdHis') . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * Export Complete Report (Component + Main + Sub) to PDF
     */
    public function exportCompleteReportPDF(Component $component)
    {
        $component->load(['mainComponents.subComponents']);
        
        // KIRA JUMLAH MUKA SURAT
        $totalPages = $this->calculateTotalPages($component);
        
        $pdf = PDF::loadView('user.exports.pdf.complete-report', compact('component', 'totalPages'));
        
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'Arial');
        
        $filename = 'Laporan-Lengkap-Komponen-' . $component->id . '-' . date('YmdHis') . '.pdf';
        
        return $pdf->stream($filename);
    }

    /**
     * HELPER: Calculate total pages for complete report
     */
    private function calculateTotalPages(Component $component)
    {
        $pages = 0;
        
        // 1 page untuk Component (Borang 1)
        $pages += 1;
        
        // Setiap Main Component = 1 page
        $mainComponentsCount = $component->mainComponents->count();
        $pages += $mainComponentsCount;
        
        // Setiap Sub Component = 1 page
        foreach ($component->mainComponents as $mainComponent) {
            $pages += $mainComponent->subComponents->count();
        }
        
        return $pages;
    }

    /**
     * Export Component to Excel
     */
    public function exportComponentExcel(Component $component)
    {
        $filename = 'Borang-1-Komponen-' . $component->id . '-' . date('YmdHis') . '.xlsx';
        
        return Excel::download(
            new ComponentExport($component), 
            $filename
        );
    }

    /**
     * Export Main Component to Excel
     */
    public function exportMainComponentExcel(MainComponent $mainComponent)
    {
        $filename = 'Borang-2-Komponen-Utama-' . $mainComponent->id . '-' . date('YmdHis') . '.xlsx';
        
        return Excel::download(
            new MainComponentExport($mainComponent), 
            $filename
        );
    }

    /**
     * Export Sub Component to Excel
     */
    public function exportSubComponentExcel(SubComponent $subComponent)
    {
        $filename = 'Borang-3-Sub-Komponen-' . $subComponent->id . '-' . date('YmdHis') . '.xlsx';
        
        return Excel::download(
            new SubComponentExport($subComponent), 
            $filename
        );
    }

    /**
     * Export Complete Report to Excel (Multiple Sheets)
     */
    public function exportCompleteReportExcel(Component $component)
    {
        $filename = 'Laporan-Lengkap-Komponen-' . $component->id . '-' . date('YmdHis') . '.xlsx';
        
        return Excel::download(
            new CompleteReportExport($component), 
            $filename
        );
    }

    /**
     * Export All Components Summary to Excel
     */
    public function exportAllComponentsExcel()
    {
        $components = Component::with(['mainComponents.subComponents'])->get();
        
        $filename = 'Senarai-Semua-Komponen-' . date('Ymd-His') . '.xlsx';
        
        return Excel::download(
            new \App\Exports\AllComponentsExport($components), 
            $filename
        );
    }

    /**
     * Export All Components Summary to PDF
     */
    public function exportAllComponentsPDF()
    {
        $components = Component::with(['mainComponents.subComponents'])->get();
        
        $pdf = PDF::loadView('user.exports.pdf.all-components', compact('components'));
        
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'Arial');
        
        $filename = 'Senarai-Semua-Komponen-' . date('Ymd-His') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Stream PDF (untuk preview di browser tanpa download)
     */
    public function streamComponentPDF(Component $component)
    {
        $component->load(['mainComponents.subComponents']);
        
        $pdf = PDF::loadView('user.exports.pdf.component', compact('component'));
        
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'Arial');
        
        return $pdf->stream('Borang-1-Komponen-' . $component->id . '.pdf');
    }

    /**
     * Show the Borang Pendaftaran Komponen table view (Tab 1 — DAKKomponen)
     */
    public function borangKomponenIndex(Request $request)
    {
        $query = MainComponent::with(['component'])->orderBy('id');

        // Search by component name or kod_lokasi
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_komponen_utama', 'like', "%{$search}%")
                  ->orWhere('kod_lokasi', 'like', "%{$search}%");
            });
        }

        // Filter by sistem kod
        if ($sistem = $request->get('sistem')) {
            $query->where('sistem', $sistem);
        }

        // Filter by bidang (engineering discipline)
        if ($bidang = $request->get('bidang')) {
            $query->where($bidang, true);
        }

        $komponen = $query->paginate(25)->withQueryString();

        // Lookup maps
        $sistemMap    = Sistem::pluck('nama', 'kod')->toArray();
        $subsistemMap = Subsistem::pluck('nama', 'kod')->toArray();
        $sistemList   = Sistem::orderBy('kod')->get();

        // Summary counts
        $totalKomponen  = MainComponent::count();
        $totalSistem    = Sistem::count();
        $totalSubsistem = Subsistem::count();

        return view('user.components.borang-komponen', compact(
            'komponen',
            'sistemMap',
            'subsistemMap',
            'sistemList',
            'totalKomponen',
            'totalSistem',
            'totalSubsistem'
        ));
    }

    /**
     * Export Borang Pendaftaran Komponen to Excel (4 Tabs)
     *
     * Tab 1 — DAKKomponen : Full komponen data  ✅
     * Tab 2 — DAKRuang    : Room data            (TODO: rakan)
     * Tab 3 — Kemasan     : Room finishings      (TODO: rakan)
     * Tab 4 — DAK Blok    : Blok data            (TODO: rakan)
     */
    public function exportBorangKomponen()
    {
        $filename = 'Borang-Pendaftaran-Komponen-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new BorangKomponenExport(), $filename);
    }
}