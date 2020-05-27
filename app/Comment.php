<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function replies()
    {
    	return $this->hasMany('App\Reply', 'comment_id', 'id');
    }

     public function thread(){
        return $this->belongsTo(Thread::class);
    }

}
