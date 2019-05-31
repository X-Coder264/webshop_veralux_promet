<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Category extends Model
{
    use Sluggable, SluggableScopeHelpers;

    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'category_parent_id'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
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

    public function parentCategory()
    {
        return $this->hasOne(self::class, 'id', 'category_parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(self::class, 'category_parent_id');
    }

    public function allChildrenCategories()
    {
        return $this->childrenCategories()->with('allChildrenCategories', 'products');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'parent_subcategory');
    }
}
