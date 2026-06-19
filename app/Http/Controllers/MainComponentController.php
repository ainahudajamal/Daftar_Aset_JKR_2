<?php

namespace App\Http\Controllers;

use App\Models\MainComponent;
use App\Models\Component;
use App\Models\Sistem;
use App\Models\Subsistem;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\AuditLog;

class MainComponentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        DB::beginTransaction();
        try {
            // ============================================
            // VALIDATION: Check duplicate Kod Lokasi
            // ============================================
            $duplicateKodLokasi = MainComponent::where('kod_lokasi', $request->kod_lokasi)
                ->where('component_id', $request->component_id)
                ->exists();

            if ($duplicateKodLokasi) {
                throw ValidationException::withMessages([
                    'kod_lokasi' => 'Kod Lokasi "' . $request->kod_lokasi . '" sudah digunakan untuk premis ini. Sila gunakan kod yang berlainan.'
                ]);
            }

            // ============================================
            // HANDLE SISTEM - Check if exists or create new
            // ============================================
            if (!empty($validated['sistem'])) {
                $existingSistem = Sistem::where('kod', $validated['sistem'])->first();

                if (!$existingSistem) {
                    // Kod BARU - MESTI ada nama_sistem
                    if (empty($request->nama_sistem)) {
                        throw ValidationException::withMessages([
                            'nama_sistem' => 'Kod sistem "' . $validated['sistem'] . '" adalah baru. Sila masukkan nama sistem.'
                        ]);
                    }

                    // Create new Sistem dengan nama dari form
                    Sistem::create([
                        'kod' => $validated['sistem'],
                        'nama' => $request->nama_sistem,
                        'is_active' => true
                    ]);

                    \Log::info('New Sistem created: ' . $validated['sistem'] . ' - ' . $request->nama_sistem);
                } else {
                    // Kod sudah wujud - ignore nama_sistem if provided
                    if (!empty($request->nama_sistem)) {
                        \Log::info('Sistem "' . $validated['sistem'] . '" already exists. Ignoring provided nama_sistem.');
                    }
                }
            }

            // ============================================
            // HANDLE SUBSISTEM - Check if exists or create new
            // ============================================
            if (!empty($validated['subsistem'])) {
                // Get sistem_id first
                $sistem = Sistem::where('kod', $validated['sistem'])->first();
                $sistemId = $sistem ? $sistem->id : null;

                $existingSubSistem = Subsistem::where('kod', $validated['subsistem'])
                    ->where('sistem_id', $sistemId)
                    ->first();

                if (!$existingSubSistem) {
                    // Kod BARU - MESTI ada nama_subsistem
                    if (empty($request->nama_subsistem)) {
                        throw ValidationException::withMessages([
                            'nama_subsistem' => 'Kod subsistem "' . $validated['subsistem'] . '" adalah baru. Sila masukkan nama subsistem.'
                        ]);
                    }

                    // Create new SubSistem dengan nama dari form
                    Subsistem::create([
                        'kod' => $validated['subsistem'],
                        'nama' => $request->nama_subsistem,
                        'sistem_id' => $sistemId,
                        'is_active' => true
                    ]);

                    \Log::info('New SubSistem created: ' . $validated['subsistem'] . ' - ' . $request->nama_subsistem);
                } else {
                    // Kod sudah wujud - ignore nama_subsistem if provided
                    if (!empty($request->nama_subsistem)) {
                        \Log::info('SubSistem "' . $validated['subsistem'] . '" already exists. Ignoring provided nama_subsistem.');
                    }
                }
            }

            // Handle bidang_id (new dynamic bidang from bidangs table)
            $validated['bidang_id'] = $request->input('bidang_id') ?: null;

            // Handle legacy boolean flags (backward compat — set based on bidang_id if possible)
            $bidang = $validated['bidang_id'] ? Bidang::find($validated['bidang_id']) : null;
            $kodBidang = $bidang ? strtoupper($bidang->kod) : '';
            $validated['awam_arkitek']  = $kodBidang === 'A' ? 1 : 0;
            $validated['elektrikal']    = $kodBidang === 'E' ? 1 : 0;
            $validated['elv_ict']       = $kodBidang === 'T' ? 1 : 0;
            $validated['mekanikal']     = $kodBidang === 'M' ? 1 : 0;
            $validated['bio_perubatan'] = $kodBidang === 'B' ? 1 : 0;

            // BUANG measurement fields (akan guna table measurements)
            unset($validated['saiz'], $validated['saiz_unit']);
            unset($validated['kadaran'], $validated['kadaran_unit']);
            unset($validated['kapasiti'], $validated['kapasiti_unit']);

            // Atribut tambahan
            $validated['jenis'] = $request->input('jenis');
            $validated['bekalan_elektrik'] = $request->input('bekalan_elektrik');
            $validated['bahan'] = $request->input('bahan');
            $validated['kaedah_pemasangan'] = $request->input('kaedah_pemasangan');
            $validated['catatan_atribut'] = $request->input('catatan_atribut');
            $validated['catatan_komponen_berhubung'] = $request->input('catatan_komponen_berhubung');
            $validated['catatan_dokumen'] = $request->input('catatan_dokumen');
            $validated['nota'] = $request->input('nota');

            // IMPORTANT: Explicitly set
            $validated['kod_ptj'] = $request->input('kod_ptj');
            $validated['no_perolehan_1gfmas'] = $request->input('no_perolehan_1gfmas');
            $validated['status'] = $request->input('status', 'aktif');

            // Create main component
            $mainComponent = MainComponent::create($validated);

            // Save measurements ke table baru
            $this->saveMeasurements($mainComponent, $request);

            // Save related data
            $this->saveRelatedComponents($mainComponent, $request);
            $this->saveRelatedDocuments($mainComponent, $request);

            DB::commit();

            // TAMBAH LOG
            AuditLog::create([
                'user_id'      => auth()->id(),
                'component_id' => $mainComponent->component_id,
                'title'        => 'Tambah Komponen Utama',
                'description'  => 'Komponen Utama baru ditambah',
            ]);

            return redirect()->route('components.index')
                ->with('success', 'Komponen Utama berjaya ditambah!');
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e; // Re-throw validation exception

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating main component: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, MainComponent $mainComponent)
    {
        $validated = $request->validate($this->validationRules());

        DB::beginTransaction();
        try {
            // ============================================
            // VALIDATION: Check duplicate Kod Lokasi (exclude current)
            // ============================================
            $duplicateKodLokasi = MainComponent::where('kod_lokasi', $request->kod_lokasi)
                ->where('component_id', $request->component_id)
                ->where('id', '!=', $mainComponent->id)
                ->exists();

            if ($duplicateKodLokasi) {
                throw ValidationException::withMessages([
                    'kod_lokasi' => 'Kod Lokasi "' . $request->kod_lokasi . '" sudah digunakan untuk premis ini. Sila gunakan kod yang berlainan.'
                ]);
            }

            // ============================================
            // HANDLE SISTEM - Check if exists or create new
            // ============================================
            if (!empty($validated['sistem'])) {
                $existingSistem = Sistem::where('kod', $validated['sistem'])->first();

                if (!$existingSistem) {
                    // Kod BARU - MESTI ada nama_sistem
                    if (empty($request->nama_sistem)) {
                        throw ValidationException::withMessages([
                            'nama_sistem' => 'Kod sistem "' . $validated['sistem'] . '" adalah baru. Sila masukkan nama sistem.'
                        ]);
                    }

                    // Create new Sistem
                    Sistem::create([
                        'kod' => $validated['sistem'],
                        'nama' => $request->nama_sistem,
                        'is_active' => true
                    ]);

                    \Log::info('New Sistem created during update: ' . $validated['sistem'] . ' - ' . $request->nama_sistem);
                }
            }

            // ============================================
            // HANDLE SUBSISTEM - Check if exists or create new
            // ============================================
            if (!empty($validated['subsistem'])) {
                // Get sistem_id first
                $sistem = Sistem::where('kod', $validated['sistem'])->first();
                $sistemId = $sistem ? $sistem->id : null;

                $existingSubSistem = Subsistem::where('kod', $validated['subsistem'])
                    ->where('sistem_id', $sistemId)
                    ->first();

                if (!$existingSubSistem) {
                    // Kod BARU - MESTI ada nama_subsistem
                    if (empty($request->nama_subsistem)) {
                        throw ValidationException::withMessages([
                            'nama_subsistem' => 'Kod subsistem "' . $validated['subsistem'] . '" adalah baru. Sila masukkan nama subsistem.'
                        ]);
                    }

                    // Create new SubSistem
                    Subsistem::create([
                        'kod' => $validated['subsistem'],
                        'nama' => $request->nama_subsistem,
                        'sistem_id' => $sistemId,
                        'is_active' => true
                    ]);

                    \Log::info('New SubSistem created during update: ' . $validated['subsistem'] . ' - ' . $request->nama_subsistem);
                }
            }

            // Handle bidang_id (new dynamic bidang from bidangs table)
            $validated['bidang_id'] = $request->input('bidang_id') ?: null;

            // Handle legacy boolean flags (backward compat — set based on bidang_id if possible)
            $bidang = $validated['bidang_id'] ? Bidang::find($validated['bidang_id']) : null;
            $kodBidang = $bidang ? strtoupper($bidang->kod) : '';
            $validated['awam_arkitek']  = $kodBidang === 'A' ? 1 : 0;
            $validated['elektrikal']    = $kodBidang === 'E' ? 1 : 0;
            $validated['elv_ict']       = $kodBidang === 'T' ? 1 : 0;
            $validated['mekanikal']     = $kodBidang === 'M' ? 1 : 0;
            $validated['bio_perubatan'] = $kodBidang === 'B' ? 1 : 0;

            // BUANG measurement fields
            unset($validated['saiz'], $validated['saiz_unit']);
            unset($validated['kadaran'], $validated['kadaran_unit']);
            unset($validated['kapasiti'], $validated['kapasiti_unit']);

            // Atribut tambahan
            $validated['jenis'] = $request->input('jenis');
            $validated['bekalan_elektrik'] = $request->input('bekalan_elektrik');
            $validated['bahan'] = $request->input('bahan');
            $validated['kaedah_pemasangan'] = $request->input('kaedah_pemasangan');
            $validated['catatan_atribut'] = $request->input('catatan_atribut');
            $validated['catatan_komponen_berhubung'] = $request->input('catatan_komponen_berhubung');
            $validated['catatan_dokumen'] = $request->input('catatan_dokumen');
            $validated['nota'] = $request->input('nota');

            // IMPORTANT: Explicitly set
            $validated['kod_ptj'] = $request->input('kod_ptj');
            $validated['no_perolehan_1gfmas'] = $request->input('no_perolehan_1gfmas');

            // Update main component
            $mainComponent->update($validated);

            // Delete & recreate measurements
            $mainComponent->measurements()->delete();
            $this->saveMeasurements($mainComponent, $request);

            // Update related data
            $mainComponent->relatedComponents()->delete();
            $this->saveRelatedComponents($mainComponent, $request);

            $mainComponent->relatedDocuments()->delete();
            $this->saveRelatedDocuments($mainComponent, $request);

            DB::commit();

            // TAMBAH LOG
            AuditLog::create([
                'user_id'      => auth()->id(),
                'component_id' => $mainComponent->component_id,
                'title'        => 'Kemaskini Komponen Utama',
                'description'  => 'Komponen Utama dikemaskini',
            ]);

            return redirect()->route('components.index')
                ->with('success', 'Komponen Utama berjaya dikemaskini!');
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e; // Re-throw validation exception

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating main component: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Gagal mengemaskini: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(MainComponent $mainComponent)
    {
        $components = Component::where('status', 'aktif')->get();
        $sistems    = Sistem::orderBy('kod')->get();
        $subsistems = Subsistem::orderBy('kod')->get();
        $bidangs    = Bidang::active()->get(); // Dynamic bidang from database

        // Load measurements dengan relationships untuk edit form
        $mainComponent->load([
            'measurements',
            'saizMeasurements',
            'kadaranMeasurements',
            'kapasitiMeasurements',
            'relatedComponents',
            'relatedDocuments'
        ]);

        return view('user.components.edit-main-component', compact(
            'mainComponent',
            'components',
            'sistems',
            'subsistems',
            'bidangs'
        ));
    }

    /**
     * ========================================
     * SAVE MEASUREMENTS METHOD
     * ========================================
     */
    private function saveMeasurements(MainComponent $mainComponent, Request $request): void
    {
        // Process Saiz
        $saizValues = $request->input('saiz', []);
        $saizUnits = $request->input('saiz_unit', []);

        if (is_array($saizValues)) {
            foreach ($saizValues as $index => $value) {
                if (!empty(trim($value ?? ''))) {
                    $mainComponent->measurements()->create([
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
                    $mainComponent->measurements()->create([
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
                    $mainComponent->measurements()->create([
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
     * VALIDATION RULES
     * ========================================
     */
    private function validationRules(): array
    {
        return [
            'component_id' => 'required|exists:components,id',
            'bidang_id' => 'nullable|exists:bidangs,id',
            'kod_lokasi' => 'required|string|max:100',
            'nama_komponen_utama' => 'required|string|max:255',
            'sistem' => 'nullable|string|max:255',
            'subsistem' => 'nullable|string|max:255',
            'nama_sistem' => 'nullable|string|max:255', // NEW
            'nama_subsistem' => 'nullable|string|max:255', // NEW
            'kuantiti' => 'nullable|integer|min:1',
            'awam_arkitek' => 'nullable',
            'elektrikal' => 'nullable',
            'elv_ict' => 'nullable',
            'mekanikal' => 'nullable',
            'bio_perubatan' => 'nullable',
            'lain_lain' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'tarikh_perolehan' => 'nullable|date',
            'kos_perolehan' => 'nullable|string|max:100',
            'no_pesanan_rasmi_kontrak' => 'nullable|string|max:255',
            'tarikh_dipasang' => 'nullable|date',
            'tarikh_waranti_tamat' => 'nullable|date',
            'tarikh_tamat_dlp' => 'nullable|date',
            'jangka_hayat' => 'nullable|string|max:50',
            'nama_pengilang' => 'nullable|string|max:255',
            'nama_pembekal' => 'nullable|string|max:255',
            'alamat_pembekal' => 'nullable|string',
            'no_telefon_pembekal' => 'nullable|string|max:50',
            'nama_kontraktor' => 'nullable|string|max:255',
            'alamat_kontraktor' => 'nullable|string',
            'no_telefon_kontraktor' => 'nullable|string|max:50',
            'catatan_maklumat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'status_komponen' => 'nullable|string',
            'jenama' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'no_siri' => 'nullable|string|max:255',
            'no_tag_label' => 'nullable|string|max:255',
            'no_sijil_pendaftaran' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'bekalan_elektrik' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'kaedah_pemasangan' => 'nullable|string|max:255',
            'kod_ptj' => 'nullable|string|max:100',
            'no_perolehan_1gfmas' => 'nullable|string|max:255',

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
            'catatan_komponen_berhubung' => 'nullable|string',
            'catatan_dokumen' => 'nullable|string',
            'nota' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }

    /**
     * ========================================
     * HELPER METHODS (DEPRECATED - now handled in store/update)
     * ========================================
     */

    private function saveSistem(string $kod): void
    {
        // DEPRECATED: Now handled directly in store() and update()
        $exists = Sistem::where('kod', $kod)->exists();

        if (!$exists) {
            Sistem::create([
                'kod' => $kod,
                'nama' => $kod,
            ]);
        }
    }

    private function saveSubsistem(string $kod, ?string $sistemKod = null): void
    {
        // DEPRECATED: Now handled directly in store() and update()
        $exists = Subsistem::where('kod', $kod)->exists();

        if (!$exists) {
            $sistemId = null;
            if ($sistemKod) {
                $sistem = Sistem::where('kod', $sistemKod)->first();
                $sistemId = $sistem?->id;
            }

            Subsistem::create([
                'kod' => $kod,
                'nama' => $kod,
                'sistem_id' => $sistemId,
            ]);
        }
    }

    private function saveRelatedComponents(MainComponent $mainComponent, Request $request): void
    {
        $bils = $request->input('related_bil', []);
        $namas = $request->input('related_nama', []);
        $dpas = $request->input('related_dpa', []);
        $tags = $request->input('related_tag', []);

        if (!empty($namas) && is_array($namas)) {
            foreach ($namas as $index => $nama) {
                if (empty(trim($nama ?? ''))) {
                    continue;
                }

                \App\Models\RelatedComponent::create([
                    'main_component_id' => $mainComponent->id,
                    'bil' => $bils[$index] ?? ($index + 1),
                    'nama_komponen' => $nama,
                    'no_dpa_kod_ruang' => $dpas[$index] ?? null,
                    'no_tag_label' => $tags[$index] ?? null,
                ]);
            }
        }
    }

    private function saveRelatedDocuments(MainComponent $mainComponent, Request $request): void
    {
        $bils = $request->input('doc_bil', []);
        $namas = $request->input('doc_nama', []);
        $rujukans = $request->input('doc_rujukan', []);
        $catatans = $request->input('doc_catatan', []);

        if (!empty($namas) && is_array($namas)) {
            foreach ($namas as $index => $nama) {
                if (empty(trim($nama ?? ''))) {
                    continue;
                }

                \App\Models\RelatedDocument::create([
                    'main_component_id' => $mainComponent->id,
                    'bil' => $bils[$index] ?? ($index + 1),
                    'nama_dokumen' => $nama,
                    'no_rujukan_berkaitan' => $rujukans[$index] ?? null,
                    'catatan' => $catatans[$index] ?? null,
                ]);
            }
        }
    }

    /**
     * ========================================
     * CRUD METHODS
     * ========================================
     */

    public function generateKodLokasi(Request $request)
    {
        $componentId = $request->get('component_id');
        $component = Component::find($componentId);

        if (!$component) {
            return response()->json(['kod_lokasi' => ''], 400);
        }

        $count = MainComponent::where('component_id', $componentId)->count() + 1;
        $kodLokasi = 'KU-' . $componentId . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return response()->json(['kod_lokasi' => $kodLokasi]);
    }

    public function create()
    {
        $components = Component::where('status', 'aktif')->get();
        $sistems    = Sistem::orderBy('kod')->get();
        $subsistems = Subsistem::orderBy('kod')->get();
        $bidangs    = Bidang::active()->get(); // Dynamic bidang from database

        return view('user.components.create-main-component', compact(
            'components',
            'sistems',
            'subsistems',
            'bidangs'
        ));
    }

    public function show(MainComponent $mainComponent)
    {
        //  TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $mainComponent->component_id,
            'title'        => 'Lihat Komponen Utama',
            'description'  => 'Komponen Utama dilihat',
        ]);

        $mainComponent->load([
            'component',
            'subComponents',
            'relatedComponents',
            'relatedDocuments',
            'measurements',
            'saizMeasurements',
            'kadaranMeasurements',
            'kapasitiMeasurements'
        ]);

        return view('user.components.view-main-component', compact('mainComponent'));
    }

    public function destroy(MainComponent $mainComponent)
    {
        // TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $mainComponent->component_id,
            'title'        => 'Padam Komponen Utama',
            'description'  => 'Komponen Utama dipadam ',
        ]);
        $mainComponent->delete();

        return redirect()->route('components.index')
            ->with('success', 'Komponen Utama berjaya dipadam');
    }

    public function trashed()
    {
        $mainComponents = MainComponent::onlyTrashed()
            ->with(['component', 'subComponents'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('main-components.trashed', compact('mainComponents'));
    }

    public function restore($id)
    {
        $mainComponent = MainComponent::onlyTrashed()->findOrFail($id);
        $mainComponent->restore();

        return redirect()->route('main-components.trashed')
            ->with('success', 'Komponen Utama berjaya dipulihkan');
    }

    public function forceDestroy($id)
    {
        $mainComponent = MainComponent::onlyTrashed()->findOrFail($id);
        $mainComponent->forceDelete();

        return redirect()->route('main-components.trashed')
            ->with('success', 'Komponen Utama berjaya dipadam secara kekal');
    }
}
