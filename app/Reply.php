<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

	protected $fillable = [];

	
    public function comment(){
    	return $this->belongsTo('App\Comment', 'id', 'comment_id');
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }


}
