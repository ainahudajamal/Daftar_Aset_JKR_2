<?php

namespace App\Http\Controllers;

use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SistemManagementController extends Controller
{
    /**
     * Display listing of sistem
     */
    public function index(Request $request)
    {
        $query = Sistem::withCount('subsistems');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        $sistems = $query->orderBy('kod')->paginate(15);

        return view('admin.sistem.index', compact('sistems'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.sistem.create');
    }

    /**
     * Store new sistem
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:sistems,kod',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'kod.unique' => 'Kod sistem sudah wujud',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Sistem::create($validated);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya ditambah!');
    }

    /**
     * Show edit form
     */
    public function edit(Sistem $sistem)
    {
        return view('admin.sistem.edit', compact('sistem'));
    }

    /**
     * Update sistem
     */
    public function update(Request $request, Sistem $sistem)
    {
        $validated = $request->validate([
            'kod' => 'required|string|max:50|unique:sistems,kod,' . $sistem->id,
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $sistem->update($validated);

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dikemaskini!');
    }

    /**
     * Delete sistem
     */
    public function destroy(Sistem $sistem)
    {
        // Check if sistem has subsistems
        if ($sistem->subsistems()->count() > 0) {
            return back()->with('error', 'Sistem tidak boleh dipadam kerana masih mempunyai subsistem!');
        }

        $sistem->delete();

        return redirect()->route('admin.sistem.index')
            ->with('success', 'Sistem berjaya dipadam!');
    }

    /**
     * Display subsistems for a sistem
     */
    public function subsistems(Sistem $sistem)
    {
        $subsistems = $sistem->subsistems()->orderBy('kod')->paginate(15);

        return view('admin.sistem.subsistems', compact('sistem', 'subsistems'));
    }

    /**
     * Show create subsistem form
     */
    public function createSubsistem(Sistem $sistem)
    {
        return view('admin.sistem.create-subsistem', compact('sistem'));
    }

    /**
     * Store new subsistem
     */
    public function storeSubsistem(Request $request, Sistem $sistem)
    {
        $validated = $request->validate([
            'kod' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('subsistems')->where('sistem_id', $sistem->id),
            ],
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ], [
            'kod.unique' => 'Kod subsistem sudah wujud',
        ]);

        $validated['sistem_id'] = $sistem->id;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Subsistem::create($validated);

        return redirect()->route('admin.sistem.subsistems', $sistem)
            ->with('success', 'Subsistem berjaya ditambah!');
    }

    /**
     * Show edit subsistem form
     */
    public function editSubsistem(Sistem $sistem, Subsistem $subsistem)
    {
        return view('admin.sistem.edit-subsistem', compact('sistem', 'subsistem'));
    }

    /**
     * Update subsistem
     */
    public function updateSubsistem(Request $request, Sistem $sistem, Subsistem $subsistem)
    {
        $validated = $request->validate([
            'kod' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('subsistems')
                    ->where('sistem_id', $sistem->id)
                    ->ignore($subsistem->id),
            ],
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $subsistem->update($validated);

        return redirect()->route('admin.sistem.subsistems', $sistem)
            ->with('success', 'Subsistem berjaya dikemaskini!');
    }

    /**
     * Delete subsistem
     */
    public function destroySubsistem(Sistem $sistem, Subsistem $subsistem)
    {
        $subsistem->delete();

        return redirect()->route('admin.sistem.subsistems', $sistem)
            ->with('success', 'Subsistem berjaya dipadam!');
    }
}