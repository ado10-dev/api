<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Team;
use App\Entities\HeadToHeadStat;
use App\Models\Game;
use TheCodingMachine\GraphQLite\Annotations\Query;

class StatsResolver
{
    /**
     * Display a listing of the resource.
     * 
     * @Query
     */
    public function headToHead(string $teamA, string $teamB): HeadToHeadStat
    {
        $idA = Hashids::decode($teamA);
        $idB = Hashids::decode($teamB);
        $headToHead = new HeadToHeadStat;
        $aHomeGames = Game::headTohead($idA, $idB)->count();
        $bHomeGames = Game::headTohead($idB, $idA)->count();

        // a home stats
        $aAwayGoals = Game::headTohead($idB, $idA)->sum('team_2_score');
        $headToHead->aHomeGoals = Game::headTohead($idA, $idB)->sum('team_1_score');
        $headToHead->aHomeWins = Game::headTohead($idA, $idB)->whereColumn('team_1_score', '>', 'team_2_score')->count();
        $aHomeDraws = Game::headTohead($idA, $idB)->whereColumn('team_1_score', 'team_2_score')->count();
        $aHomeCleanSheets = Game::headTohead($idA, $idB)->where('team_2_score', 0)->count();
        $aAwayCleanSheets = Game::headTohead($idB, $idA)->where('team_1_score', 0)->count();
        $headToHead->aCleanSheets = $aHomeCleanSheets + $aAwayCleanSheets;
        $bAwayWins = $aHomeGames - $aHomeDraws - $headToHead->aHomeWins;

        // b home stats
        $bAwayGoals = Game::headTohead($idA, $idB)->sum('team_2_score');
        $headToHead->bHomeGoals = Game::headTohead($idB, $idA)->sum('team_1_score');
        $headToHead->bHomeWins = Game::headTohead($idB, $idA)->whereColumn('team_1_score', '>', 'team_2_score')->count();
        $bHomeDraws = Game::headTohead($idB, $idA)->whereColumn('team_1_score', 'team_2_score')->count();
        $bHomeCleanSheets = Game::headTohead($idB, $idA)->where('team_2_score', 0)->count();
        $bAwayCleanSheets = Game::headTohead($idA, $idB)->where('team_1_score', 0)->count();
        $headToHead->bCleanSheets = $bHomeCleanSheets + $bAwayCleanSheets;
        $aAwayWins = $bHomeGames - $bHomeDraws - $headToHead->bHomeWins;

        // combined stats
        $headToHead->aGoals = $headToHead->aHomeGoals + $aAwayGoals;
        $headToHead->bGoals = $headToHead->bHomeGoals + $bAwayGoals;
        $headToHead->aWins = $headToHead->aHomeWins + $aAwayWins;
        $headToHead->bWins = $headToHead->bHomeWins + $bAwayWins;
        $headToHead->draws = $aHomeDraws + $bHomeDraws;
        $headToHead->played = Game::headTohead($idA, $idB)->count() + Game::headTohead($idB, $idA)->count();

        return $headToHead;
    }
}
