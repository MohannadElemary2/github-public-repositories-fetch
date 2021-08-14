<?php

namespace App\Http\Requests;

class ListRepositoriesRequest extends BaseRequest
{
    protected $validations = [
        'settings.array',
    ];

    protected $label  = 'repositories';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'per_page' => ['nullable', 'in:1,10,50,100'],
            'created'  => ['required', 'date', 'date_format:Y-m-d'],
            'language' => ['nullable'],
            'page' => ['nullable', 'numeric'],
        ];
    }
}
