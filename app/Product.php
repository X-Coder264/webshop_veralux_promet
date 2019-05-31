<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Product extends Model
{
    use Filterable, Sluggable, SluggableScopeHelpers, SoftDeletes;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['manufacturer.name', 'name'],
            ],
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_subcategory', 'name', 'manufacturer_id', 'catalogNumber', 'price', 'discount_price', 'description', 'unit', 'highlighted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function getPriceAttribute($price): ?string
    {
        if (null === $price) {
            return null;
        }

        return number_format($price / 100, 2) . ' HRK';
    }

    public function getDiscountPriceAttribute($price): ?string
    {
        if (null === $price) {
            return null;
        }

        return number_format($price / 100, 2) . ' HRK';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_parent_id');
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->orderBy('id', 'asc');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id');
    }
}
