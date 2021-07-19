<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user     = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect(RouteServiceProvider::HOME);
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)
            ->where('provider', $provider)
            ->where('email', $user->email)
            ->first();

        return $authUser ? $authUser : User::create([
            'name'        => $user->name,
            'email'       => $user->email,
            'provider'    => $provider,
            'provider_id' => $user->id,
        ]);
    }
}
