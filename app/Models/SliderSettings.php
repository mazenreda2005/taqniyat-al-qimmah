<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for managing slider settings
 * Admin can configure slide duration, max products, etc.
 */
class SliderSettings extends Model
{
    protected $fillable = [
        'slide_duration',
        'max_products',
        'is_active',
    ];

    protected $casts = [
        'slide_duration' => 'integer',
        'max_products' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the current slider settings (singleton pattern)
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'slide_duration' => 10000,
            'max_products' => 5,
            'is_active' => true,
        ]);
    }
}
