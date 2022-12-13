<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();
        
        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ],[
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_avatar' => $githubUser->avatar,
            'github_nickname' => $githubUser->nickname,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);
        
        return redirect('/');
    }
}
