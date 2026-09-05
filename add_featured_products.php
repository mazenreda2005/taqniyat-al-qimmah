<?php
/**
 * Script to add featured products to the slider
 * Run this after migrations: php add_featured_products.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

// Get first 5 available products and mark them as featured
$products = Product::where('is_available', true)->take(5)->get();

foreach ($products as $index => $product) {
    $product->update([
        'is_featured' => true,
        'featured_order' => $index,
    ]);
    echo "Added to slider: {$product->name_ar} (Order: {$index})\n";
}

echo "\n✅ Done! {$products->count()} products added to the homepage slider.\n";
echo "You can manage slider products from: /admin/slider\n";
