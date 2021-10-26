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
    public function getAHomeGoals(): int
    {
        return $this->aHomeGoals;
    }
    /**
     * @Field()
     */
    public function getBHomeGoals(): int
    {
        return $this->bHomeGoals;
    }

    /**
     * @Field()
     */
    public function getAGoals(): int
    {
        return $this->aGoals;
    }

    /**
     * @Field()
     */
    public function getBGoals(): int
    {
        return $this->bGoals;
    }

    /**
     * @Field()
     */
    public function getAHomeWins(): int
    {
        return $this->aHomeWins;
    }

    /**
     * @Field()
     */
    public function getBHomeWins(): int
    {
        return $this->bHomeWins;
    }

    /**
     * @Field()
     */
    public function getAWins(): int
    {
        return $this->aWins;
    }

    /**
     * @Field()
     */
    public function getBWins(): int
    {
        return $this->bWins;
    }

    /**
     * @Field()
     */
    public function getACleanSheets(): int
    {
        return $this->aCleanSheets;
    }

    /**
     * @Field()
     */
    public function getBCleanSheets(): int
    {
        return $this->bCleanSheets;
    }
}
