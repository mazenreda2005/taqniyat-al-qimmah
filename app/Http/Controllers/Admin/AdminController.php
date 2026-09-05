<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $stats = [
            'total_orders' => \App\Models\Order::count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'total_products' => \App\Models\Product::count(),
            'maintenance_requests' => \App\Models\MaintenanceRequest::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
