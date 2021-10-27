<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Association;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Mutation;

class AssociationResolver
{
    /**
     * @Query
     * @return Association[]
     */
    public function associations(): \Illuminate\Database\Eloquent\Collection
    {
        return Association::get();
    }

    /**
     * @Query
     */
    public function association(string $id): ?Association
    {
        $decodedId = Hashids::decode($id);
        return Association::find($decodedId)->first();
    }

    /**
     * @Mutation
     */
    public function updateAssociation(string $id, ?string $name = null, ?string $description = null): ?Association
    {
        $decodedId = Hashids::decode($id);
        $association = Association::find($decodedId)->first();
        if (!$association) return null;

        if ($name) $association->name = $name;
        if (!is_null($description)) $association->description = $description;

        $association->save();
        return $association;
    }
}
