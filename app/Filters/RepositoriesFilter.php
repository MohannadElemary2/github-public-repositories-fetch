<?php

namespace App\Filters;

use App\Filters\Filter;

class RepositoriesFilter extends Filter
{
    /**
     * Filter Repositories Data by Creation Date
     *
     * @param string $value
     * @return Builder
     * @author Mohannad Elemary
     */
    public function created($value = null)
    {
        return $this->builder->where('created', '>=', $value);
    }

    /**
     * Filter Repositories Data by Programming Language
     *
     * @param string $value
     * @return Builder
     * @author Mohannad Elemary
     */
    public function language($value = null)
    {
        return $this->builder->where('language', $value);
    }
}
