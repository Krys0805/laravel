<?php

namespace App\Services;

use App\Http\Requests\Profile;
use App\Models\User;

class ProfileService
{

    /**
     * @param Profile $request
     * @param User $user
     * @return bool
     */
    public function update(Profile $request, User $user)
    {
        $profile = $user->profile;
        if (!$profile instanceof User\Profile) {
            $profile = new User\Profile();
            $profile->user_id = $user->id;
        }
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->dob = $request->dob;
        $profile->city = $request->city;

        return $profile->save();
    }
}
