<?php

namespace App\Services;

use App\Http\Requests\AccountEmail;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;

class AccountService
{

    /**
     * @param AccountEmail $request
     * @param User $user
     * @return bool
     */
    public function update(AccountEmail $request, User $user)
    {
        $response = true;
        if ($request->email != $user->getOriginal('email')) {
            $user->email = $request->email;
            $response = $user->save();
        }

        return $response;
    }
}
