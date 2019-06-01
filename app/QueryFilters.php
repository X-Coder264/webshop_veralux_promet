<?php

declare(strict_types=1);

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilters
{
    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create a new QueryFilters instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters to the builder.
     *
     * @return \Illuminate\Database\Eloquent\Collection | \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (! method_exists($this, $name)) {
                continue;
            }

            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        if (! isset($this->filters()['orderBy'])) {
            $this->orderBy();
        }

        if (isset($this->filters()['numberPerPage']) && is_numeric($this->filters()['numberPerPage']) &&
            '0' !== $this->filters()['numberPerPage']) {
            return $this->builder->paginate($this->filters()['numberPerPage']);
        } elseif (isset($this->filters()['numberPerPage']) && is_numeric($this->filters()['numberPerPage']) &&
            '0' === $this->filters()['numberPerPage']) {
            return $this->builder->get();
        }

        return $this->builder->paginate(12);
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }

    /**
     * Get all request filters data.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
