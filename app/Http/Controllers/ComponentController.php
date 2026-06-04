<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Sistem;
use App\Models\Subsistem;
use App\Models\KodBlok;
use App\Models\KodAras;
use App\Models\KodRuang;
use App\Models\NamaRuang;
use App\Models\KodBinaanLuar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class ComponentController extends Controller
{
    /**
     * Display user dashboard with their components
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // $user = Auth::user();
        // ✅ FIXED: Eager loading to prevent N+1 queries
        // $components = Component::where('user_id', $user->id)
        //     ->with(['mainComponents.subComponents', 'sistem', 'subsistem'])
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        if (auth()->user()->isAdmin()) {
            $components = Component::with([
                'mainComponents.subComponents',
                'sistem',
                'subsistem'
            ])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {

            $components = Component::query()
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhereHas('mainComponents', function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                                ->orWhereHas('subComponents', function ($q) use ($user) {
                                    $q->where('user_id', $user->id);
                                });
                        });
                })
                ->with(['mainComponents.subComponents', 'sistem', 'subsistem'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Get statistics for stats cards
        $stats = [
            'total_components' => $components->count(),
            'active_components' => $components->where('status', 'aktif')->count(),
            'total_main_components' => $components->sum(function ($component) {
                return $component->mainComponents->count();
            }),
            'total_sub_components' => $components->sum(function ($component) {
                return $component->mainComponents->sum(function ($mainComponent) {
                    return $mainComponent->subComponents->count();
                });
            }),
        ];

        // Get recent components (last 5)
        $recentComponents = Component::where('user_id', $user->id)
            ->with(['sistem', 'subsistem'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get sistem statistics (user's components distribution)
        $sistemStats = Sistem::withCount([
            'subsistems',
            'components' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])
            ->get();

        // Components by month (last 12 months)
        $componentsByMonth = Component::where('user_id', $user->id)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        // ✅ Support both view paths for flexibility
        $viewPath = view()->exists('components.index')
            ? 'components.index'
            : 'user.components.index';

        return view($viewPath, compact(
            'components',
            'stats',
            'recentComponents',
            'sistemStats',
            'componentsByMonth'
        ));
    }

    /**
     * Show the form for creating a new component
     */
    public function create()
    {
        // ✅ FIXED: Pass ALL required variables to the view
        $sistems = Sistem::active()->get();
        $subsistems = Subsistem::active()->get();

        // Master data for dropdowns
        $kodBloks = KodBlok::orderBy('kod')->get();
        $kodAras = KodAras::orderBy('kod')->get();
        $kodRuangs = KodRuang::orderBy('kod')->get();
        $namaRuangs = NamaRuang::orderBy('nama')->get();
        $kodBinaanLuar = KodBinaanLuar::where('status', 'aktif')->orderBy('kod')->get();

        return view('user.components.create-component', compact(
            'sistems',
            'subsistems',
            'kodBloks',
            'kodAras',
            'kodRuangs',
            'namaRuangs',
            'kodBinaanLuar'
        ));
    }

    /**
     * Store a newly created component
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Basic fields
            'sistem_id' => 'nullable|exists:sistems,id',
            'subsistem_id' => 'nullable|exists:subsistems,id',
            'nama_premis' => 'required|string|max:255',
            'kod_lokasi' => 'nullable|string|max:50',
            'nombor_dpa' => 'required|string|max:100',
            'status' => 'required|in:aktif,tidak_aktif',

            // Blok fields
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:50',
            'nama_blok' => 'nullable|string|max:255',
            'kod_aras' => 'nullable|string|max:50',
            'nama_aras' => 'nullable|string|max:255',
            'kod_ruang' => 'nullable|string|max:50',
            'nama_ruang' => 'nullable|string|max:255',
            'nama_ruang_dari_kod' => 'nullable|string|max:255',
            'catatan_blok' => 'nullable|string',

            // Binaan Luar fields
            'ada_binaan_luar' => 'nullable|boolean',
            'nama_binaan_luar' => 'nullable|string|max:255',
            'kod_binaan_luar' => 'nullable|string|max:50',
            'nama_binaan_luar_dari_kod' => 'nullable|string|max:255',
            'koordinat_x' => 'nullable|numeric',
            'koordinat_y' => 'nullable|numeric',
            'kod_aras_binaan' => 'nullable|string|max:50',
            'nama_aras_binaan' => 'nullable|string|max:255',
            'kod_ruang_binaan' => 'nullable|string|max:50',
            'nama_ruang_binaan' => 'nullable|string|max:255',
            'nama_ruang_binaan_dari_kod' => 'nullable|string|max:255',
            'catatan_binaan' => 'nullable|string',
        ]);

        $validated['ada_blok'] = $request->has('ada_blok');

        if (!$validated['ada_blok']) {
            $validated['kod_blok'] = null;
            $validated['nama_blok'] = null;
            $validated['nama_aras'] = null;
            $validated['kod_aras'] = null;
            $validated['kod_ruang'] = null;
            $validated['nama_ruang'] = null;
            $validated['catatan_blok'] = null;
        }

        $validated['ada_binaan_luar'] = $request->has('ada_binaan_luar');

        if (!$validated['ada_binaan_luar']) {
            $validated['kod_binaan_luar'] = null;
            $validated['koordinat_x'] = null;
            $validated['koordinat_y'] = null;
            $validated['kod_aras_binaan'] = null;
            $validated['nama_aras_binaan'] = null;
            $validated['nama_ruang_binaan'] = null;
            $validated['catatan_binaan'] = null;
        }

        $validated['user_id'] = Auth::id();

        $component = Component::create($validated);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $component->id,
            'title'        => 'Tambah Komponen',
            'description'  => 'Komponen baru ditambah - Nama Premis: ' . $component->nama_premis . ', Nombor DPA: ' . $component->nombor_dpa,
        ]);

        return redirect()->route('components.show', $component)
            ->with('success', 'Komponen berjaya ditambah.');
    }

    /**
     * Display the specified component
     */
    public function show(Component $component)

    {
        // Ensure user can only view their own components (unless admin)
        if (Auth::user()->role !== 'admin' && $component->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $component->id,
            'title'        => 'Lihat Komponen',
            'description'  => 'Komponen dilihat - Nama Premis: ' . $component->nama_premis . ', Nombor DPA: ' . $component->nombor_dpa,
        ]);

        $component->load(['mainComponents.subComponents', 'sistem', 'subsistem']);
        return view('user.components.view-component', compact('component'));
    }

    /**
     * Show the form for editing the specified component
     */
    public function edit(Component $component)
    {
        // Ensure user can only edit their own components (unless admin)
        if (Auth::user()->role !== 'admin' && $component->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $sistems = Sistem::active()->get();
        $subsistems = Subsistem::active()->get();

        // Master data for dropdowns
        $kodBloks = KodBlok::orderBy('kod')->get();
        $kodAras = KodAras::orderBy('kod')->get();
        $kodRuangs = KodRuang::orderBy('kod')->get();
        $namaRuangs = NamaRuang::orderBy('nama')->get();
        $kodBinaanLuar = KodBinaanLuar::where('status', 'aktif')->orderBy('kod')->get();

        return view('user.components.edit-component', compact(
            'component',
            'sistems',
            'subsistems',
            'kodBloks',
            'kodAras',
            'kodRuangs',
            'namaRuangs',
            'kodBinaanLuar'
        ));
    }

    /**
     * Update the specified component
     */
    public function update(Request $request, Component $component)
    {
        // Ensure user can only update their own components (unless admin)
        if (Auth::user()->role !== 'admin' && $component->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            // Basic fields
            'sistem_id' => 'nullable|exists:sistems,id',
            'subsistem_id' => 'nullable|exists:subsistems,id',
            'nama_premis' => 'required|string|max:255',
            'kod_lokasi' => 'nullable|string|max:50',
            'nombor_dpa' => 'required|string|max:100',
            'status' => 'required|in:aktif,tidak_aktif',

            // Blok fields
            'ada_blok' => 'nullable|boolean',
            'kod_blok' => 'nullable|string|max:50',
            'nama_blok' => 'nullable|string|max:255',
            'kod_aras' => 'nullable|string|max:50',
            'nama_aras' => 'nullable|string|max:255',
            'kod_ruang' => 'nullable|string|max:50',
            'nama_ruang' => 'nullable|string|max:255',
            'nama_ruang_dari_kod' => 'nullable|string|max:255',
            'catatan_blok' => 'nullable|string',

            // Binaan Luar fields
            'ada_binaan_luar' => 'nullable|boolean',
            'nama_binaan_luar' => 'nullable|string|max:255',
            'kod_binaan_luar' => 'nullable|string|max:50',
            'nama_binaan_luar_dari_kod' => 'nullable|string|max:255',
            'koordinat_x' => 'nullable|numeric',
            'koordinat_y' => 'nullable|numeric',
            'kod_aras_binaan' => 'nullable|string|max:50',
            'nama_aras_binaan' => 'nullable|string|max:255',
            'kod_ruang_binaan' => 'nullable|string|max:50',
            'nama_ruang_binaan' => 'nullable|string|max:255',
            'nama_ruang_binaan_dari_kod' => 'nullable|string|max:255',
            'catatan_binaan' => 'nullable|string',
        ]);

        $validated['ada_blok'] = $request->has('ada_blok');

        if (!$validated['ada_blok']) {
            $validated['kod_blok'] = null;
            $validated['nama_blok'] = null;
            $validated['nama_aras'] = null;
            $validated['kod_aras'] = null;
            $validated['kod_ruang'] = null;
            $validated['nama_ruang'] = null;
            $validated['catatan_blok'] = null;
        }

        $validated['ada_binaan_luar'] = $request->has('ada_binaan_luar');

        if (!$validated['ada_binaan_luar']) {
            $validated['kod_binaan_luar'] = null;
            $validated['koordinat_x'] = null;
            $validated['koordinat_y'] = null;
            $validated['kod_aras_binaan'] = null;
            $validated['nama_aras_binaan'] = null;
            $validated['nama_ruang_binaan'] = null;
            $validated['catatan_binaan'] = null;
        }

        // dd([
        //     'validated' => $validated,
        //     'fillable' => $component->getFillable(),
        // ]);

        $component->update($validated);
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $component->id,
            'title'        => 'Kemaskini Komponen',
            'description'  => 'Komponen dikemaskini ',
        ]);

        return redirect()->route('components.show', $component)
            ->with('success', 'Komponen berjaya dikemaskini.');
    }

    /**
     * Soft delete the specified component
     */
    public function destroy(Component $component)
    {
        // Ensure user can only delete their own components (unless admin)
        if (Auth::user()->role !== 'admin' && $component->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $component->delete();

        // Tambah Log
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $component->id,
            'title'        => 'Padam Komponen',
            'description'  => 'Komponen dipadam ',
        ]);

       

        return redirect()->route('components.index')
            ->with('success', 'Komponen berjaya dipadam.');
    }

    /**
     * Display trashed components
     */
    public function trashed()
    {
        $user = Auth::user();

        $components = Component::onlyTrashed()
            ->where('user_id', $user->id)
            ->with(['sistem', 'subsistem'])
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('user.components.trashed', compact('components'));
    }

    /**
     * Restore a trashed component
     */
    public function restore($id)
    {
        $component = Component::onlyTrashed()->findOrFail($id);

        // Ensure user can only restore their own components (unless admin)
        if (Auth::user()->role !== 'admin' && $component->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $component->restore();

        return redirect()->route('components.index')
            ->with('success', 'Komponen berjaya dipulihkan.');
    }

    /**
     * Permanently delete a trashed component
     */
    public function forceDestroy($id)
    {
        $component = Component::onlyTrashed()->findOrFail($id);

        // Ensure user can only force delete their own components (unless admin)
        if (Auth::user()->role !== 'admin' && $component->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $component->forceDelete();

        return redirect()->route('components.trashed')
            ->with('success', 'Komponen berjaya dipadam sepenuhnya.');
    }
}
