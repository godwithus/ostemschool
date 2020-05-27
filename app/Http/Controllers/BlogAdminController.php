<?php

namespace App\Http\Controllers;

use App\BlogAdmin;
use App\Thread;
use Illuminate\Support\Facades\DB;
use App\User;
use App\CreateSite;
use Illuminate\Http\Request;

class BlogAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        // We want to know if such Domain exist at all in our Database
        if ($getByDomain != null) {

            // If exist then let query the Thread Table to get all Sticky the Blog Post for that domain
            $threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->orderByDesc('updated_at')
                            ->limit(20)
                            ->get();
            return view('dashboard', compact('threads'));
        }
        // If any error occur we ABORT with error message
        abort(403, 'Something Went Wrong While Loading the Home Page');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        if ($getByDomain == null) {
            abort(403, 'Something Went Wrong While Loading the Admin');
        }

        $userEmail = $getAdminByEmail = '';

        $getAdmin = BlogAdmin::where('site_id', $getByDomain->id)->get();
        return view('admin', compact('getAdmin', 'userEmail', 'getAdminByEmail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        // Validating the Request
        $this->validate($request, [
            'email' => 'required|min:3',
        ]);
        
        // Working on the Domain making the User is Real
        $site_id = new CreateSite();
        $getByDomain = $site_id->confirmDomainId($request->site_id);
        
        $userEmail = User::where('email', $request->email)
        ->first();
       
        $getAdmin = BlogAdmin::where('site_id', $request->site_id)
                    ->get();
        
        $getAdminByEmail = BlogAdmin::where('site_id', $request->site_id)
                    ->where('user_id', $userEmail->id)
                    ->count();

        if($getByDomain == null){
            return back()->withMessage("Web URL Modified");
        }
        
        if ($getByDomain->user_id != auth()->user()->id) {
            abort(403, 'Only The Super Admin Can Do This');
        }

        return view('admin', compact('getAdmin', 'userEmail', 'getAdminByEmail'));
    }

    public function store($id)
    {
        $id = (Int)$id;
        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        if ($getByDomain == null || $getByDomain->user_id != auth()->user()->id) {
            abort(403, 'Something Went Wrong While Loading the Admin');
        }
        
        $userid = User::find($id);

        if ($userid == null) {
            abort(403, 'Something Went Wrong While Adding the User as an Admin');
        }

        $userEmail = User::where('email', $userid->email)
        ->first();
       
        $getAdmin = BlogAdmin::where('site_id', $getByDomain->id)
                    ->get();
        
        $getAdminByEmail = BlogAdmin::where('site_id', $getByDomain->id)
                    ->where('user_id', $userEmail->id)
                    ->count();
        
        if ($getAdminByEmail > 1) {
            return back()->with('error', "This User is already an Admin");
        }

        $blogAdmin = new BlogAdmin();
        $blogAdmin->user_id = $userid->id;
        $blogAdmin->site_id = $getByDomain->id;
        $blogAdmin->save();  
        
        return redirect()->route('admin')->with('success', "New Admin added to your admin list");

        
        // return view('admin', compact('getAdmin', 'userEmail', 'getAdminByEmail'));
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\BlogAdmin  $blogAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(BlogAdmin $blogAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogAdmin  $blogAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogAdmin $blogAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogAdmin  $blogAdmin
     * @return \Illuminate\Http\Response
     */

    public function action(Request $request)
    {
        
    $userEmail = "";
    
    $getAdmin = "";
    
    $getAdminByEmail = "";
                
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('users')
         ->where('email', 'like', '%'.$query.'%')
         ->limit(2)
         ->get();
         
      }

      $total_row = $data->count();
      if($total_row > 0)
      {
        
        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

       foreach($data as $row)
       {
            $getAdminByEmail = BlogAdmin::where('site_id', $getByDomain->id)
                    ->where('user_id', $row->id)
                    ->count();

            $isAdmin = '';
            if ($getAdminByEmail > 0) 
            {
                $isAdmin = '<i> Is Already An Admin  </i>';
            } 
            else 
            {
                $isAdmin = '<i><b> Not an Admin </b></i><a href="/make_admin/'.$row->id.'" class="btn btn-success btn-sm"> Add To Admin </a>';
            }
        
        $output .= '<div class="card-footer mb-2 mt-2"><b>'. $row->name .'</b> : '. $row->email .'<span class="float-right">'. $isAdmin .'</span></div>';

       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
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
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogAdmin  $blogAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (Int)$id;
        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        // We want to know if such Domain exist at all in our Database
        if($getByDomain == null){
            return back()->withMessage("Web URL Modified");
        }

        $getBlog = BlogAdmin::where('user_id', $id)
                    ->where('site_id', $getByDomain->id)
                    ->first();

        if ($getBlog == null) {
            return back()->withMessage("Something Went Wrong");
        }

        if ($getByDomain->user_id != auth()->user()->id) {
            return redirect()->route('home')->withMessage("Only Super Admin Can Do This");
        }

        if ($getBlog != null) {
            DB::table('blog_admins')
            ->where('user_id', '=', $id)
            ->where('site_id', $getByDomain->id)
            ->delete();

            return redirect()->route('admin')->with('success', "Admin Remove From Records");
        } 
        
        return redirect()->route('home')->withMessage("Admin Not Found");
    }
}
