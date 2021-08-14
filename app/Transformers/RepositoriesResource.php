<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RepositoriesResource extends JsonResource
{
    public function toArray($request)
    {
        $data = $this->resource;

        return  [
            'id' => $data['id'],
            'name' => $data['name'],
            'full_name' => $data['full_name'],
            'owner_name' => $data['owner']['login'],
            'owner_image' => $data['owner']['avatar_url'],
            'starts' => $data['stargazers_count'],
        ];
    }
}
