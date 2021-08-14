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

    /**
     * Get Repositories Directly By Calling Github API
     *
     * @param array $data
     * @return JsonResource
     * @author Mohannad Elemary
     */
    public function getDirectly($data)
    {
        $url = $this->buildAPIUrl($data);

        $response = Http::get($url)->json()['items'];

        return RepositoriesResource::collection($response);
    }

    /**
     * Sync Repositories Data From Github API
     *
     * @param array $data
     * @return bool
     * @author Mohannad Elemary
     */
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

    /**
     * Build API Endpoint To Be Requested With The Right Parameters
     *
     * @param array $data
     * @return string
     * @author Mohannad Elemary
     */
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

    /**
     * Add Parameter To URL To Be Built
     *
     * @param string $url
     * @param string $parameterName
     * @param array $parameters
     * @param string $operator
     * @param boolean $inQuery
     * @param boolean $isFirstParam
     * @return string
     * @author Mohannad Elemary
     */
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
