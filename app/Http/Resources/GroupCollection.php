<?php

namespace App\Http\Resources;

use App\Models\Group;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'list' => $this->collection->map(function (Group $group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'createdAt' => (string) $group->created_at,
                    'updatedAt' => (string) $group->updated_at,
                ];
            })
        ];
    }
}
