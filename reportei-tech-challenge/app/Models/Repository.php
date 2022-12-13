<?php

namespace App\Models;

use App\Charts\CommitChart;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'github_id',
        'link'
    ];

    /**
     * Get the commits from the repository.
     */
    public function commits()
    {
        return $this->hasMany(Commit::class);
    }

    /**
     * Get full_name Attribute
     */
    public function getFullNameAttribute()
    {
        return $this->owner . "/" . $this->name;
    }

    /**
     * Save all the commits from the last 90 days in DataBase
     * 
     */
    public function storeCommits()
    {
        //Getting the User Logged In
        $user = Auth::user();
        
        //Data from format ISO 8601 to get commits since 90 days ago
        $ninety_days_ago = Carbon::now()->subDays(90)->toIso8601String();

        $commits_json = Http::withToken($user->github_token)
                        ->get("https://api.github.com/repos/$this->owner/$this->name/commits", [
                            'since' => $ninety_days_ago,
                        ])->json();

        foreach( $commits_json as $commit_json){
            
            Commit::updateOrCreate([
                'hash' => $commit_json['sha'],
            ],[
                'date' => Carbon::parse($commit_json['commit']['author']['date'],)
                    ->setTimezone('America/Sao_Paulo')->format('Y-m-d'),
                'repository_id' => $this->id
            ]);
        }
    }

    /**
     * create and return a Commit Chart
     * 
     * @param  Integer  $how_many_days_ago Number os days the chart will plot
     * 
     * @return App\Charts\CommitChart
     */
    public function createCommitChart($how_many_days_ago){
        //By default if the days isn't an Integer, I use 90 days ago
        if( !is_numeric($how_many_days_ago) ){
            $how_many_days_ago = 90;
        }

        $number_of_commits_per_day = collect([]);
        $days = collect([]);

        for ($days_backwards = $how_many_days_ago; $days_backwards >= 0; $days_backwards--) {
            $date = today()->subDays($days_backwards);
            $number_of_commits_per_day->push(
                    Commit::where("repository_id", $this->id)
                    ->whereDate('date', $date)->count()
            );
            $days->push($date->day . "/" . $date->month);
        }
        
        $chart = new CommitChart;
        
        $chart->labels($days);
        $dataset = $chart->dataset(
            "Number of Commits from last $how_many_days_ago days",
            'line',
            $number_of_commits_per_day 
        );
        
        $dataset->backgroundColor(collect(['#094327']));
        $dataset->color(collect(['#094327']));

        return $chart;
    }
}
