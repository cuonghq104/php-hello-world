<?php

namespace App\Http\Controllers;

use App\Data\Repositories\PlayerMatchRepositoryInterface;
use App\Data\Repositories\PlayerRepositoryInterface;
use App\Data\Repositories\TeamMatchRepositoryInterface;
use App\Models\GameMatch;
use App\Repositories\GameMatchRepository;
use App\Repositories\TeamMatchRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameMatchController extends Controller
{
    public function __construct(
        protected GameMatchRepository $gameMatchRepository,
        protected TeamMatchRepositoryInterface $teamMatchRepository,
        protected PlayerRepositoryInterface $playerRepository,
        protected PlayerMatchRepositoryInterface $playerMatchRepository
    )
    {
        // TODO:
    }

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *     path="/api/game_match",
     *     description=" ",
     *     tags={"Game Match"},
     *     @OA\Parameter(name="team_id", in="query", description="Id of team", required=false,
     *        @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        //
        $query = $this->gameMatchRepository
            ->eloquentBuilder()
            ->with([
                'home_team:id,name,city',
                'away_team:id,name,city',
            ])
            ->select('id', 'id_home', 'id_away', 'start_time', 'stadium');

        if ($team = $request->team_id) {
            $query->where('id_home', '=', $team)
                ->orWhere('id_away', '=', $team);
        }

        $query->orderBy('start_time', 'asc');
        return $this->sendResponse($query->simplePaginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *     tags={"Game Match"},
     *     path="/api/game_match",
     *     description="Game match",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id_home",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="id_away",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="start_time",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="stadium",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Game match create response")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['id_home', 'id_away', 'start_time', 'stadium']);
        $data["status"] = "not_started";
        $game_match = $this->gameMatchRepository->create($data);
        return $this->createSuccess($game_match);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     * @OA\Get(
     *     tags={"Game Match"},
     *     path="/api/game_match/{id}",
     *     description=" ",
     *     @OA\Parameter(name="id", in="path", description="Id of game match", required=true,
     *        @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $match = $this->gameMatchRepository->gameMatchDetailData($id, col: ["id", "id_home", "id_away", "start_time", "stadium", "status"]);
        return $this->sendResponse($match);
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
        $match = $this->gameMatchRepository->findOrFail($id);
        $data = $request->only(["id_home", "id_away", "start_time", "stadium", "status"]);
        $match->update($data);
        return $this->updateSuccess($match);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $match = $this->gameMatchRepository->findOrFail($id);
        $match->delete();
        return $this->deleteSuccess([]);
    }

    private function playerMatchArray($arr, $idTeam, $idTeamMatch, $isSub) {
        return array_map(function ($item) use ($idTeam, $idTeamMatch, $isSub) {
            $player = $this->playerRepository->eloquentBuilder()
                ->where('squad_number', $item["number"])
                ->where('id_team', $idTeam)
                ->first();
            if (!$player) dd($item);
            return [
                "id_player" => $player->id,
                "position" => $item["position"] ?? $player->detail_position,
                "is_sub" => $isSub,
                "id_team_match" => $idTeamMatch
            ];
        }, $arr);
    }
    public function insertLineUp(Request $request, int $id)
    {
        $match = $this->gameMatchRepository->findOrFail($id);
        $idHomeTeam = $this->teamMatchRepository->eloquentBuilder()->where('id_team', $match['id_home'])->where('id_match', $id)->first();
        $idAwayTeam = $this->teamMatchRepository->eloquentBuilder()->where('id_team', $match['id_away'])->where('id_match', $id)->first();

        $requestBody = json_decode($request->getContent(), true);
        $home = $requestBody["home"];
        $away = $requestBody["away"];

        $homeRequestStarting = $this->playerMatchArray($home["starting"], $idHomeTeam->id_team, $idHomeTeam->id, 0);
        $homeRequestSub = $this->playerMatchArray($home["substitution"], $idHomeTeam->id_team, $idHomeTeam->id, 1);
        $awayRequestStarting = $this->playerMatchArray($away["starting"], $idAwayTeam->id_team, $idAwayTeam->id, 0);
        $awayRequestSub = $this->playerMatchArray($away["substitution"], $idAwayTeam->id_team, $idAwayTeam->id, 1);
        return $this->createSuccess($this->playerMatchRepository->insertByTeam(array_merge($homeRequestStarting, $homeRequestSub, $awayRequestStarting, $awayRequestSub)));
    }
}
