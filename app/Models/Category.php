<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'description_ar',
        'description_en',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name_en);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * اسم الفئة حسب اللغة: عربي، إنجليزي، أو أردو (الأردو يستخدم العربي كبديل).
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar') {
            return $this->name_ar;
        }
        if ($locale === 'ur') {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar') {
            return $this->description_ar;
        }
        if ($locale === 'ur') {
            return $this->description_ar ?: $this->description_en;
        }
        return $this->description_en;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-product.svg');
        }
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/')) {
            return $this->image;
        }
        if (str_starts_with($this->image, '../images/')) {
            return asset(str_replace('../images/', 'images/', $this->image));
        }
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        return asset('storage/' . $this->image);
    }
}
