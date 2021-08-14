<?php

namespace App\Filters;

use App\Filters\Filter;

class RepositoriesFilter extends Filter
{
    public function group($value = null)
    {
        return $this->builder->where('group', '=', $value);
    }
}
