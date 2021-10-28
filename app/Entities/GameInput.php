<?php

namespace App\Entities;

use TheCodingMachine\GraphQLite\Annotations\Input;
use TheCodingMachine\GraphQLite\Annotations\Field;

/**
 * @Input(name="CreateGameInput", default=true)
 * @Input(name="UpdateGameInput", update=true)
 */
class GameInput
{
  /**
   * @Field()
   * @var string
   */
  public $homeTeam;

  /**
   * @Field()
   * @var string
   */
  public $awayTeam;

  /**
   * @Field()
   * @var int
   */
  public $homeScore;

  /**
   * @Field()
   * @var int
   */
  public $awayScore;

  public function getHomeTeam()
  {
    return $this->homeTeam;
  }

  public function getAwayTeam()
  {
    return $this->awayTeam;
  }

  public function getHomeScore()
  {
    return $this->homeScore;
  }

  public function getAwayScore()
  {
    return $this->awayScore;
  }
}
