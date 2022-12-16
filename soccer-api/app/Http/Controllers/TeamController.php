<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    
    
    /**
     * @OA\Get(
     *     path="/api/team",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function index()
    {
        $teams = Team::query()->simplePaginate(10);
        return response()->json($teams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/api/team",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function store(TeamRequest $request)
    {
        $data = $request->only(['name', 'short_name', 'city', 'stadium', 'coach', 'slug']);
        $team = Team::query()->create($data);
        return response()->json($data)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Team::query()->findOrFail($id);
        return response()->json($data);
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
        $data = $request->only('name', 'short_name', 'city', 'stadium', 'coach', 'slug');
        $team = Team::query()->findOrFail($id);
        $team->update($data);

        return response()->json($data);
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
        $team = Team::query()->findOrFail($id);
        $team->delete();
        $deleteResponse = [
            'success' => true,
            'message' => 'Deleted'
        ];
        return response()->json($deleteResponse);
    }
}
