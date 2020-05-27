<?php

namespace App\Http\Controllers;

use App\Thread;
// use App\Category;
use App\User;
use App\CreateSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        $id = (Int)$id;
        $user = User::find($id);
        return view('edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $profile = User::find(auth()->user()->id);
        $data = $request->all();
        $myPass = '';

        if ($request->password != '') {

            $this->validate($request, [
                'name' => 'required|string|max:255', 
                'email' => 'required|string|email|max:255|unique:users,email,'.auth()->user()->id,
                'old_password' => 'string|min:8',
                'password' => 'string|min:8|confirmed',
                'pic' => 'image|mimes:jpeg,png,jpg,jpeg,gif|max:2048',
            ]);
            
            
            if (!\Hash::check($data['old_password'], $profile->password)) {
                return back()->with('error', 'The current password is not correct');
            } 
            else{
                $myPass = \Hash::make($data['password']);
            }
        } 
        else
        {
            $this->validate($request, [
                'name' => 'required|string|max:255', 
                'email' => 'required|string|email|max:255|unique:users,email,'.auth()->user()->id,
                'pic' => 'image|mimes:jpeg,png,jpg,jpeg,gif|max:2048',
            ]);

            $myPass = $profile->password;

        }
        

        $imageUpload = new User();

        $profileimage = $request->file('pic');
        $uploadFeatureImage = $imageUpload->uploadImage($profile, $profileimage, 'profile_images', 'pic', 200);

        // Let Check if the User have Logo Image uploaded already or not
        if ($profile->pic != '' && $request->file('pic') != null) {
            $image_path = "/profile_images/$profile->pic"; 
            if(\File::exists(public_path($image_path))) {
                \File::delete(public_path($image_path));
            }
        }

        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->pic = $uploadFeatureImage;
        $profile->password = $myPass;
        $profile->updated_at = date('Y-m-d H:i:s');
        $profile->save();

        return back()->with('success', 'Profile Updated Successfully');

    }
}
