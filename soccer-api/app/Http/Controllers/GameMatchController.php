<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use Illuminate\Http\Request;

class GameMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
    public function store(Request $request)
    {
        $data = $request->only(['id_home', 'id_away', 'start_time', 'stadium']);
        $data["status"] = "not_started";
        $game_match = GameMatch::query()->create($data);
        return $this->createSuccess($game_match);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function show($id)
    {
        $query = GameMatch::query();
        $match = $query->findOrFail($id)->load("home_team:id,name,city");
        return $this->sendResponse($match);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
