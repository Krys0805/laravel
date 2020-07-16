<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;

class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return GroupCollection
     */
    public function index()
    {
        return new GroupCollection(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupRequest  $request
     * @return GroupResource
     */
    public function store(GroupRequest $request)
    {
        $group = new Group($request->all());
        $group->save();
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return GroupResource
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GroupRequest  $request
     * @param Group $group
     * @return GroupResource
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->all());
        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if ($group->delete()) {
            return response(null, 204);
        }
    }
}
