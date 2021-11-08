<?php
namespace App\Http\Responses;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $home = auth()->user()->hasRole(['Student']) ? '/student/profile' : '/dashboard';
        return redirect()->intended($home);

        //return Inertia::render('Student/Profile/Create');
    }
}
