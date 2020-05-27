<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogAdmin extends Model
{
    protected $fillable = ['title', 'content', 'category_id', 'user_id'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

}
