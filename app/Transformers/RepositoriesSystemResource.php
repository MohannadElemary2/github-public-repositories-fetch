<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RepositoriesSystemResource extends JsonResource
{
    public function toArray($request)
    {
        return  [
            'id' => $this->external_id,
            'name' => $this->name,
            'full_name' => $this->full_name,
            'language' => $this->language,
            'owner_name' => $this->owner_name,
            'owner_image' => $this->owner_image,
            'stars' => $this->stars,
            'created' => $this->created,
        ];
    }
}
