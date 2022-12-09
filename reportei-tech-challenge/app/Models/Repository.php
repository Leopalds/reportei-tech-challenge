<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
