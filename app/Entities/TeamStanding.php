<?php

namespace App\Entities;

use App\Models\Team;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
class TeamStanding
{
  /**
   * @Field()
   */
  public function getTeam(): Team
  {
    return $this->team;
  }

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
  public function getWins(): int
  {
    return $this->wins;
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
  public function getLosses(): int
  {
    return $this->losses;
  }

  /**
   * @Field()
   */
  public function getScored(): int
  {
    return $this->scored;
  }

  /**
   * @Field()
   */
  public function getAggregate(): int
  {
    return $this->aggregate;
  }

  /**
   * @Field()
   */
  public function getConceded(): int
  {
    return $this->conceded;
  }

  /**
   * @Field()
   */
  public function getCleanSheets(): int
  {
    return $this->cleanSheets;
  }

  /**
   * @Field()
   */
  public function getPoints(): int
  {
    return $this->points;
  }
}
