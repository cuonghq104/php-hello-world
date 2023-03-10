<?php

namespace App\Http\Controllers;

use App\Repositories\PlayerMatchRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerMatchController extends Controller
{

    public function __construct(protected PlayerMatchRepository $playerMatchRepository)
    {
        // TODO:
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @OA\Post(
     *     tags={"Player Match"},
     *     path="/api/player-match/{id_team_match}",
     *     @OA\Parameter(name="id_team_match", in="path", description="Id of team match", required=true,
     *        @OA\Schema(type="integer")
     *     ),
     *     description="Player match",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id_player",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="is_sub",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Player match create response")
     * )
     */
    public function store(Request $request, int $id_team_match)
    {
        //
        $data = $request->only(['id_player', 'is_sub', 'position']);
        $data["id_team_match"] = $id_team_match;
        $playerMatch = $this->playerMatchRepository->create($data);
        return $this->createSuccess($playerMatch);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
