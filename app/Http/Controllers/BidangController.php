<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class BidangController extends Controller
{
    /**
     * Display a listing of field codes
     */
    public function index(Request $request)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Lihat Konfigurasi Bidang',
            'description'  => 'Admin melihat senarai konfigurasi bidang',
        ]);

        $query = Bidang::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kod', 'like', "%{$request->search}%")
                  ->orWhere('nama', 'like', "%{$request->search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        $bidangs = $query->orderBy('kod')->paginate(12);

        return view('admin.bidang.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new field code
     */
    public function create()
    {
        return view('admin.bidang.create');
    }

    /**
     * Store a newly created field code
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:bidangs',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kod.required' => 'Kod bidang diperlukan',
            'kod.unique' => 'Kod bidang sudah wujud',
            'nama.required' => 'Nama bidang diperlukan',
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');
        $validated['status'] = $validated['is_active'] ? 'aktif' : 'tidak_aktif';

        $bidang = Bidang::create($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Tambah Bidang',
            'description'  => 'Bidang baru ditambah - Kod: ' . $bidang->kod,
        ]);

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Kod bidang berjaya ditambah!');
    }

    /**
     * Show the form for editing the field code
     */
    public function edit(Bidang $bidang)
    {
        return view('admin.bidang.edit', compact('bidang'));
    }

    /**
     * Update the field code
     */
    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:bidangs,kod,' . $bidang->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kod.required' => 'Kod bidang diperlukan',
            'kod.unique' => 'Kod bidang sudah wujud',
            'nama.required' => 'Nama bidang diperlukan',
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');
        $validated['status'] = $validated['is_active'] ? 'aktif' : 'tidak_aktif';

        $bidang->update($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Kemaskini Bidang',
            'description'  => 'Bidang dikemaskini - Kod: ' . $bidang->kod,
        ]);

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Kod bidang berjaya dikemaskini!');
    }

    /**
     * Remove the field code
     */
    public function destroy(Bidang $bidang)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Padam Bidang',
            'description'  => 'Bidang dipadam - Kod: ' . $bidang->kod,
        ]);

        $bidang->delete();

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Kod bidang berjaya dipadam!');
    }
}
