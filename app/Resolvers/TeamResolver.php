<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Team;
use TheCodingMachine\GraphQLite\Annotations\Query;
use Illuminate\Http\Request;

class TeamResolver
{
    /**
     * Display a listing of the resource.
     * 
     * @Query
     * @return Team[]
     */
    public function teams(string $communityId): \Illuminate\Database\Eloquent\Collection
    {
        $decodedId = Hashids::decode($communityId);
        return Team::where('community_id', $decodedId)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @Query
     */
    public function team(string $id): ?Team
    {
        $decodedId = Hashids::decode($id);
        return Team::find($decodedId)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
