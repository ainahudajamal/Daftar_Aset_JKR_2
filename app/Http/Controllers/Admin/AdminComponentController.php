<?php
// app/Http/Controllers/Admin/ComponentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class AdminComponentController extends Controller
{
    /**
     * Display a listing of all components (Admin view)
     */
    public function index(Request $request)
    {
        $query = Component::with(['user', 'mainComponents'])->withCount('mainComponents');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_premis', 'like', "%{$search}%")
                    ->orWhere('nombor_dpa', 'like', "%{$search}%")
                    ->orWhere('kod_blok', 'like', "%{$search}%")
                    ->orWhere('nama_blok', 'like', "%{$search}%")
                    ->orWhere('kod_binaan_luar', 'like', "%{$search}%")
                    ->orWhere('nama_binaan_luar', 'like', "%{$search}%");
            });
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->aktif();
            } elseif ($request->status === 'tidak_aktif') {
                $query->tidakAktif();
            }
        }

        // Filter by type (blok/binaan luar)
        if ($request->filled('type')) {
            if ($request->type === 'blok') {
                $query->where('ada_blok', true);
            } elseif ($request->type === 'binaan_luar') {
                $query->where('ada_binaan_luar', true);
            }
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $components = $query->paginate(15)->withQueryString();

        // Get users who have created components
        $users = User::whereHas('components')
            ->active()
            ->orderBy('name')
            ->get();

        return view('admin.components.index', compact('components', 'users'));
    }

    /**
     * Display the specified component (Admin view)
     */
    public function show(Component $component)
    {
        // TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $component->id,
            'title'        => 'Lihat Komponen',
            'description'  => 'Admin melihat komponen',
        ]);

        $component->load(['user', 'mainComponents.subComponents', 'mainComponents.user']);
        return view('admin.components.show', compact('component'));
    }

    /**
     * Soft delete the specified component
     */
    public function destroy(Component $component)
    {
        try {

            // TAMBAH LOG
            AuditLog::create([
                'user_id'      => auth()->id(),
                'component_id' => $component->id,
                'title'        => 'Padam Komponen',
                'description'  => 'Admin memadam komponen - Nama Premis: ' . $component->nama_premis,
            ]);
            $component->delete();
            return redirect()->route('admin.components.index')
                ->with('success', 'Komponen berjaya dipadam dan dipindahkan ke arkib.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat memadam komponen: ' . $e->getMessage());
        }
    }

    /**
     * Toggle component status (aktif/tidak_aktif)
     */
    public function toggleStatus(Component $component)
    {
        $newStatus = $component->status === 'aktif' ? 'tidak_aktif' : 'aktif';

        $component->update([
            'status' => $newStatus
        ]);

        //  TAMBAH LOG
        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $component->id,
            'title'        => 'Tukar Status Komponen',
            'description'  => 'Status komponen ditukar kepada ' . $newStatus . ' - Nama Premis: ' . $component->nama_premis,
        ]);

        return redirect()->back()
            ->with('success', 'Status komponen berjaya dikemaskini kepada ' . $newStatus . '.');
    }

    /**
     * Display trashed components
     */
    public function trashed(Request $request)
    {
        $query = Component::onlyTrashed()->with(['user', 'mainComponents']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_premis', 'like', "%{$search}%")
                    ->orWhere('nombor_dpa', 'like', "%{$search}%");
            });
        }

        $components = $query->orderBy('deleted_at', 'desc')->paginate(15);

        return view('admin.components.trashed', compact('components'));
    }

    /**
     * Restore a trashed component
     */
    public function restore($id)
    {
        try {
            $component = Component::onlyTrashed()->findOrFail($id);
            $component->restore();

            return redirect()->back()
                ->with('success', 'Komponen berjaya dipulihkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat memulihkan komponen: ' . $e->getMessage());
        }
    }

    /**
     * Permanently delete a trashed component
     */
    public function forceDelete($id)
    {
        try {
            $component = Component::onlyTrashed()->findOrFail($id);
            $component->forceDelete();

            return redirect()->route('admin.components.trashed')
                ->with('success', 'Komponen berjaya dipadam secara kekal.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat memadam komponen: ' . $e->getMessage());
        }
    }

    /**
     * Display statistics dashboard
     */
    public function statistics()
    {
        $stats = [
            'total_components' => Component::count(),
            'active_components' => Component::aktif()->count(),
            'inactive_components' => Component::tidakAktif()->count(),
            'trashed_components' => Component::onlyTrashed()->count(),
            'total_users' => User::whereHas('components')->count(),
            'components_with_blok' => Component::where('ada_blok', true)->count(),
            'components_with_binaan_luar' => Component::where('ada_binaan_luar', true)->count(),
            'recent_components' => Component::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'top_users' => User::withCount('components')
                ->having('components_count', '>', 0)
                ->orderBy('components_count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.components.statistics', compact('stats'));
    }

    /**
     * Bulk operations
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'component_ids' => 'required|array',
            'component_ids.*' => 'exists:components,id'
        ]);

        try {
            $components = Component::whereIn('id', $request->component_ids);

            switch ($request->action) {
                case 'activate':
                    $components->update(['status' => 'aktif']);
                    $message = 'Komponen berjaya diaktifkan.';
                    break;

                case 'deactivate':
                    $components->update(['status' => 'tidak_aktif']);
                    $message = 'Komponen berjaya dinyahaktifkan.';
                    break;

                case 'delete':
                    $components->delete();
                    $message = 'Komponen berjaya dipadam.';
                    break;
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat melakukan tindakan: ' . $e->getMessage());
        }
    }
}
