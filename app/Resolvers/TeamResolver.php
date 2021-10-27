<?php

namespace App\Resolvers;

use App\Entities\TeamInput;
use Hashids;
use App\Models\Team;
use TheCodingMachine\GraphQLite\Annotations\Query;

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
    public function createTeam(TeamInput $data): ?Team
    {
        $team = new Team;

        if ($data->name) $team->name = $data->name;
        if (!is_null($data->description)) $team->description = $data->description;

        $team->save();
        return $team;
    }
}
