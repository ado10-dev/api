<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Game;
use TheCodingMachine\GraphQLite\Annotations\Query;
use Illuminate\Http\Request;

class GameResolver
{
    /**
     * Display a listing of the resource.
     * 
     * @Query
     * @return Game[]
     */
    public function games(string $communityId): \Illuminate\Database\Eloquent\Collection
    {
        $decodedId = Hashids::decode($communityId);
        return Game::where('community_id', $decodedId)->get();
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
    public function game(string $id): ?Game
    {
        $decodedId = Hashids::decode($id);
        return Game::find($decodedId)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
