<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

abstract class BaseRepository
{
    /**
     * @param  Model
     */
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array $attributes
     * 
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $data
     * 
     * @return bool
     */
    public function update(array $data): bool
    {
        return $this->model->update($data);
    }

    /**
     * @param Model $object
     * @param array $data
     * 
     * @return bool
     */
    public function updateRow(Model $object, array $data): bool
    {
        return $object->update($data);
    }

    /**
     * @param array $columns
     * @param int $paginate
     * 
     * @return Collection|Paginator
     */
    public function all($columns = ['*'], int $paginate = 0): Collection|Paginator
    {
        return ($paginate === 0) ?
            $this->model->get($columns) : $this->model->paginate($paginate);
    }

    /**
     * @param int $id
     * 
     * @return Model
     */
    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $where
     * 
     * @return Model
     */
    public function find(array $where): Model|null
    {
        return $this->model->where($where)->first();
    }

    /**
     * @param array $where
     * @param array $with
     * @param string $orderBy
     * @param string $sort
     * 
     * @return Model
     */
    public function findWith(array $where = [], array $with = [], string $orderBy = 'id', string $sort = 'desc'): Model
    {
        return $this->model->with($with)->where($where)->orderBy($orderBy, $sort)->get();
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->model->delete();
    }

    /**
     * @param Model $model
     * 
     * @return bool
     */
    public function deleteRow(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * @param Model $model
     * 
     * @return Model
     */
    public function refreshRow(Model $model): Model
    {
        return $model->refresh();
    }

    /**
     * @param string $relationClass
     * @param array $relationsData
     * 
     * @return array
     */
    protected function hasManyRelationData(string $relationClass, array $relationsData): array
    {
        $data = [];
        foreach ($relationsData as $relationData) {
            $data[] = new $relationClass($relationData);
        }

        return $data;
    }
}
