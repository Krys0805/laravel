<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountEmail;
use App\Models\User;
use App\Services\AccountService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{

    use ResetsPasswords;

    /**
     * @var AccountService
     */
    protected $_accountService;

    /**
     * Create a new controller instance.
     *
     * @param AccountService $accountService
     * @return void
     */
    public function __construct(AccountService $accountService)
    {
        $this->_accountService = $accountService;
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return JsonResponse|Renderable
     */
    public function edit(Request $request)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['email' => Auth::user()->email ?? null], 200);
        }

        return view(
            'user.account',
            [
                'email' => Auth::user()->email ?? null,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AccountEmail  $request
     * @return Response
     */
    public function update(AccountEmail $request)
    {
        /* @var User $user */
        $user = Auth::user();
        $this->_accountService->update($request, $user);
        return redirect()->route('account_edit')->withSuccess(__('Account email changed'));
    }

    public function reset(Request $request)
    {
        $this->resetPassword(Auth::user(), $request->password);
        return redirect()->route('account_edit')->withSuccess(__('Account password changed'));
    }
}
