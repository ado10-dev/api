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
  public $description;

  public function __construct(string $name = null, string $description = null)
  {
    $this->name = $name;
    $this->description = $description;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getDescription(): string
  {
    return $this->description;
  }
}
