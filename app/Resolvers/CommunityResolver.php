<?php

namespace App\Resolvers;

use Hashids;
use App\Models\Community;
use TheCodingMachine\GraphQLite\Annotations\Query;
use Illuminate\Http\Request;

class CommunityResolver
{
    /**
     * Display a listing of the resource.
     * 
     * @Query
     * @return Community[]
     */
    public function communities(): \Illuminate\Database\Eloquent\Collection
    {
        return Community::get();
    }

    /**
     * Display the specified resource.
     *
     * @Query
     */
    public function community(string $id): ?Community
    {
        $decodedId = Hashids::decode($id);
        return Community::find($decodedId)->first();
    }
}
