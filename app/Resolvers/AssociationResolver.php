<?php

namespace App\Resolvers;

use Hashids;
use App\Entities\AssociationInput;
use App\Models\Association;
use TheCodingMachine\GraphQLite\Annotations\UseInputType;
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
    public function createAssociation(AssociationInput $data): ?Association
    {
        $association = new Association;

        if ($data->name) $association->name = $data->name;
        if (!is_null($data->description)) $association->description = $data->description;

        $association->save();
        return $association;
    }

    /**
     * @Mutation
     * @UseInputType(for="$data", inputType="UpdateAssociationInput!")
     */
    public function updateAssociation(string $id, AssociationInput $data): ?Association
    {
        $decodedId = Hashids::decode($id);
        $association = Association::find($decodedId)->first();
        if (!$association) return null;

        if ($data->name) $association->name = $data->name;
        if (!is_null($data->description)) $association->description = $data->description;

        $association->save();
        return $association;
    }

    /**
     * @Mutation
     */
    public function deleteAssociation(string $id): bool
    {
        $decodedId = Hashids::decode($id);
        $association = Association::find($decodedId)->first();
        if (!$association) return false;

        $association->teams()->delete();
        $association->games()->delete();

        return $association->delete();
    }
}
