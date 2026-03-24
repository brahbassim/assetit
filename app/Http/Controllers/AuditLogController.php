<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $auditLogs = AuditLog::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%')
                    ->orWhere('model_type', 'like', '%' . $request->search . '%');
            })
            ->when($request->action, function ($query) use ($request) {
                $query->where('action', $request->action);
            })
            ->latest()
            ->paginate(20);

        $actions = AuditLog::distinct()->pluck('action');

        return view('audit-logs.index', compact('auditLogs', 'actions'));
    }
}
