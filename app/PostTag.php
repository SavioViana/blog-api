<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostTag extends Model
{
    protected $table = 'post_tag';

    public  $timestamps   = false;

}
