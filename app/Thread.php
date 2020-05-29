<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Thread extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'threads.title' => 10,
        ]
    ];

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
