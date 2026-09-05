<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function create()
    {
        return view('maintenance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
            'issue_description' => 'required|string',
        ]);

        MaintenanceRequest::create([
            'user_id' => Auth::id(),
            'device_name' => $request->device_name,
            'issue_description' => $request->issue_description,
            'status' => 'pending',
        ]);

        return redirect()->route('profile.maintenance')->with('success', __('Maintenance request submitted successfully.'));
    }

    public function index()
    {
        $requests = Auth::user()->maintenanceRequests()->latest()->get();
        return view('maintenance.index', compact('requests'));
    }
}
