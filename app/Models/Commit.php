<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'date',
        'repository_id'
    ];

    /**
     * Get the repository that owns the commit.
     */
    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
