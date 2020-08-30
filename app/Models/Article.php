<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
 
class Article extends Model
{
              
    public $allowedSorts = ['title', 'content'];
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'user_id' => 'integer',
    ];
 
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    
}
