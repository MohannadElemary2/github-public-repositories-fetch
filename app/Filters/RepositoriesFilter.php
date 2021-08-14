<?php

namespace App\Filters;

use App\Filters\Filter;

class RepositoriesFilter extends Filter
{
    public function created($value = null)
    {
        return $this->builder->where('created', '>=', $value);
    }

    public function language($value = null)
    {
        return $this->builder->where('language', $value);
    }
}
