<?php

namespace App\Services;

interface BaseServiceInterface
{
    public function index();

    public function setResource($resource);

    public function setPagination($pagination = 20);

    public function setRelations($relations = []);

    public function setScopes($scopes = []);
}
