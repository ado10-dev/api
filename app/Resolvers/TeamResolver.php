<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Team;
use TheCodingMachine\GraphQLite\Annotations\Query;
use Illuminate\Http\Request;

class TeamResolver
{
    /**
     * @Query
     * @return Team[]
     */
    public function teams(string $associationId): \Illuminate\Database\Eloquent\Collection
    {
        $decodedId = Hashids::decode($associationId);
        return Team::where('association_id', $decodedId)->get();
    }

    /**
     * @Query
     */
    public function team(string $id): ?Team
    {
        $decodedId = Hashids::decode($id);
        return Team::find($decodedId)->first();
    }

    /**
     * @Query
     */
    public function updateTeam(string $id): ?Team
    {
        $decodedId = Hashids::decode($id);
        $team = Team::find($decodedId)->first();
        if (!$team) return null;
    }
}
