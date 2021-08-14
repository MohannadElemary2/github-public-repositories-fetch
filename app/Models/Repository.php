<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repository extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'full_name',
        'language',
        'owner_name',
        'owner_image',
        'stars',
        'created',
    ];
}
