<?php

namespace App\Entities;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
class HeadToHeadTeam
{
  /**
   * @Field()
   */
  public function getHomeGoals(): int
  {
    return $this->homeGoals;
  }

  /**
   * @Field()
   */
  public function getGoals(): int
  {
    return $this->goals;
  }

  /**
   * @Field()
   */
  public function getHomeWins(): int
  {
    return $this->homeWins;
  }

  /**
   * @Field()
   */
  public function getWins(): int
  {
    return $this->wins;
  }

  /**
   * @Field()
   */
  public function getCleanSheets(): int
  {
    return $this->cleanSheets;
  }
}
