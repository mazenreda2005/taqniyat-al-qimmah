<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SliderSettings;
use Illuminate\Http\Request;

/**
 * Admin controller for managing homepage slider
 * Allows admin to select products, set order, and configure settings
 */
class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display slider management page
     */
    public function index()
    {
        // Get all available products
        $products = Product::where('is_available', true)
            ->orderBy('name_ar')
            ->get();
        
        // Get currently featured products
        $featuredProducts = Product::featured()->get();
        
        // Get slider settings
        $settings = SliderSettings::getSettings();

        return view('admin.slider.index', compact('products', 'featuredProducts', 'settings'));
    }

    /**
     * Update featured products
     */
    public function updateProducts(Request $request)
    {
        $request->validate([
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        // Remove all current featured products
        Product::where('is_featured', true)->update([
            'is_featured' => false,
            'featured_order' => 0,
        ]);

        // Set new featured products with order
        if ($request->has('products')) {
            foreach ($request->products as $order => $productId) {
                Product::where('id', $productId)->update([
                    'is_featured' => true,
                    'featured_order' => $order,
                ]);
            }
        }

        return redirect()->route('admin.slider.index')
            ->with('success', __('Slider products updated successfully.'));
    }

    /**
     * Update slider settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'slide_duration' => 'required|integer|min:1000|max:60000',
            'max_products' => 'required|integer|min:1|max:20',
        ]);

        $settings = SliderSettings::getSettings();
        $settings->update([
            'slide_duration' => $request->slide_duration,
            'max_products' => $request->max_products,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.slider.index')
            ->with('success', __('Slider settings updated successfully.'));
    }
}
