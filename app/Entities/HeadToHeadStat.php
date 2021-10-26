<?php

namespace App\Entities;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
class HeadToHeadStat
{
    /**
     * @Field()
     */
    public function getPlayed(): int
    {
        return $this->played;
    }

    /**
     * @Field()
     */
    public function getDraws(): int
    {
        return $this->draws;
    }

    /**
     * @Field()
     */
    public function teamA(): HeadToHeadTeam
    {
        return $this->teamA;
    }

    /**
     * @Field()
     */
    public function teamB(): HeadToHeadTeam
    {
        return $this->teamB;
    }
}
