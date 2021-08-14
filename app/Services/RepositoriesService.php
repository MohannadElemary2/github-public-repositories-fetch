<?php

namespace App\Services;

use App\Repositories\RepositoriesRepository;
use App\Services\BaseService;
use App\Transformers\RepositoriesResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class RepositoriesService extends BaseService
{
    public function __construct(RepositoriesRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getDirectly($data)
    {
        $url = $this->buildAPIUrl($data);

        $response = Http::get($url)->json()['items'];

        return RepositoriesResource::collection($response);
    }

    public function sync($data)
    {
        $url = config('app.github_url');

        $url = $this->addParamToUrl($url, 'pushed', $data, '', true, true);

        $url = $this->addParamToUrl($url, 'per_page', $data);
        $url = $this->addParamToUrl($url, 'page', $data);

        $response = Http::get($url);

        if ($response->status() == Response::HTTP_UNPROCESSABLE_ENTITY) {
            return false;
        }

        $this->repository->insert($response->json()['items'] ?? []);

        return true;
    }

    public function buildAPIUrl($data)
    {
        $url = config('app.github_url');
        $data['sort'] = 'stars';
        $data['order'] = 'desc';

        $url = $this->addParamToUrl($url, 'created', $data, '>', true, true);

        $url = $this->addParamToUrl($url, 'language', $data, '', true);

        $url = $this->addParamToUrl($url, 'per_page', $data);
        $url = $this->addParamToUrl($url, 'page', $data);

        $url = $this->addParamToUrl($url, 'sort', $data);
        $url = $this->addParamToUrl($url, 'order', $data);

        return $url;
    }

    private function addParamToUrl(
        $url,
        $parameterName,
        $parameters,
        $operator = '',
        $inQuery = false,
        $isFirstParam = false
    ) {
        if (!isset($parameters[$parameterName])) {
            return $url;
        }

        if ($inQuery) {
            $isFirstParam = $isFirstParam ? '' : '+';
            $url .= "{$isFirstParam}{$parameterName}:{$operator}{$parameters[$parameterName]}";
        } else {
            $url .= "&$parameterName={$parameters[$parameterName]}";
        }

        return $url;
    }
}