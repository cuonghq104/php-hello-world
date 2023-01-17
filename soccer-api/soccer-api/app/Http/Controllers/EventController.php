<?php

namespace App\Http\Controllers;

use App\Data\Repositories\EventRepositoryInterface;
use App\Data\Repositories\PlayerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct(protected EventRepositoryInterface $eventRepository, protected PlayerRepositoryInterface $playerRepository)
    {
        // TODO:
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @OA\Get(
     *     tags={"Event"},
     *     path="/api/event/{id}",
     *     description=" ",
     *     @OA\Parameter(name="id", in="path", description="Id of game match", required=true,
     *        @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function index(Request $request, int $id): JsonResponse
    {
        //
        $query = $this->eventRepository
            ->eloquentBuilder()
            ->with([
                'player:id,name,nationality,squad_number,detail_position',
                'secondPlayer:id,name,nationality,squad_number,detail_position',
                'team:id,name,short_name'
            ])
            ->where('id_match', $id)
            ->orderBy('minute')
            ->select(['id', 'id_player', 'id_match', 'id_team', 'type', 'id_second_player', 'minute']);

        return $this->sendResponse($query->simplePaginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *     path="/api/event/{id}",
     *     description=" ",
     *     tags={"Event"},
     *     @OA\Parameter(name="id", in="path", description="Id of match", required=true,
     *        @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *                 @OA\Property(
     *                     property="id_player",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="player_squad_number",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="id_team",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="id_second_player",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     enum={"goal", "foul", "yellow-card", "second-yellow-card", "red-card", "subtitution", "free-kick", "corner", "penalty"}
     *                 ),
     *                 @OA\Property(
     *                     property="minute",
     *                     type="number"
     *                 ),
     *         )
     *     ),
     *     @OA\Response(response="default", description="Welcome page", @OA\JsonContent())
     * )
     */
    public function store(Request $request, int $id): JsonResponse
    {
        //
        $data = $request->only(['id_player', 'id_team', 'type', 'id_second_player', 'minute', 'player_squad_number', 'second_player_squad_number']);
        if (!isset($data['id_player']) && isset($data['player_squad_number'])) {
            $player = $this->playerRepository->eloquentBuilder()->where('squad_number', $data['player_squad_number'])->where('id_team', $data['id_team'])->first();
            $data["id_player"] = $player->id;
        }
        if (!isset($data['id_second_player']) && isset($data['second_player_squad_number'])) {
            $player = $this->playerRepository->eloquentBuilder()->where('squad_number', $data['second_player_squad_number'])->where('id_team', $data['id_team'])->first();
            $data["id_second_player"] = $player->id;
        }
        $data["id_match"] = $id;
        $result = $this->eventRepository->create($data);
        $result->load('player:id,name,nationality,squad_number,detail_position')
            ->load('secondPlayer:id,name,nationality,squad_number,detail_position')
            ->load('team:id,name,short_name');
        return $this->createSuccess($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        //
    }
}
