<?php

namespace App\Http\Controllers\Auth\GitHub;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();    // Get user data from GitHub
        $user = User::updateOrCreate(
            ['nickname' => $githubUser->getNickname(), 'email' => $githubUser->getEmail()],
            ['name' => $githubUser->getName(), 'password' => rand(40, 40), 'email_verified_at' => now()]
        );

        Auth::login($user, true);

        return redirect('/dashboard');
    }
}
