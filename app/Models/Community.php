<?php

namespace App\Models;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @Type()
 */
class Community extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'description'
    ];

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @Field()
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
