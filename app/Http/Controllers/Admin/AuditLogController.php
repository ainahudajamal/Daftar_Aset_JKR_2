<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Component;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user', 'component');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->component_id) {
            $query->where('component_id', $request->component_id);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(15);
        $components = Component::orderBy('id')->get();

        return view('admin.audit_log.index', compact('logs', 'components'));
    }

    public function create()
    {
        $components = Component::orderBy('id')->get();
        return view('admin.audit_log.create', compact('components'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'component_id' => 'nullable|exists:components,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
        ], [
            'title.required' => 'Tajuk wajib diisi.',
        ]);

        AuditLog::create([
            'user_id'      => auth()->id(),
            'component_id' => $request->component_id,
            'title'        => $request->title,
            'description'  => $request->description,
        ]);

        return redirect()->route('admin.audit_log.index')
                         ->with('success', 'Log berjaya ditambah.');
    }

    public function show(AuditLog $auditLog)
    {
        return view('admin.audit_log.show', compact('auditLog'));
    }

    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return redirect()->route('admin.audit_log.index')
                         ->with('success', 'Log berjaya dipadam.');
    }
}