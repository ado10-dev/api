<?php

namespace App\Resolvers;

use Hashids;
use App\Entities\TeamStanding;
use App\Entities\HeadToHeadStat;
use App\Entities\HeadToHeadTeam;
use App\Models\Association;
use App\Models\Game;
use TheCodingMachine\GraphQLite\Annotations\Query;

class StatsResolver
{
    /**
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

    /**
     * @Query
     * @return TeamStanding[]
     */
    public function allTimeStandings(string $associationId)
    {
        $decodedId = Hashids::decode($associationId);
        $association = Association::find($decodedId)->first();
        if (!$association) {
            throw new \Exception("Association not found", 1);
        }

        $standings = [];
        $teams = $association->teams;
        foreach ($teams as $team) {
            $standings[] = $this->teamStandings($team);
        }

        return $standings;
    }

    /**
     * Get a team's standings
     * 
     * @param App\Models\Team
     * @return App\Entities\TeamStanding
     */
    public function teamStandings($team)
    {
        $games = new Game;
        $standings = new TeamStanding;
        $standings->team = $team;
        $standings->played = $games->where('team_1_id', $team->id)
            ->orWhere('team_2_id', $team->id)
            ->count();
        $standings->wins = $games->where('team_1_id', $team->id)
            ->whereColumn('team_1_score', '>', 'team_2_score')
            ->orWhere('team_2_id', $team->id)
            ->whereColumn('team_2_score', '>', 'team_1_score')
            ->count();
        $standings->draws = $games->where('team_1_id', $team->id)
            ->whereColumn('team_1_score', 'team_2_score')
            ->orWhere('team_2_id', $team->id)
            ->whereColumn('team_2_score', 'team_1_score')
            ->count();
        $standings->losses = $standings->played - $standings->wins - $standings->draws;
        $homeGoals = $games->where('team_1_id', $team->id)->sum('team_1_score');
        $awayGoals = $games->where('team_2_id', $team->id)->sum('team_2_score');
        $standings->scored = $homeGoals + $awayGoals;
        $homeConceded = $games->where('team_1_id', $team->id)->sum('team_2_score');
        $awayConceded = $games->where('team_2_id', $team->id)->sum('team_1_score');
        $standings->conceded = $homeConceded + $awayConceded;
        $standings->aggregate = $standings->scored - $standings->conceded;
        $homeCleanSheets = $games->where('team_1_id', $team->id)->where('team_2_score', 0)->count();
        $awayCleanSheets = $games->where('team_2_id', $team->id)->where('team_1_score', 0)->count();
        $standings->cleanSheets = $homeCleanSheets + $awayCleanSheets;
        $standings->points = ($standings->wins * 3) + $standings->draws;

        return $standings;
    }
}
