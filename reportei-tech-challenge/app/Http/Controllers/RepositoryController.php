<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RepositoryController extends Controller
{
    public function teste()
    {
        $user = Auth::user();

        //Pegando os repositórios do usuário logado
        $response = Http::withToken($user->github_token)->get('https://api.github.com/user/repos');
        
        dd($response->json());
    }
}
