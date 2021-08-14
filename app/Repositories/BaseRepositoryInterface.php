<?php


namespace App\Repositories;


interface BaseRepositoryInterface
{
    public function index();

    public function show($id);

    public function create(array $data, $force = true, $resource = true);

    public function setRelations($relations);

    public function setPagination($pagination);

    public function setResource($resource);

    public function setScopes($scopes);
}
