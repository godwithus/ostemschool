<?php

namespace App\Http\Controllers;

use App\AddMedia;
use Illuminate\Http\Request;
use Validator;
use App\CreateSite;
use Image;



class AddMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    function action(Request $request)
    {
    
        $path = $request->file('select_file')->store(
            'avatars', 's3'
        );

     // We want to get the Domain of the Current Domain the Use is ON
     $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

     $domain = new CreateSite();
     $getByDomain = $domain->getUrl();

     $validation = Validator::make($request->all(), [
      'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
     ]);
     if($validation->passes())
     {
      $domain = $getByDomain->getUrl()->domain;
      $image = $request->file('select_file');
      $new_name = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('posts_image/'.$domain), $new_name);
    
      $img = Image::make(public_path('posts_image/'.$domain.'/'.$new_name));
        $img->resize(null, 500, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $img->orientate();
        $img->save();

      $addMedia = new AddMedia();
      $addMedia->site_id = $request->site_id;
      $addMedia->name    = $new_name;
      $addMedia->user_id = auth()->user()->id;
      $addMedia->save();

      $currentDomain = explode('.', $_SERVER['HTTP_HOST']);
      
      $url = '';
      if (count($currentDomain) == 2 &&  $currentDomain[0] == 'ostem' && $currentDomain[1] == 'school') {
        $url = 'https://'.$currentDomain[0].'.ostem.school/posts_image/'.$currentDomain[0].'/'.$new_name;
      } else{
        $url = 'http://'.$currentDomain[0].'.ostemschool.test/posts_image/'.$currentDomain[0].'/'.$new_name;
      }

      return response()->json([
       'message'   => 'Image Upload Successfully',
       'uploaded_image' => '<img src="/posts_image/'.$domain.'/'.$new_name.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success',
       'image_name'  => $url
      ]);
     }
     else
     {
      return response()->json([
       'message'   => $validation->errors()->all(),
       'uploaded_image' => '',
       'class_name'  => 'alert-danger',
       'image_name'  => ''
      ]);
     }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    function load_data(Request $request)
    {
        
        $domain = explode('.', $_SERVER['HTTP_HOST']); 
        $createDomain = new CreateSite();
        $getByDomain = $createDomain->getUrl();
        $site_id = $getByDomain->getUrl()->id;
    
        // We want to know if such Domain exist at all in our Database
        if($getByDomain == null){
            return back()->withMessage("Web URL Modified");
        }

        $imgurl = '';
        if (count($domain) == 2 &&  $domain[0] == 'ostem' && $domain[1] == 'school') {
            $imgurl = 'https://'.$domain[0].'.ostem.school/posts_image/'.$domain[0];
        } else{
            $imgurl = 'http://'.$domain[0].'.ostemschool.test/posts_image/'.$domain[0];
        }

     if($request->ajax())
     {
      if($request->id > 0)
      {
       $data = \DB::table('add_media')
          ->where('id', '<', $request->id)
          ->where('site_id', $site_id)
          ->orderBy('id', 'DESC')
          ->limit(5)
          ->get();
      }
      else
      {
       $data = \DB::table('add_media')
          ->where('site_id', $site_id)
          ->orderBy('id', 'DESC')
          ->limit(5)
          ->get();
      }
      $output = '';
      $last_id = '';
      
      if(!$data->isEmpty())
      {
       foreach($data as $row)
       {
        $output .= '
        <div style="color: green; font-weight: bold; text-align: center; display: none;" id="address_copied_'.$row->id.'"> Image Address Copied</div>
        
        
        <div class="modal-body text-center">
            <div class="card">
                <img class="card-img-top" src="'.$imgurl.'/'.$row->name.'" alt="Card image cap">
                <div class="card-body">
                    <div style="color: green; font-weight: bold; text-align: center; display: none;" id="address_copied_'.$row->id.'"> Image Address Copied</div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">

                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" style="border-radius: 10px 0px 0px 10px" type="button" onclick="copyAddress(\'myInput-'.$row->id.'\', \'address_copied_'.$row->id.'\')">Copy Address</button>
                                </span>

                                <input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." value="'.$imgurl.'/'.$row->name.'" id="myInput-'.$row->id.'" >

                                <span class="input-group-btn" data-toggle="modal" data-target="#delete_'.$row->id.'" onclick="deleteImage(\'deleteImage_'.$row->id.'\')">
                                    <button class="btn btn-danger" type="button"  style="border-radius: 0 10px 10px 0"> Delete </button>
                                </span>

                            </div>
                        </div>

                        <div class="mt-2 text-center" role="alert" id="deleteImage_'.$row->id.'" style="display: none; margin: 0 auto;"> 
                            <span style="color: red;"> Are you sure you want to delete this Image </span>
                            <br>
                            <a href="delete_image/'.$row->id.'" class="btn btn-danger"> Yes </a>
                            <button onclick="cancleImage(\'deleteImage_'.$row->id.'\')" class="btn btn-default">No</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>';

        $last_id = $row->id;
       }
       $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-secondary form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
       </div>
       ';
      }
      else
      {
       $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-secondary form-control">No Data Found</button>
       </div>
       ';
      }
      echo $output;
     }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AddMedia  $addMedia
     * @return \Illuminate\Http\Response
     */
    public function show(AddMedia $addMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AddMedia  $addMedia
     * @return \Illuminate\Http\Response
     */
    public function edit(AddMedia $addMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddMedia  $addMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddMedia $addMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddMedia  $addMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        $id = (Int)$id;
        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        // We want to know if such Domain exist at all in our Database
        if($getByDomain == null){
            return back()->withMessage("Web URL Modified");
        }

        $getAddMedia = AddMedia::where('id', $id)->first();

        if ($getAddMedia == null) {
            return back()->withMessage("Something Went Wrong");
        }

        if ((auth()->user()->id != $getAddMedia->user_id)) {
            return redirect()->route('home')->withMessage("Article Not Found");
        }

        if ($getAddMedia != null) {

            $img = $currentDomain[0];
            $image_path = "/posts_image/".$img.'/'.$getAddMedia->name; 

            if(\File::exists(public_path($image_path))) {
                \File::delete(public_path($image_path));
            }

            \DB::table('add_media')->where('id', '=', $getAddMedia->id)->delete();

            return back()->with("success", "Image Deleted Successful");
        } 
        
        return redirect()->route('home')->with('error', 'Article Could Not Be Deleted');
    }
}
