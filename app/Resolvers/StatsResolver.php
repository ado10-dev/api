<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Team;
use App\Entities\HeadToHeadStat;
use App\Entities\HeadToHeadTeam;
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
        // todo: validate teams exist
        $idA = Hashids::decode($teamA);
        $idB = Hashids::decode($teamB);
        $headToHead = new HeadToHeadStat;
        $teamA = new HeadToHeadTeam;
        $teamB = new HeadToHeadTeam;

        // teamA home stats
        $homeGoalsA = Game::headTohead($idA, $idB)->sum('team_1_score');
        $awayGoalsA = Game::headTohead($idB, $idA)->sum('team_2_score');
        $homeWinsA = Game::headTohead($idA, $idB)->whereColumn('team_1_score', '>', 'team_2_score')->count();
        $awayWinsA = Game::headTohead($idB, $idA)->whereColumn('team_1_score', '<', 'team_2_score')->count();
        $homeDrawsA = Game::headTohead($idA, $idB)->whereColumn('team_1_score', 'team_2_score')->count();
        $homeCleanSheetsA = Game::headTohead($idA, $idB)->where('team_2_score', 0)->count();
        $awayCleanSheetsA = Game::headTohead($idB, $idA)->where('team_1_score', 0)->count();
        $cleanSheetsA = $homeCleanSheetsA + $awayCleanSheetsA;

        // teamB home stats
        $homeGoalsB = Game::headTohead($idB, $idA)->sum('team_1_score');
        $awayGoalsB = Game::headTohead($idA, $idB)->sum('team_2_score');
        $homeWinsB = Game::headTohead($idB, $idA)->whereColumn('team_1_score', '>', 'team_2_score')->count();
        $awayWinsB = Game::headTohead($idA, $idB)->whereColumn('team_1_score', '<', 'team_2_score')->count();
        $homeDrawsB = Game::headTohead($idB, $idA)->whereColumn('team_1_score', 'team_2_score')->count();
        $homeCleanSheetsB = Game::headTohead($idB, $idA)->where('team_2_score', 0)->count();
        $awayCleanSheetsB = Game::headTohead($idA, $idB)->where('team_1_score', 0)->count();
        $cleanSheetsB = $homeCleanSheetsB + $awayCleanSheetsB;

        // COMBINED STATS
        $headToHead->played = Game::headTohead($idA, $idB)->count() + Game::headTohead($idB, $idA)->count();
        $headToHead->draws = $homeDrawsA + $homeDrawsB;

        // teamA data
        $teamA->homeWins = $homeWinsA;
        $teamA->wins = $homeWinsA + $awayWinsA;
        $teamA->homeGoals = $homeGoalsA;
        $teamA->goals = $homeGoalsA + $awayGoalsA;
        $teamA->cleanSheets = $cleanSheetsA;
        // teamB data
        $teamB->homeWins = $homeWinsB;
        $teamB->wins = $homeWinsB + $awayWinsB;
        $teamB->homeGoals = $homeGoalsB;
        $teamB->goals = $homeGoalsB + $awayGoalsB;
        $teamB->cleanSheets = $cleanSheetsB;

        // finish off
        $headToHead->teamA = $teamA;
        $headToHead->teamB = $teamB;

        return $headToHead;
    }
}
