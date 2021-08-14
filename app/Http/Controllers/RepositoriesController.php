<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ListRepositoriesRequest;
use App\Transformers\RepositoriesResource;
use App\Services\RepositoriesService;

class RepositoriesController extends BaseController
{
    protected $listRequestFile = ListRepositoriesRequest::class;
    protected $resource = RepositoriesResource::class;

    public function __construct(RepositoriesService $service)
    {
        parent::__construct($service);
    }

    public function getDirectly(ListRepositoriesRequest $request)
    {
        return $this->service->getDirectly($request->all());
    }
}
