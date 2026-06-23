<?php

namespace App\Http\Controllers;

use App\Models\Sistem;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class SistemController extends Controller
{
    /**
     * Display a listing of systems
     */
    public function index(Request $request)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Lihat Konfigurasi Sistem',
            'description'  => 'Pengguna melihat senarai konfigurasi sistem',
        ]);

        $query = Sistem::withCount('subsistems');

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

        $sistems = $query->orderBy('kod')->paginate(12);

        return view('admin.sistem.index', compact('sistems'));
    }

    /**
     * Show the form for creating a new system
     */
    public function create()
    {
        return view('admin.sistem.create');
    }

    /**
     * Store a newly created system
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:sistems',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kod.required' => 'Kod sistem diperlukan',
            'kod.unique' => 'Kod sistem sudah wujud',
            'nama.required' => 'Nama sistem diperlukan',
        ]);

        // Handle checkbox - will be true if checked, false if unchecked
        $validated['is_active'] = $request->has('is_active');

        $sistem = Sistem::create($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Tambah Sistem',
            'description'  => 'Sistem baru ditambah',
        ]);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya ditambah!');
    }

    /**
     * Show the form for editing the system
     */
    public function edit(Sistem $sistem)
    {
        return view('admin.sistem.edit', compact('sistem'));
    }

    /**
     * Update the system
     */
    public function update(Request $request, Sistem $sistem)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:sistems,kod,' . $sistem->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kod.required' => 'Kod sistem diperlukan',
            'kod.unique' => 'Kod sistem sudah wujud',
            'nama.required' => 'Nama sistem diperlukan',
        ]);

        // Handle checkbox - will be true if checked, false if unchecked
        $validated['is_active'] = $request->has('is_active');

        $sistem->update($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Kemaskini Sistem',
            'description'  => 'Sistem dikemaskini',
        ]);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dikemaskini!');
    }

    /**
     * Remove the system
     */
    public function destroy(Sistem $sistem)
    {
        // Check if sistem has subsistems
        if ($sistem->subsistems()->count() > 0) {
            return back()->with('error', 'Sistem tidak boleh dipadam kerana masih mempunyai subsistem!');
        }

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Padam Sistem',
            'description'  => 'Sistem dipadam',
        ]);

        $sistem->delete();

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dipadam!');
    }

    /**
     * Show subsistems for a system
     */
    public function subsistems(Sistem $sistem)
    {
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => null,
            'title'        => 'Lihat Senarai Subsistem',
            'description'  => 'Lihat subsistem ' . $sistem->nama,
        ]);

        $subsistems = $sistem->subsistems()->paginate(15);

        return view('admin.sistem.subsystems', compact('sistem', 'subsistems'));
    }
}