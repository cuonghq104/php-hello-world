<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    
    /**
     * @OA\Get(
     *     tags={"Team"},
     *     path="/api/team",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function index(Request $request)
    {
        $query = Team::query();

        $per_page = $request->per_page ?: 50;

        if ($name = $request->name) {
            $query->where('name', 'like', $name . '%');
        }
        
        $teams = $query->simplePaginate($per_page);

        return $this->sendResponse($teams);

        // return response()->json($teams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     tags={"Team"},
     *     path="/api/team",
     *     description="Home page",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="short_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="stadium",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="coach",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function store(TeamRequest $request)
    {
        $data = $request->only(['name', 'short_name', 'city', 'stadium', 'coach', 'slug']);
        $team = Team::query()->create($data);

        return $this->createSuccess($team);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/team/{id}",
     *     tags={"Team"},
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function show($id)
    {
        //
        $data = Team::query()->findOrFail($id);
        return response()->json($data->matches());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *     path="/api/team/{id}",
     *     description="Home page",
     *     tags={"Team"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="short_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="stadium",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="coach",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->only('name', 'short_name', 'city', 'stadium', 'coach', 'slug');
        $team = Team::query()->findOrFail($id);
        $team->update($data);

        return $this->updateSuccess($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/api/team/{id}",
     *     description="Home page",
     *     tags={"Team"},
     *     @OA\Response(response="204", description="")
     * )
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
