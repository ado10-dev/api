<?php

namespace App\Entities;

use TheCodingMachine\GraphQLite\Annotations\Input;
use TheCodingMachine\GraphQLite\Annotations\Field;

/**
 * @Input(name="CreateAssociationInput", default=true)
 * @Input(name="UpdateAssociationInput", update=true)
 */
class AssociationInput
{

  /**
   * @Field(for="CreateAssociationInput", inputType="String!")
   * @Field(for="UpdateAssociationInput", inputType="String")
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
