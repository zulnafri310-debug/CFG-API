<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = 
    [
        'tag', 
        'name', 
        'description'
    ];

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}

