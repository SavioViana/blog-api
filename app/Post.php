<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'body', 'image', 'published'];


    public function getTagsPost(int $id)
    {
        $posts = DB::table('posts')
                ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
                ->where('post_id', $id)
                ->select('tags.*')
                ->get();

        return $posts;
    }

    public function author()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

}
