<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //
    public function index(Request $request, $type = 'twitch')
    {

        return Socialite::driver($type)->redirect();
    }

    public function callback(Request $request, $type = 'twitch')
    {
        $user = Socialite::driver($type)->stateless()->user();
        $user = User::socialLogin($user, $type);
        return redirect('/login?token=' . $user->createToken($type)->accessToken);
    }
}
