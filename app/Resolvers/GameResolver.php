<?php

namespace App\Resolvers;

use Hashids;
use App\Entities\GameInput;
use App\Models\Association;
use App\Models\Game;
use TheCodingMachine\GraphQLite\Annotations\UseInputType;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Mutation;

class GameResolver
{
    /**
     * @Query
     * @return Game[]
     */
    public function games(string $associationId, ?int $limit): \Illuminate\Database\Eloquent\Collection
    {
        $decodedId = Hashids::decode($associationId);
        $games = Game::where('association_id', $decodedId);

        if ($limit) {
            $games = $games->limit($limit);
        }

        return $games->get();
    }

    /**
     * @Query
     */
    public function game(string $id): ?Game
    {
        $decodedId = Hashids::decode($id);
        return Game::find($decodedId)->first();
    }

    /**
     * @Mutation
     */
    public function createGame(string $associationId, GameInput $data): ?Game
    {
        $decodedId = Hashids::decode($associationId);
        $association = Association::find($decodedId)->first();
        if (!$association) return null;

        $game = new Game;
        $game->association_id = $association->id;
        $game->team_1_score = $data->homeScore;
        $game->team_2_score = $data->awayScore;
        // todo: check if teams exists
        $game->team_1_id = Hashids::decode($data->homeTeam)[0];
        $game->team_2_id = Hashids::decode($data->awayTeam)[0];

        if ($game->team_1_id == $game->team_2_id) {
            throw new \Exception("A team can't play against itself", 1);
        }

        $game->save();
        return $game;
    }

    /**
     * @Mutation
     * @UseInputType(for="$data", inputType="UpdateGameInput!")
     */
    public function updateGame(string $id, GameInput $data): ?Game
    {
        $decodedId = Hashids::decode($id);
        $game = Game::find($decodedId)->first();
        if (!$game) return null;

        if ($data->homeScore) $game->team_1_score = $data->homeScore;
        if ($data->awayScore) $game->team_2_score = $data->awayScore;
        // todo: check if teams exists
        if ($data->homeTeam) $game->team_1_id = Hashids::decode($data->homeTeam)[0];
        if ($data->awayTeam) $game->team_2_id = Hashids::decode($data->awayTeam)[0];

        if ($game->team_1_id == $game->team_2_id) {
            throw new \Exception("A team can't play against itself", 1);
        }

        $game->save();
        return $game;
    }

    /**
     * @Mutation
     */
    public function deleteGame(string $id): bool
    {
        $decodedId = Hashids::decode($id);
        $game = Game::find($decodedId)->first();
        if (!$game) return false;
        return $game->delete();
    }
}
