<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreateSite extends Model
{
    //

    // This method is use to  get the url the user is on Presently
    public function getUrl()
    {
        $getUrl = explode('.', $_SERVER['HTTP_HOST'])[0];
        $getByDomain = CreateSite::where('domain', $getUrl)
                        ->first();
        return $getByDomain;
    }

    // We want to confirm the Domain ID we get why creating or edit a new Blog Post
    public function confirmDomainId($site_id)
    {
        $site_id = (Int) $site_id;
        $confirmId = CreateSite::where('id', $site_id)->first();
        return $confirmId;
    }

    public function parentDomain()
    {
        return 'ostemschool.test';
    }
    
    public function thread()
    {
    	return $this->hasMany('App\Thread', 'site_id', 'id');
    }

}
