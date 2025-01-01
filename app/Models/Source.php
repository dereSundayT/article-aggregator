<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Source extends Model
{
    protected $fillable = [
        'name','api_key','api_url'
    ];
    //
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
