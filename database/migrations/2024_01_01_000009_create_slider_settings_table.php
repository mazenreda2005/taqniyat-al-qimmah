<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration for slider settings
 * Allows admin to configure slider behavior
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slider_settings', function (Blueprint $table) {
            $table->id();
            // Duration each slide is shown (in milliseconds)
            $table->integer('slide_duration')->default(10000);
            // Maximum number of products to show in slider
            $table->integer('max_products')->default(5);
            // Enable/disable slider
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('slider_settings')->insert([
            'slide_duration' => 10000,
            'max_products' => 5,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_settings');
    }
};
