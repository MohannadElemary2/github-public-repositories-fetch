<?php

namespace App\Http\Controllers;

use App\Services\BaseServiceInterface;

class BaseController extends Controller
{
    protected $service;
    protected $relations = [];
    protected $resource;
    protected $pagination;
    protected $scopes = [];

    public function __construct(BaseServiceInterface $service)
    {
        $this->service = $service;
        $this->constructRepository();
    }

    public function index()
    {
        return $this->service->index();
    }

    private function constructRepository()
    {
        $this->service->setRelations($this->relations);
        $this->service->setResource($this->resource);
        $this->service->setPagination(request('per_page') ?? ($this->pagination ?? 20));
        $this->service->setScopes($this->scopes);
    }
}
