<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use Filterable, SoftDeletes;

    protected static function boot()
    {
        parent::boot();
    }
}
