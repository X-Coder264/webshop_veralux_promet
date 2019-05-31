<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Builder;

class ProductFilters extends QueryFilters
{
    /**
     * Filter by product category.
     *
     * @param int $category
     *
     * @return Builder
     */
    public function category($category = 0)
    {
        return $this->builder->where('parent_subcategory', $category);
    }

    /**
     * Search by product name.
     *
     * @param string $name
     *
     * @return Builder
     */
    public function search($name = '')
    {
        return $this->builder->where('name', 'LIKE', '%' . $name . '%');
    }

    /**
     * Order by product creation or price.
     *
     * @param int $order
     *
     * @return Builder
     */
    public function orderBy($order = 0)
    {
        if (0 === $order) {
            return $this->builder->orderBy('created_at', 'desc');
        } elseif (1 === $order) {
            return $this->builder->orderBy('created_at', 'asc');
        } elseif (2 === $order) {
            return $this->builder->orderBy('price', 'desc');
        } else {
            return $this->builder->orderBy('price', 'asc');
        }
    }

    /**
     * Filter by starting price.
     *
     * @param float $price
     *
     * @return Builder
     */
    public function startPrice($price = 0.0)
    {
        return $this->builder->where('price', '>=', $price);
    }

    /**
     * Filter by ending price.
     *
     * @param float $price
     *
     * @return Builder
     */
    public function endPrice($price = 100000.0)
    {
        return $this->builder->where('price', '<=', $price);
    }

    /**
     * Filter by discount.
     *
     * @param string $discount
     *
     * @return Builder
     */
    public function discount($discount = 'off')
    {
        if ('on' === $discount) {
            return $this->builder->where('discount', '=', true);
        } else {
            return $this->builder->where('discount', '=', false);
        }
    }
}
