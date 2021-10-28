<?php

namespace App\Entities;

use TheCodingMachine\GraphQLite\Annotations\Input;
use TheCodingMachine\GraphQLite\Annotations\Field;

/**
 * @Input(name="CreateTeamInput", default=true)
 * @Input(name="UpdateTeamInput", update=true)
 */
class TeamInput
{

  /**
   * @Field(for="CreateTeamInput", inputType="String!")
   * @Field(for="UpdateTeamInput", inputType="String")
   * @var string
   */
  public $name;

  /**
   * @Field(inputType="String")
   * @var string
   */
  public $user_id;

  public function __construct(string $name = null, string $user_id = null)
  {
    $this->name = $name;
    $this->user_id = $user_id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getUser_id(): string
  {
    return $this->user_id;
  }
}
