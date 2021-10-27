<?php

namespace App\Resolvers;

use Hashids;
use App\Entities\TeamInput;
use App\Models\Association;
use App\Models\Team;
use TheCodingMachine\GraphQLite\Annotations\UseInputType;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Mutation;

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
     * @Mutation
     */
    public function createTeam(string $associationId, TeamInput $data): ?Team
    {
        $decodedId = Hashids::decode($associationId);
        $association = Association::find($decodedId)->first();
        if (!$association) return null;

        $team = new Team;
        $team->association_id = $association->id;
        if ($data->name) $team->name = $data->name;
        if (!is_null($data->user_id)) $team->user_id = Hashids::decode($data->user_id)[0];

        $team->save();
        return $team;
    }

    /**
     * @Mutation
     * @UseInputType(for="$data", inputType="UpdateTeamInput!")
     */
    public function updateTeam(string $id, TeamInput $data): ?Team
    {
        $decodedId = Hashids::decode($id);
        $team = Team::find($decodedId)->first();
        if (!$team) return null;

        if ($data->name) $team->name = $data->name;
        if (!is_null($data->user_id)) {
            $team->user_id = ($data->user_id == "") ? null : Hashids::decode($data->user_id)[0];
        }

        $team->save();
        return $team;
    }
}
