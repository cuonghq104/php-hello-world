<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerCreateRequest;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{

    private function getPlayerById($id) {
        $query = Player::query();
        $player = $query->findOrFail($id);
        return $player;
    }

    /**
     * Display a listing of the player.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/player",
     *     description=" ",
     *     tags={"Player"},
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function index(Request $request)
    {
        $query = Player::query()->searchByName($request);
        $query->select(['id', 'name', 'nationality', 'date_of_birth', 'position', 'detail_position', 'squad_number', 'id_team']);

        if ($team = $request->team_id) {
            $query->where('id_team', $team);
        }

        $per_page = $request->per_page ?: 50;
        $players = $query->simplePaginate($per_page);

        return $this->sendResponse($players);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/player",
     *     description=" ",
     *     tags={"Player"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="nationality",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="date_of_birth",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     type="string",
     *                     enum={"Forward", "Midfielder", "Defender", "Goalkeeper"}
     *                 ),
     *                 @OA\Property(
     *                     property="detail_position",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="squad_number",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="id_team",
     *                     type="number"
     *                 ),
     *         )
     *     ),
     *     @OA\Response(response="default", description="Welcome page", @OA\JsonContent())
     * )
     */
    public function store(PlayerCreateRequest $request)
    {
        if (is_array($request->all()) && count($request->all()) > 0 && is_array($request->all()[0])) {
            $results = [];
            foreach ($request->all() as $value) {
                $player = Player::query()->create($value);
                array_push($results, $player);
            }
            return $this->createSuccess($results);
        } else {
            $data = $request->only(['name', 'nationality', 'date_of_birth', 'position', 'detail_position', 'squad_number', 'id_team']);
            $player = Player::query()->create($data);
            return $this->createSuccess($player);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     tags={"Player"},
     *     path="/api/player/{id}",
     *     description=" ",
     *     @OA\Parameter(name="id", in="path", description="Id of player", required=true,
     *        @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function show($id)
    {
        $query = Player::query();
        $player = $query->findOrFail($id);
        return $this->sendResponse($player);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *     tags={"Player"},
     *     path="/api/player/{id}",
     *     description=" ",
     *     @OA\Parameter(name="id", in="path", description="Id of player", required=true,
     *        @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="nationality",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="date_of_birth",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="detail_position",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="squad_number",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="id_team",
     *                     type="number"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->only(['name', 'nationality', 'date_of_birth', 'position', 'detail_position', 'squad_number', 'id_team']);
        $player = $this->getPlayerById($id);
        $player->update($data);
        return $this->updateSuccess($player);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     tags={"Player"},
     *     path="/api/player/{id}",
     *     description=" ",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function destroy($id)
    {
        $player = $this->getPlayerById($id);
        $player->delete();
        return $this->deleteSuccess([]);
    }
}
