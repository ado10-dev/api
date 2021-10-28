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
     * Display the specified resource.
     *
     * @Query
     */
    public function team(string $id): ?Team
    {
        $decodedId = Hashids::decode($id);
        return Team::find($decodedId)->first();
    }
}
