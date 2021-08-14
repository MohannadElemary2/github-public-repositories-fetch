<?php

namespace App\Repositories;

use App\Filters\RepositoriesFilter;
use App\Models\Repository;
use App\Repositories\BaseRepository;

class RepositoriesRepository extends BaseRepository
{
    public function model()
    {
        return Repository::class;
    }

    public function indexResource()
    {
        return $this->resource::collection($this->getModelData(app(RepositoriesFilter::class)));
    }
}
