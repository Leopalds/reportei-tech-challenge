<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RepositoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //Pegando os repositórios do usuário logado
        $response = Http::withToken($user->github_token)->get('https://api.github.com/user/repos');
        $repos_json = $response->json();
        
        $repositories = collect();
        
        foreach( $repos_json as $repo_json ){
            $repo = Repository::make([
                'name' => $repo_json['name'],
                'owner' => $repo_json['owner']['login'],
                'github_id' => $repo_json['id'],
                'link' => $repo_json['html_url'],
            ]);
            
            $repositories->add($repo);
        }
        
        return view('repository.index', compact('repositories'));
    }

    public function show($owner, $repo_name)
    {
        //Getting the User Logged In
        $user = Auth::user();

        //Data from format ISO 8601 to get commits since 90 days ago
        $ninety_days_ago = Carbon::now()->subDays(90)->toIso8601String();

        //Getting the repo infos to save in DB
        $repo_json = Http::withToken($user->github_token)
                            ->get("https://api.github.com/repos/$owner/$repo_name")
                            ->json();

        //Saving the repo in DB
        $repo = Repository::updateOrCreate([
                                'github_id' => $repo_json['id'],
                            ],[
                                'name' => $repo_json['name'],
                                'owner' => $repo_json['owner']['login'],
                                'link' => $repo_json['html_url'],
                            ]);
        
        $commits_json = Http::withToken($user->github_token)
                        ->get("https://api.github.com/repos/$owner/$repo_name/commits", [
                            'since' => $ninety_days_ago,
                        ])->json();
        $commits = collect();

        foreach( $commits_json as $commit_json){
            $commit = Commit::updateOrCreate([
                'hash' => $commit_json['sha'],
            ],[
                'date' => Carbon::parse($commit_json['commit']['author']['date'],)
                    ->setTimezone('America/Sao_Paulo'),
                'repository_id' => $repo->id
            ]);

            $commits->add($commit);
        }
        
        return view('repository.show', compact('commits'));
    }

}
