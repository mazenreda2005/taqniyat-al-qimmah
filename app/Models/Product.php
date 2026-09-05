<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name_ar',
        'name_en',
        'slug',
        'description_ar',
        'description_en',
        'price',
        'condition',
        'stock',
        'is_available',
        'is_featured',
        'featured_order',
        'images',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'featured_order' => 'integer',
        'images' => 'array',
    ];

    /**
     * Scope to get featured products for slider
     * Orders by featured_order (ascending)
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('is_available', true)
                     ->orderBy('featured_order', 'asc');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name_en);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * اسم المنتج حسب اللغة: عربي، إنجليزي، أو أردو (مع استخدام العربي كبديل للأردو إن لم يوجد حقل أردي).
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

    /**
     * وصف المنتج حسب اللغة.
     */
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

    public function getMainImageAttribute()
    {
        $images = $this->images ?? [];
        if (!empty($images) && !empty($images[0])) {
            $first = $images[0];
            if (str_starts_with($first, 'http://') || str_starts_with($first, 'https://') || str_starts_with($first, '/')) {
                return $first;
            }
            return asset('storage/' . $first);
        }
        return asset('images/default-product.svg');
    }
}
