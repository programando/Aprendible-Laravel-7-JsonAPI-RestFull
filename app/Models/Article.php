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

    public function scopeTitle( Builder $query, $value ) {
        $query->where('title', 'LIKE', "%{$value}%");
    }

   public function scopeContent( Builder $query, $value ) {
        $query->where('content', 'LIKE', "%{$value}%");
    }

   public function scopeYear( Builder $query, $value ) {
        $query->whereYear('created_at', $value);
    }

    public function scopeMonth( Builder $query, $value ) {
        $query->whereMonth('created_at',$value);
    }


    public function scopeSearch( Builder $query, $values ) {
        foreach ( Str::of($values )->explode(' ') as $value ){
            $query->orwhere('title', 'LIKE', "%{$value}%")
                  ->orWhere('content', 'LIKE',  "%{$value}%");
        }
    }

}
