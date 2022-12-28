<?php

namespace App\Data\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function eloquentBuilder(): Builder;
    public function queryBuilder(): QueryBuilder;
    public function findOrFail(int $id, $col = ["*"]): Builder|Collection|Model|null;
    public function find(int $id, $col = ["*"]): Builder|Collection|Model|null;
    public function create(array|Collection $data): Model|Builder|array;
    public function update(int $id, array $data);
    public function delete(int $id);
}
