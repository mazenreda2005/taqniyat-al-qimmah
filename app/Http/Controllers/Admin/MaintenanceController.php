<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $requests = MaintenanceRequest::with('user')->latest()->paginate(15);
        return view('admin.maintenance.index', compact('requests'));
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load('user');
        return view('admin.maintenance.show', compact('maintenanceRequest'));
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        $maintenanceRequest->update($request->only(['status', 'admin_notes', 'cost']));

        return back()->with('success', __('Maintenance request updated successfully.'));
    }
}
