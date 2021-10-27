<?php

namespace App\Models;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;
use TheCodingMachine\GraphQLite\Annotations\MagicField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @Type()
 * @MagicField(name="homeTeam", phpType="Team")
 * @MagicField(name="awayTeam", phpType="Team")
 */
class Game extends Model
{
    use HasFactory;

    /**
     * Get game team 
     */
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'team_2_id');
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
    public function getHomeScore(): int
    {
        return $this->team_1_score;
    }

    /**
     * @Field()
     */
    public function getAwayScore(): int
    {
        return $this->team_2_score;
    }
}
