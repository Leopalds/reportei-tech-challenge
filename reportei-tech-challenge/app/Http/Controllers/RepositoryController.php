<?php

namespace App\Http\Controllers;

use App\Charts\CommitChart;
use App\Models\Commit;
use App\Models\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RepositoryController extends Controller
{
    public function index(Request $request)
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
        
        if( isset($request) && request('q') != null ){
            $repositories = $repositories->filter(function ($repo) use ($request) {
                return stripos($repo->full_name, $request->q) !== FALSE;
            });
        }

        $repositories = $repositories->paginate(5);

        return view('repository.index', compact('repositories'));
    }

    public function show($owner, $repo_name, Request $request)
    {
        //Getting the User Logged In
        $user = Auth::user();
        
        //Getting the repo infos to save in DB
        $response = Http::withToken($user->github_token)
                            ->get("https://api.github.com/repos/$owner/$repo_name");

        if($response->failed()){
            return view('repository.show');
        }

        $repo_json = $response->json();

        //Saving the repo in DB
        $repo = Repository::updateOrCreate([
                                'github_id' => $repo_json['id'],
                            ],[
                                'name' => $repo_json['name'],
                                'owner' => $repo_json['owner']['login'],
                                'link' => $repo_json['html_url'],
                            ]);
        //Storing all the commits in DB
        $repo->storeCommits();
        
        //Creating the Commit's Chart of 90 days ago
        $chart = $repo->createCommitChart($request->how_many_days);

        return view('repository.show', compact('chart', 'repo'));
    }

}
