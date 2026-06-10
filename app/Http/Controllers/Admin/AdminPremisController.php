<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Premis;
use App\Models\PremisTanah;
use App\Models\PremisLukisan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPremisController extends Controller
{
    public function index()
    {
        $premis = Premis::latest()->paginate(10);
        return view('admin.premis.index', compact('premis'));
    }

    public function create()
    {
        return view('admin.premis.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_premis'  => 'required|string|max:255',
        'no_dpa'       => 'required|string|unique:premis,no_dpa',
        'koordinat_x'  => 'nullable|string',
        'koordinat_y'  => 'nullable|string',
    ]);

    $premis = Premis::create($request->except(['tanah', 'lukisan', '_token']));

    if ($request->has('tanah')) {
        foreach ($request->tanah as $tanah) {
            if (!empty($tanah['no_lot'])) {
                $premis->tanah()->create($tanah);
            }
        }
    }

    if ($request->has('lukisan')) {
        foreach ($request->lukisan as $lukisan) {
            if (!empty($lukisan['tajuk_lukisan'])) {
                $premis->lukisan()->create($lukisan);
            }
        }
    }

    return redirect()->route('admin.premis.index')
        ->with('success', 'Premis berjaya didaftarkan.');
}

    public function show($id)
    {
        $premis = Premis::with(['tanah', 'lukisan'])->findOrFail($id);
        return view('admin.premis.show', compact('premis'));
    }

    public function edit($id)
    {
        $premis = Premis::with(['tanah', 'lukisan'])->findOrFail($id);
        return view('admin.premis.edit', compact('premis'));
    }

    public function update(Request $request, $id)
    {
        $premis = Premis::findOrFail($id);

        $request->validate([
            'nama_premis' => 'required|string|max:255',
            'no_dpa'      => 'required|string|unique:premis,no_dpa,' . $id,
        ]);

        $premis->update($request->except(['tanah', 'lukisan']));

        // Update premis_tanah
        $premis->tanah()->delete();
        if ($request->has('tanah')) {
            foreach ($request->tanah as $tanah) {
                if (!empty($tanah['no_lot'])) {
                    $premis->tanah()->create($tanah);
                }
            }
        }

        // Update premis_lukisan
        $premis->lukisan()->delete();
        if ($request->has('lukisan')) {
            foreach ($request->lukisan as $lukisan) {
                if (!empty($lukisan['tajuk_lukisan'])) {
                    $premis->lukisan()->create($lukisan);
                }
            }
        }

        return redirect()->route('admin.premis.index')
            ->with('success', 'Premis berjaya dikemaskini.');
    }

    public function destroy($id)
    {
        $premis = Premis::findOrFail($id);
        $premis->delete();

        return redirect()->route('admin.premis.index')
            ->with('success', 'Premis berjaya dipadam.');
    }

    public function exportPdf($id)
    {
        $premis = Premis::with(['tanah', 'lukisan'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.premis.pdf', compact('premis'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin_top', 10)
            ->setOption('margin_bottom', 10)
            ->setOption('margin_left', 10)
            ->setOption('margin_right', 10);

        return $pdf->stream('DA3-Premis.pdf');
    }
}
