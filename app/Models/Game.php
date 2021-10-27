<?php

namespace App\Models;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @Type()
 */
class Game extends Model
{
    use HasFactory;

    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }

    public function scopeHeadToHead($query, $idA, $idB)
    {
        return $query->where([
            ['team_1_id', $idA],
            ['team_2_id', $idB]
        ]);
    }

    public function scopeWithTeam($query, $id)
    {
        return $query->where('team_1_id', $id)->orWhere('team_2_id', $id);
    }

    /*
     |--------------------------------------------------------------------------
     | GraphQLite Fields
     |--------------------------------------------------------------------------
    */

    /**
     * @Field(outputType="ID")
     */
    public function getId(): string
    {
        return \Hashids::encode($this->id);
    }

    /**
     * @Field()
     */
    public function getTeamAid(): string
    {
        return \Hashids::encode($this->team_a_id);
    }

    /**
     * @Field()
     */
    public function getTeamBid(): string
    {
        return \Hashids::encode($this->team_b_id);
    }

    /**
     * @Field()
     */
    public function getScoreA(): int
    {
        return $this->team_a_score;
    }

    /**
     * @Field()
     */
    public function getScoreB(): int
    {
        return $this->team_b_score;
    }
}
