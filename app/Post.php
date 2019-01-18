<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'image', 'published'];


    public function tags()
    {
        return $this->belongsToMany('\App\Tag');
    }

    public function author()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

}
