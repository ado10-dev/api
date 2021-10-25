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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Community $community)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        //
    }
}
