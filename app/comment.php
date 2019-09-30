<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $fillable = [
        'comment','user_id','post_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function post(){
       return $this->belongsTo(Post::class);
    }

}
