<?php

namespace App\Http\Controllers;

use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class SubsistemController extends Controller
{
    /**
     * Show the form for creating a new subsistem
     */
    public function create(Sistem $sistem)
    {
        return view('admin.subsistem.create', compact('sistem'));
    }

    /**
     * Store a newly created subsistem
     */
    public function store(Request $request, Sistem $sistem)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:subsistems',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kod.required' => 'Kod subsistem diperlukan',
            'kod.unique' => 'Kod subsistem sudah wujud',
            'nama.required' => 'Nama subsistem diperlukan',
        ]);

        $validated['sistem_id'] = $sistem->id;
        $validated['is_active'] = $request->has('is_active');

        $subsistem = Subsistem::create($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Tambah Subsistem',
            'description'  => 'Subsistem baru ditambah',
        ]);

        return redirect()->route('admin.sistem.subsistems', $sistem)
            ->with('success', 'Subsistem berjaya ditambah!');
    }

    /**
     * Show the form for editing the subsistem
     */
    public function edit(Sistem $sistem, Subsistem $subsistem)
    {
        return view('admin.subsistem.edit', compact('sistem', 'subsistem'));
    }

    /**
     * Update the subsistem
     */
    public function update(Request $request, Sistem $sistem, Subsistem $subsistem)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:subsistems,kod,' . $subsistem->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kod.required' => 'Kod subsistem diperlukan',
            'kod.unique' => 'Kod subsistem sudah wujud',
            'nama.required' => 'Nama subsistem diperlukan',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $subsistem->update($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Kemaskini Subsistem',
            'description'  => 'Subsistem dikemaskini',
        ]);

        return redirect()->route('admin.sistem.subsistems', $sistem)
            ->with('success', 'Subsistem berjaya dikemaskini!');
    }

    /**
     * Remove the subsistem
     */
    public function destroy(Sistem $sistem, Subsistem $subsistem)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Padam Subsistem',
            'description'  => 'Subsistem dipadam',
        ]);

        $subsistem->delete();

        return redirect()->route('admin.sistem.subsistems', $sistem)
            ->with('success', 'Subsistem berjaya dipadam!');
    }
}