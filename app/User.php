<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\File;
use Image;

class User extends Authenticatable 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
 
    public function uploadImage($model_name_and_find_id, $file_name, $upload_path, $column_name, $compressionRatio)
    {
        // $model_name_and_find_id = CreateSite::find($id);
        // $file_name = $request->file('logo')
        // $upload_path = public_path('logo_folder')
        // $column_name = $createSite->logo;

        $createSite = $model_name_and_find_id;
        $new_name = '';
        // Let Check if the User as an choose image to upload

        if ($file_name != '') {

            // We are about to process the image and also move it to it folder
            $image = $file_name;
            $new_name = rand() . '_'. auth()->user()->id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($upload_path), $new_name);

             
            $img = Image::make(public_path('/'.$upload_path.'/'.$new_name));
            $img->resize(null, $compressionRatio, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $img->orientate();
            $img->save();

        
        // Else the user does not choose any image let return every thing back to default
        } else{ 
            $new_name = $createSite->$column_name;
        }

        return $new_name;
    }

    public function threads()
    {
    	return $this->hasMany('App\Thread', 'user_id', 'id');
    }
    
    public function blogs()
    {
    	return $this->hasMany('App\BlogAdmin', 'user_id', 'id');
    }
}
