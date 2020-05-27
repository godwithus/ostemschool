<?php

namespace App\Http\Controllers;

use App\CreateSite;
use App\User;
use Image;
use Illuminate\Http\Request;

class CreateSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('create_sites.index');
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

    
   
    public function action(Request $request)
    {
        
    $userEmail = "";
    
    $getAdmin = "";
    
    $getAdminByEmail = "";
    $parentDomain = new CreateSite();

     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {

       $data = DB::table('create_sites')
         ->where('domain', 'like', '%'.$query.'%')
         ->where('name', 'like', '%'.$query.'%')
         ->limit(5)
         ->get();
         
      }

      $total_row = $data->count();
      if($total_row > 0)
      {

       foreach($data as $row)
       {
        $output .= '<div class="card-footer mb-2 mt-2 text-center"><b>'. $row->name .'</b> : <a href="http://'.$row->domain.'.'. $parentDomain->parentDomain() .'">'. $row->domain .'</a></div>';
       }
      }
      else
      {
       $output = '
        <h1 class="card-footer mb-2 mt-2 text-center">No Data Found</h1>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
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
        $this->validate($request, [
            'logo' => 'image|mimes:jpeg,png,jpg,jpeg,gif|max:2048',
            'bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'domain' => 'required|min:2|max:15|unique:create_sites',
            'name' => 'required|min:2|max:50',
            'description' => 'required|min:2|max:200',
        ]);
        
        $new_name = '';
        if ($request->file('logo') != '') {
            $image = $request->file('logo');
            $new_name = rand() . '_'. auth()->user()->id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('sites_logo'), $new_name);

            $upload_path = 'sites_logo';
            // dd(public_path('/'.$upload_path.'/'.$new_name));
            $img = Image::make(public_path('/'.$upload_path.'/'.$new_name));
            $img->resize(null, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $img->orientate();
            $img->save();
        }
        
        $bg_new_name = '';
        if ($request->file('bg') != '') {
            $bg_image = $request->file('bg');
            $bg_new_name = rand() . '_'. auth()->user()->id . '.' . $bg_image->getClientOriginalExtension();
        $bg_image->move(public_path('sites_bg'), $bg_new_name);
        }

        $createSite = new CreateSite();
        $createSite->domain = $request->domain;
        $createSite->name    = $request->name;
        $createSite->description    = $request->description;
        $createSite->logo    = $new_name;
        $createSite->bg    = $bg_new_name;
        $createSite->user_id = auth()->user()->id;
        $createSite->save();

        $newSiteURL = "http://". $createSite->domain . "." .$createSite->parentDomain();
        // return view('home');
        return redirect()->away($newSiteURL);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CreateSite  $createSite
     * @return \Illuminate\Http\Response
     */
    public function show(CreateSite $createSite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CreateSite  $createSite
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        if ($getByDomain == null) {
            abort(403, 'The Domian can not be Found');
        }

        return view('create_sites.edit', compact('getByDomain'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CreateSite  $createSite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'logo' => 'image|mimes:jpeg,png,jpg,jpeg,gif|max:2048',
            'bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|min:2|max:50',
            'description' => 'required|min:2|max:200',
        ]);
        
        $createSite = CreateSite::find($id);
        $imageUpload = new User();
        
        $logo = $request->file('logo');
        $bg = $request->file('bg');
        
        $uploadLogo = $imageUpload->uploadImage($createSite, $logo, 'sites_logo', 'logo', 100);
        $uploadBg = $imageUpload->uploadImage($createSite, $bg, 'sites_bg', 'bg', 300);
        
        
       // Let Check if the User have Logo Image uploaded already or not
        if ($createSite->logo != '' && $request->file('logo') != null) {
            $image_path = "/sites_logo/$createSite->logo"; 
            if(\File::exists(public_path($image_path))) {
                \File::delete(public_path($image_path));
            }
        }
         
        // Let Check if the User Bg Image uploaded already or not
        if ($createSite->bg != '' && $request->file('bg') != null) {
            $image_path = "/sites_bg/$createSite->bg";
            if(\File::exists(public_path($image_path))) {
                \File::delete(public_path($image_path));
            }
        }



        $createSite->name    = $request->name;
        $createSite->description    = $request->description;
        $createSite->logo= $uploadLogo;
        $createSite->bg = $uploadBg ;
        $createSite->user_id = auth()->user()->id;
        $createSite->save();

        return back()->withMessage("Site Edited");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CreateSite  $createSite
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreateSite $createSite)
    {
        //
    }
}
