<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@taqniyat.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0500000000',
            // Without this the demo account is stuck on the verify-email screen.
            'email_verified_at' => now(),
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '0500000001',
            'email_verified_at' => now(),
        ]);

        // Create Categories
        $categories = [
            [
                'name_ar' => 'أجهزة جديدة',
                'name_en' => 'New Devices',
                'slug' => 'new-devices',
                'description_ar' => 'أجهزة تقنية جديدة بضمان',
                'description_en' => 'New technology devices with warranty',
                'image' => '../images/new-devices.svg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'أجهزة مستعملة',
                'name_en' => 'Used Devices',
                'slug' => 'used-devices',
                'description_ar' => 'أجهزة تقنية مستعملة بحالة جيدة',
                'description_en' => 'Used technology devices in good condition',
                'image' => '../images/used-devices.svg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'إكسسوارات',
                'name_en' => 'Accessories',
                'slug' => 'accessories',
                'description_ar' => 'إكسسوارات متنوعة للأجهزة',
                'description_en' => 'Various accessories for devices',
                'image' => '../images/accessories.svg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'كاميرات',
                'name_en' => 'Cameras',
                'slug' => 'cameras',
                'description_ar' => 'كاميرات احترافية وذكية',
                'description_en' => 'Professional and smart cameras',
                'image' => '../images/cameras.svg',
                'is_active' => true,
            ],
            [
                'name_ar' => 'خدمات الصيانة',
                'name_en' => 'Maintenance Services',
                'slug' => 'maintenance-services',
                'description_ar' => 'خدمات صيانة وإصلاح الأجهزة',
                'description_en' => 'Device maintenance and repair services',
                'image' => '../images/maintenance-services.svg',
                'is_active' => true,
            ],
        ];

        // صور المنتجات حسب الفئة - الملفات موجودة في public/images/products
        $productImages = [
            'new-devices' => ['laptop-pro', 'smartphone-5g', 'tablet-air', 'workstation', 'smartwatch'],
            'used-devices' => ['used-laptop', 'used-smartphone', 'used-monitor', 'used-tablet', 'used-printer'],
            'accessories' => ['headphones', 'wireless-mouse', 'mech-keyboard', 'power-bank', 'usb-drive'],
            'cameras' => ['dslr-camera', 'action-camera', 'cctv-camera', 'webcam-4k', 'drone-camera'],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);

            // Create sample products for each category
            if ($category->slug !== 'maintenance-services') {
                for ($i = 1; $i <= 5; $i++) {
                    Product::create([
                        'category_id' => $category->id,
                        'name_ar' => "منتج {$i} - {$category->name_ar}",
                        'name_en' => "Product {$i} - {$category->name_en}",
                        'slug' => "product-{$i}-{$category->slug}-" . uniqid(),
                        'description_ar' => "وصف تفصيلي للمنتج {$i} في فئة {$category->name_ar}. منتج عالي الجودة مع مواصفات ممتازة.",
                        'description_en' => "Detailed description for product {$i} in {$category->name_en} category. High quality product with excellent specifications.",
                        'price' => rand(100, 5000),
                        'condition' => $category->slug === 'used-devices' ? 'used' : 'new',
                        'stock' => rand(5, 50),
                        'is_available' => true,
                        'images' => isset($productImages[$category->slug][$i - 1])
                            ? ['/images/products/' . $productImages[$category->slug][$i - 1] . '.svg']
                            : null,
                        'is_featured' => $i <= 2, // أول منتجين من كل فئة يظهران في السلايدر
                        'featured_order' => $i,
                    ]);
                }
            }
        }

        // تفعيل إعدادات السلايدر (إن كان الجدول يدعم ذلك)
        if (\Illuminate\Support\Facades\Schema::hasTable('slider_settings')) {
            \Illuminate\Support\Facades\DB::table('slider_settings')->updateOrInsert(
                ['id' => 1],
                [
                    'slide_duration' => 10000,
                    'max_products' => 5,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
