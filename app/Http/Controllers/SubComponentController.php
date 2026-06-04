<?php
// app/Http/Controllers/SubComponentController.php

namespace App\Http\Controllers;

use App\Models\SubComponent;
use App\Models\MainComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class SubComponentController extends Controller
{
    /**
     * Show the form for creating a new sub component
     */
    public function create()
    {
        $mainComponents = MainComponent::with('component')->get();
        return view('user.components.create-sub-component', compact('mainComponents'));
    }

    /**
     * Store a newly created sub component
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());

            DB::beginTransaction();

            // BUANG measurement fields dari validated (akan guna table measurements)
            unset($validated['saiz'], $validated['saiz_unit']);
            unset($validated['kadaran'], $validated['kadaran_unit']);
            unset($validated['kapasiti'], $validated['kapasiti_unit']);

            // Handle dokumen berkaitan - organized by category
            $validated['dokumen_berkaitan'] = $this->processDokumenBerkaitan($request);

            $validated['status'] = $request->input('status', 'aktif');

            // TAMBAH user_id
            $validated['user_id'] = auth()->id();

            // Create sub component
            $subComponent = SubComponent::create($validated);

            // Save measurements ke table baru
            $this->saveMeasurements($subComponent, $request);

            DB::commit();

            //  TAMBAH LOG
            AuditLog::create([
                'user_id'      => auth()->id(),
                'component_id' => $subComponent->mainComponent->component_id ?? null,
                'title'        => 'Tambah Sub Komponen',
                'description'  => 'Sub Komponen baru ditambah - Nama: ' . $subComponent->nama_sub_komponen,
            ]);

            return redirect()->route('components.index')
                ->with('success', 'Sub Komponen berjaya ditambah');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating sub component: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menyimpan Sub Komponen: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified sub component
     */
    public function show(SubComponent $subComponent)
    {
        // TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $subComponent->mainComponent->component_id ?? null,
            'title'        => 'Lihat Sub Komponen',
            'description'  => 'Sub Komponen dilihat - Nama: ' . $subComponent->nama_sub_komponen,
        ]);

        $subComponent->load([
            'user',
            'mainComponent.component',
            'measurements',
            'saizMeasurements',
            'kadaranMeasurements',
            'kapasitiMeasurements'
        ]);

        return view('user.components.view-sub-component', compact('subComponent'));
    }

    /**
     * Show the form for editing the sub component
     */
    public function edit(SubComponent $subComponent)
    {
        $mainComponents = MainComponent::with('component')->get();

        // Load measurements dengan relationships untuk edit form
        $subComponent->load([
            'user',  // ✅ TAMBAH
            'measurements',
            'saizMeasurements',
            'kadaranMeasurements',
            'kapasitiMeasurements'
        ]);

        return view('user.components.edit-sub-component', compact('subComponent', 'mainComponents'));
    }

    /**
     * Update the specified sub component
     */
    public function update(Request $request, SubComponent $subComponent)
    {
        try {
            $validated = $request->validate($this->validationRules());

            DB::beginTransaction();

            // BUANG measurement fields
            unset($validated['saiz'], $validated['saiz_unit']);
            unset($validated['kadaran'], $validated['kadaran_unit']);
            unset($validated['kapasiti'], $validated['kapasiti_unit']);

            // Handle dokumen berkaitan
            $validated['dokumen_berkaitan'] = $this->processDokumenBerkaitan($request);

            // ✅ TAMBAH user_id jika tiada
            if (!$subComponent->user_id) {
                $validated['user_id'] = auth()->id();
            }

            // Update sub component
            $subComponent->update($validated);

            // Delete & recreate measurements
            $subComponent->measurements()->delete();
            $this->saveMeasurements($subComponent, $request);

            DB::commit();

            //  TAMBAH LOG
            AuditLog::create([
                'user_id'      => auth()->id(),
                'component_id' => $subComponent->mainComponent->component_id ?? null,
                'title'        => 'Kemaskini Sub Komponen',
                'description'  => 'Sub Komponen dikemaskini - Nama: ' . $subComponent->nama_sub_komponen,
            ]);

            return redirect()->route('components.index')
                ->with('success', 'Sub Komponen berjaya dikemaskini');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating sub component: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal mengemaskini Sub Komponen: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Soft delete the specified sub component
     */
    public function destroy(SubComponent $subComponent)
    {
        //  TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $subComponent->mainComponent->component_id ?? null,
            'title'        => 'Padam Sub Komponen',
            'description'  => 'Sub Komponen dipadam - Nama: ' . $subComponent->nama_sub_komponen,
        ]);
        $subComponent->delete();

        return redirect()->route('components.index')
            ->with('success', 'Sub Komponen berjaya dipadam');
    }

    /**
     * Display a listing of trashed sub components
     */
    public function trashed()
    {
        $subComponents = SubComponent::onlyTrashed()
            ->with(['mainComponent.component', 'user'])  // ✅ TAMBAH user
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('sub-components.trashed', compact('subComponents'));
    }

    /**
     * Restore a trashed sub component
     */
    public function restore($id)
    {
        $subComponent = SubComponent::onlyTrashed()->findOrFail($id);
        $subComponent->restore();

        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipulihkan');
    }

    /**
     * Permanently delete a trashed sub component
     */
    public function forceDestroy($id)
    {
        $subComponent = SubComponent::onlyTrashed()->findOrFail($id);
        $subComponent->forceDelete();

        return redirect()->route('sub-components.trashed')
            ->with('success', 'Sub Komponen berjaya dipadam secara kekal');
    }

    /**
     * ========================================
     * SAVE MEASUREMENTS METHOD
     * ========================================
     */
    private function saveMeasurements(SubComponent $subComponent, Request $request): void
    {
        // Process Saiz
        $saizValues = $request->input('saiz', []);
        $saizUnits = $request->input('saiz_unit', []);

        if (is_array($saizValues)) {
            foreach ($saizValues as $index => $value) {
                if (!empty(trim($value ?? ''))) {
                    $subComponent->measurements()->create([
                        'type' => 'saiz',
                        'value' => $value,
                        'unit' => $saizUnits[$index] ?? null,
                        'order' => $index + 1
                    ]);
                }
            }
        }

        // Process Kadaran
        $kadaranValues = $request->input('kadaran', []);
        $kadaranUnits = $request->input('kadaran_unit', []);

        if (is_array($kadaranValues)) {
            foreach ($kadaranValues as $index => $value) {
                if (!empty(trim($value ?? ''))) {
                    $subComponent->measurements()->create([
                        'type' => 'kadaran',
                        'value' => $value,
                        'unit' => $kadaranUnits[$index] ?? null,
                        'order' => $index + 1
                    ]);
                }
            }
        }

        // Process Kapasiti
        $kapasitiValues = $request->input('kapasiti', []);
        $kapasitiUnits = $request->input('kapasiti_unit', []);

        if (is_array($kapasitiValues)) {
            foreach ($kapasitiValues as $index => $value) {
                if (!empty(trim($value ?? ''))) {
                    $subComponent->measurements()->create([
                        'type' => 'kapasiti',
                        'value' => $value,
                        'unit' => $kapasitiUnits[$index] ?? null,
                        'order' => $index + 1
                    ]);
                }
            }
        }
    }

    /**
     * ========================================
     * HELPER METHODS
     * ========================================
     */

    /**
     * Helper: Process dokumen berkaitan organized by category
     */
    private function processDokumenBerkaitan(Request $request)
    {
        $categories = $request->input('doc_category', []);
        $bils = $request->input('doc_bil', []);
        $namas = $request->input('doc_nama', []);
        $rujukans = $request->input('doc_rujukan', []);
        $catatans = $request->input('doc_catatan', []);

        $documents = [];

        // If using category-based organization
        if (!empty($categories) && is_array($categories)) {
            foreach ($categories as $categoryIndex => $category) {
                if (isset($namas[$category]) && is_array($namas[$category])) {
                    foreach ($namas[$category] as $index => $nama) {
                        // Ensure $nama is string before trim
                        $namaStr = is_string($nama) ? trim($nama) : '';

                        if (!empty($namaStr)) {
                            $documents[] = [
                                'kategori' => is_string($category) ? $category : 'umum',
                                'bil' => $bils[$category][$index] ?? ($index + 1),
                                'nama' => $namaStr,
                                'rujukan' => isset($rujukans[$category][$index]) && is_string($rujukans[$category][$index])
                                    ? $rujukans[$category][$index]
                                    : null,
                                'catatan' => isset($catatans[$category][$index]) && is_string($catatans[$category][$index])
                                    ? $catatans[$category][$index]
                                    : null,
                            ];
                        }
                    }
                }
            }
        }
        // Fallback: simple array without categories (when doc_nama is directly an array)
        else if (is_array($namas)) {
            // Check if this is a direct array of names (not nested)
            foreach ($namas as $key => $value) {
                // If value is string, it's a direct list
                if (is_string($value)) {
                    $namaStr = trim($value);
                    if (!empty($namaStr)) {
                        $documents[] = [
                            'kategori' => 'umum',
                            'bil' => is_array($bils) && isset($bils[$key]) ? $bils[$key] : ($key + 1),
                            'nama' => $namaStr,
                            'rujukan' => is_array($rujukans) && isset($rujukans[$key]) && is_string($rujukans[$key])
                                ? $rujukans[$key]
                                : null,
                            'catatan' => is_array($catatans) && isset($catatans[$key]) && is_string($catatans[$key])
                                ? $catatans[$key]
                                : null,
                        ];
                    }
                }
                // If value is array, it might be nested category structure
                else if (is_array($value)) {
                    foreach ($value as $index => $nama) {
                        $namaStr = is_string($nama) ? trim($nama) : '';
                        if (!empty($namaStr)) {
                            $documents[] = [
                                'kategori' => is_string($key) ? $key : 'umum',
                                'bil' => isset($bils[$key][$index]) ? $bils[$key][$index] : ($index + 1),
                                'nama' => $namaStr,
                                'rujukan' => isset($rujukans[$key][$index]) && is_string($rujukans[$key][$index])
                                    ? $rujukans[$key][$index]
                                    : null,
                                'catatan' => isset($catatans[$key][$index]) && is_string($catatans[$key][$index])
                                    ? $catatans[$key][$index]
                                    : null,
                            ];
                        }
                    }
                }
            }
        }

        // Return array - akan auto convert ke JSON oleh cast dalam model
        return !empty($documents) ? $documents : null;
    }

    /**
     * Validation rules
     */
    private function validationRules(): array
    {
        return [
            'main_component_id' => 'required|exists:main_components,id',
            'nama_sub_komponen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'no_siri' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'kuantiti' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',

            // Atribut Spesifikasi
            'jenis' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',

            // Array validation untuk measurements
            'saiz' => 'nullable|array',
            'saiz.*' => 'nullable|string|max:255',
            'saiz_unit' => 'nullable|array',
            'saiz_unit.*' => 'nullable|string|max:50',

            'kadaran' => 'nullable|array',
            'kadaran.*' => 'nullable|string|max:255',
            'kadaran_unit' => 'nullable|array',
            'kadaran_unit.*' => 'nullable|string|max:50',

            'kapasiti' => 'nullable|array',
            'kapasiti.*' => 'nullable|string|max:255',
            'kapasiti_unit' => 'nullable|array',
            'kapasiti_unit.*' => 'nullable|string|max:50',

            'catatan_atribut' => 'nullable|string',

            // Maklumat Pembelian
            'tarikh_pembelian' => 'nullable|date',
            'kos_perolehan' => 'nullable|numeric',
            'no_pesanan_rasmi_kontrak' => 'nullable|string|max:255',
            'kod_ptj' => 'nullable|string|max:255',
            'tarikh_dipasang' => 'nullable|date',
            'tarikh_waranti_tamat' => 'nullable|date',
            'jangka_hayat' => 'nullable|integer',

            // Pengilang, Pembekal, Kontraktor
            'nama_pengilang' => 'nullable|string|max:255',
            'nama_pembekal' => 'nullable|string|max:255',
            'alamat_pembekal' => 'nullable|string',
            'no_telefon_pembekal' => 'nullable|string|max:50',
            'nama_kontraktor' => 'nullable|string|max:255',
            'alamat_kontraktor' => 'nullable|string',
            'no_telefon_kontraktor' => 'nullable|string|max:50',
            'catatan_pembelian' => 'nullable|string',

            // Dokumen - array inputs (with optional categories)
            'doc_category' => 'nullable|array',
            'doc_bil' => 'nullable|array',
            'doc_nama' => 'nullable|array',
            'doc_rujukan' => 'nullable|array',
            'doc_catatan' => 'nullable|array',
            'catatan_dokumen' => 'nullable|string',

            // Status & Nota
            'nota' => 'nullable|string',
            'status' => 'required|string|in:aktif,tidak_aktif',
        ];
    }
}
