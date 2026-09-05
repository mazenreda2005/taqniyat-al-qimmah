<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SliderSettings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with slider, laptop animation, categories and products
     */
    public function index()
    {
        // Get active categories
        $categories = Category::where('is_active', true)->get();
        
        // Get featured products for grid display
        $featuredProducts = Product::with('category')
            ->where('is_available', true)
            ->latest()
            ->take(12)
            ->get();
        
        // Get slider settings
        $sliderSettings = SliderSettings::getSettings();
        
        // Get featured products for slider (controlled by admin)
        $sliderProducts = Product::with('category')
            ->featured()
            ->take($sliderSettings->max_products)
            ->get();
        
        return view('home', compact(
            'categories', 
            'featuredProducts', 
            'sliderProducts', 
            'sliderSettings'
        ));
    }

    /**
     * API endpoint to get slider products (for AJAX requests)
     */
    public function getSliderProducts()
    {
        $sliderSettings = SliderSettings::getSettings();
        
        $products = Product::featured()
            ->take($sliderSettings->max_products)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 2),
                    'image' => $product->main_image,
                    'slug' => $product->slug,
                    'condition' => $product->condition,
                ];
            });

        return response()->json([
            'products' => $products,
            'settings' => [
                'slide_duration' => $sliderSettings->slide_duration,
                'is_active' => $sliderSettings->is_active,
            ]
        ]);
    }
}
