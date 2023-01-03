<?php
namespace App\Data\Repositories;

interface GameMatchRepositoryInterface extends BaseRepositoryInterface {
    function gameMatchDetailData(int $id, $col = ["*"]);
}
