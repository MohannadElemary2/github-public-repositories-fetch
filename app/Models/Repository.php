<?php

namespace App\Models;

class Repository extends BaseModel
{
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
