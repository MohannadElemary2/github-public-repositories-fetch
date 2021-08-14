<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ListRepositoriesRequest;
use App\Services\RepositoriesService;
use App\Transformers\RepositoriesSystemResource;

class RepositoriesController extends BaseController
{
    protected $resource = RepositoriesSystemResource::class;

    public function __construct(RepositoriesService $service)
    {
        parent::__construct($service);
    }

    public function getDirectly(ListRepositoriesRequest $request)
    {
        return $this->service->getDirectly($request->all());
    }

    public function index()
    {
        resolve(ListRepositoriesRequest::class);

        return $this->service->index();
    }
}
