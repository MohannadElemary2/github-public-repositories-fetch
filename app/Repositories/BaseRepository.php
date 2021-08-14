<?php


namespace App\Repositories;

use App\Transformers\DropdownResource;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Container\Container as App;
use App\Exceptions\RepositoryException;
use App\Filters\Filter;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var Collection
     */
    protected $scopes;
    /**
     * @var Collection
     */
    protected $criteria;

    private $app;

    /**
     * @var array
     */
    protected $relations;

    /**
     * @var JsonResource | ResourceCollection
     */
    public $resource;

    /**
     * @var integer
     */
    protected $pagination;

    protected $resourceAdditional = [];

    /**
     * @param  App $app
     * @throws RepositoryException
     */

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->cleanRepository();
    }

    /**
     * Set resource used in wrapping data
     *
     * @param  $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Set relations needed to be eager loaded
     *
     * @param  $relations
     */
    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    /**
     * Set pagination count
     *
     * @param  $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * Get model scopes
     *
     * @param  $scopes
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set model scopes
     *
     * @param  $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * @param  $resourceAdditional
     */
    public function setResourceAdditional($resourceAdditional)
    {
        $this->resourceAdditional = $resourceAdditional;
    }

    public function index()
    {
        if (request('dropdown') && is_array($this->model->dropdownAttributes) && $this->model->dropdownAttributes) {
            $this->setResource(DropdownResource::class);
        }

        $resource = $this->resource ? $this->indexResource()->additional(
            array_merge([], !is_array($this->resourceAdditional) ? [] : $this->resourceAdditional)
        ) : $this->getModelData();
        $this->cleanRepository();
        return $resource;
    }

    public function indexResource()
    {
        return $this->resource::collection($this->getModelData());
    }

    public function wrapData($data)
    {
        return $this->resource ? new $this->resource($data) : $data;
    }

    public function filter($filter)
    {
        return $this->model->filter($filter);
    }

    public function getModelData(Filter $filter = null)
    {
        $model = $filter ? $this->filter($filter) : $this->model;

        $model = $this->applyScopes($model);

        if ($this->relations) {
            $model->with($this->relations);
        }

        return $this->pagination ? $model->paginate($this->pagination) : $model->get();
    }

    public function show($id)
    {
        $model = $this->model->query();

        $model = $this->applyScopes($model);

        if ($this->relations) {
            $model = $model->with($this->relations);
        }

        $model = $model->findOrFail($id);

        $resource = $this->wrapData($model);
        $this->cleanRepository();
        return $resource;
    }

    public function makeResource()
    {
        if ($this->resource) {
            if (
                !is_subclass_of($this->resource, 'Illuminate\Http\Resources\Json\ResourceCollection')
                && !is_subclass_of($this->resource, 'Illuminate\Http\Resources\Json\JsonResource')
            ) {
                throw new RepositoryException(
                    "Class {$this->resource} must be an instance of Illuminate\\Http\\Resources\\Json\\ResourceCollection or
            Illuminate\Http\Resources\Json\JsonResource"
                );
            }
        }

        return $this->resource;
    }

    public function create(array $data, $force = true, $resource = true)
    {
        $model = $force ? $this->model->forceCreate($data) : $this->model->create($data);
        $this->createOrUpdateOneToManyRelations($model, $data);
        $resource = $resource && $this->resource ? new $this->resource($model) : $model;
        $this->cleanRepository();
        return $resource;
    }

    protected function createOrUpdateOneToManyRelations($model, $data, $isUpdate = false)
    {
    }

    public function createOrUpdateRelations($relation, $requestKey, $data, $pivot = [])
    {
        if (isset($data[$requestKey])) {
            $relation->sync([]);
            $relationArray = [];
            foreach (request($requestKey) as $relationId) {
                $relationArray[$relationId] = $pivot ? $pivot[$relationId] : $pivot;
            }

            $relation->sync($relationArray);
        }
    }

    /**
     * @throws RepositoryException
     */
    protected function cleanRepository()
    {
        $this->scopes = [];
        $this->criteria = new Collection();
        $this->makeModel();
        $this->makeResource();
    }


    /**
     * @return Model
     *
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    protected function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @return mixed
     */
    abstract public function model();

    public function withTrashed()
    {
        $this->model = $this->model->withTrashed();
        return $this;
    }

    protected function applyScopes($model)
    {
        $scopes = $this->scopes;
        if ($scopes) {
            foreach ($scopes as $scope) {
                $model->{$scope}();
            }
        }
        return $model;
    }
}
