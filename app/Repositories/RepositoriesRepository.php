<?php

namespace App\Repositories;

use App\Filters\RepositoriesFilter;
use App\Models\Repository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

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

    /**
     * Insert Multiple Repositories Data To Database
     *
     * @param array $data
     * @return void
     * @author Mohannad Elemary
     */
    public function insert($data)
    {
        $insertedData = [];
        foreach ($data as $key => $item) {
            $insertedData = [
                'external_id' => $item['id'],
                'owner_name' => $item['owner']['login'],
                'owner_image' => $item['owner']['avatar_url'],
                'stars' => $item['stargazers_count'],
                'name' => $item['name'],
                'full_name' => $item['full_name'],
                'language' => $item['language'],
                'created' => Carbon::parse($item['created_at'])->format('Y-m-d'),
            ];

            $this->model->updateOrCreate(
                ['external_id' => $item['id']],
                $insertedData
            );
        }
    }
}
