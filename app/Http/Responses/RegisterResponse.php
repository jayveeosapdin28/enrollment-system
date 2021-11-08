<?php
namespace App\Http\Responses;
use App\Models\User;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
class RegisterResponse implements RegisterResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->assignRole('Student');
        return redirect()->intended('/student/profile');
    }
}
