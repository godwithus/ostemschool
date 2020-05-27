<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title', 'content', 'category_id', 'user_id'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function sites()
    {
    	return $this->belongsTo('App\CreateSite', 'site_id', 'id');
    }

    public function comments()
    {
    	return $this->hasMany('App\Comment', 'thread_id', 'id');
    }
}
