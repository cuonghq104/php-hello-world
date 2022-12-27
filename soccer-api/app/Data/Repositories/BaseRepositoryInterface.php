<?php

namespace app\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function eloquentBuilder(): Builder;
    public function queryBuilder(): QueryBuilder;
    public function findOrFail(int $id, $col = ["*"]);
    public function find(int $id, $col = ["*"]);
    public function create(array|Collection $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
