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
    public function games(string $associationId): \Illuminate\Database\Eloquent\Collection
    {
        $decodedId = Hashids::decode($associationId);
        return Game::where('association_id', $decodedId)->get();
    }

    /**
     * 
     *
     * @Query
     */
    public function game(string $id): ?Game
    {
        $decodedId = Hashids::decode($id);
        return Game::find($decodedId)->first();
    }
}
