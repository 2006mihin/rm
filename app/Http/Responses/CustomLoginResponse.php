<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // admin stays
        }

        return redirect()->route('home'); // clients redirected here
    }
}
