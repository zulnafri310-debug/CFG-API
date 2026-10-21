<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarTemplate extends Model
{
    protected $fillable = 
    [
        'pattern', 
        'group', 
        'weight', 
        'is_active'
    ];
}

