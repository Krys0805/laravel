<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    /**
     * @var ProfileService
     */
    protected $_profileService;

    /**
     * Create a new controller instance.
     *
     * @param ProfileService $profileService
     * @return void
     */
    public function __construct(ProfileService $profileService)
    {
        $this->_profileService = $profileService;
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response|Renderable
     */
    public function edit()
    {
        return view(
            'user.profile',
            [
                'first_name' => Auth::user()->profile->first_name ?? null,
                'last_name' => Auth::user()->profile->last_name ?? null,
                'dob' => Auth::user()->profile->dob ?? null,
                'city' => Auth::user()->profile->city ?? null,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Profile  $request
     * @return Response
     */
    public function update(Profile $request)
    {
        /* @var User $user */
        $user = Auth::user();
        $this->_profileService->update($request, $user);
        return redirect()->route('profile_edit')->withSuccess(__('Profile updated'));
    }
}
