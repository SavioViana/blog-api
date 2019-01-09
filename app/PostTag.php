<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostTag extends Model
{
    protected $table = 'post_tag';

    public  $timestamps   = false;

    public function posts(int $tagId)
    {
        $posts = DB::table('posts')
                ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
                ->where('post_tag.tag_id', $tagId)
                ->select('*')
                ->get();
        
        return $posts;
    }

}
