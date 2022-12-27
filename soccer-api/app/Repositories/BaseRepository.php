<?php

namespace App\Repositories;

use app\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function eloquentBuilder(): Builder
    {
        return $this->model->newQuery();
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->eloquentBuilder()->getQuery();
    }

    public function find(int $id, $col = ["*"])
    {
        return $this->eloquentBuilder()->find($id, $col);
    }

    public function findOrFail(int $id, $col = ["*"])
    {
        return $this->eloquentBuilder()->findOrFail($id, $col);
    }

    public function create(array|Collection $data)
    {
        if (is_array($data->all()) && count($data->all()) > 0 && is_array($data->all()[0])) {
            $results = [];
            foreach ($data->all() as $value) {
                $player = $this->eloquentBuilder()->create($data);;
                $results[] = $player;
            }
            return $results;
        } else {
            return $this->eloquentBuilder()->create($data);
        }
    }

    public function update($id, $data)
    {
        $item = $this->findOrfail($id);

        if ($item instanceof Model) {
            $item->update($data);

            return $item;
        }

        return $item->each(function ($item) use ($data) {
            $item->update($data);
            return $item;
        });
    }

    public function delete(int $id)
    {
        $item = $this->findOrfail($id);

        return $item->delete();
    }

}
