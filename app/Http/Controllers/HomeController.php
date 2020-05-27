<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CreateSite;
use App\Thread;
use App\Department;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stickyPostList()
    { 
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();
        // We want to know if such Domain exist at all in our Database
        if ($getByDomain != null) {

            // If exist then let query the Thread Table to get all Sticky the Blog Post for that domain
            $sticky_threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('stick_post', 'yes')
                            ->orderByDesc('updated_at')
                            ->paginate(10);

            return view('sticky', compact('sticky_threads', 'none_sticky_threads', 'getByDomain'));
        }
        else{
            // If any error occur we ABORT with error message
            abort(403, 'Something Went Wrong While Loading the Featured Articles');
        }

        
    }

    public function noneStickyPostList()
    {
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();
        // We want to know if such Domain exist at all in our Database
        if ($getByDomain != null) {

            // If exist then let query the Thread Table to get all the None Sticky Blog Post for that domain
            $none_sticky_threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('stick_post', 'no')
                            ->orderByDesc('updated_at')
                            ->paginate(10);

            return view('none_sticky', compact('none_sticky_threads', 'getByDomain'));
        }
        else{
            // If any error occur we ABORT with error message
            abort(403, 'Something Went Wrong While Loading the Popular Articles');
        }

        
    }

    public function index()
    {
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();
        // We want to know if such Domain exist at all in our Database
        if ($getByDomain != null) {

            // If exist then let query the Thread Table to get all Sticky the Blog Post for that domain
            $sticky_threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('stick_post', 'yes')
                            ->orderByDesc('updated_at')
                            ->limit(6)
                            ->get();
            
            $sticky_threads_count = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('stick_post', 'yes')
                            ->orderByDesc('updated_at')
                            ->limit(7)
                            ->count();

            // If exist then let query the Thread Table to get all the None Sticky Blog Post for that domain
            $none_sticky_threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('stick_post', 'no')
                            ->orderByDesc('updated_at')
                            ->limit(6)
                            ->get();

            $none_sticky_threads_count = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('stick_post', 'no')
                            ->orderByDesc('updated_at')
                            ->limit(7)
                            ->count();


            return view('home', compact('sticky_threads', 'none_sticky_threads', 'getByDomain', 'sticky_threads_count', 'none_sticky_threads_count'));
        }
        elseif (count($currentDomain) == 2 &&  $currentDomain[0] == 'ostemschool' && $currentDomain[1] == 'test') {
            
            $sites = $users = DB::table('create_sites')
                    ->limit(10)
                    ->inRandomOrder()
                    ->get();

            return view('parent_home', compact('sites'));
        }
        else{
            // If any error occur we ABORT with error message
            abort(403, 'Something Went Wrong While Loading the Home Page');
        }

        
    }

    public function show(Request $request, $id)
    {
         // Id of the Post to Show
         $id = (Int)$id;

         // We want to get the Domain of the Current Domain the Use is ON
         $domain = new CreateSite();
         $getByDomain = $domain->getUrl();
 
         // We want to know if such Domain exist at all in our Database
         if ($getByDomain != null) {
            // If exist then let query the Thread Table to get the expect Blog Post for that Domain
            $thread = Thread::where('site_id', $domain->getUrl()->id )
                        ->where('id', $id)
                        ->first();
            
            if ($thread != null) {

                
                $comments = Comment::where('thread_id', $id)->orderByDesc('updated_at')->paginate(3);
                $commentsCount = Comment::where('thread_id', $id)->count();

                if ($request->ajax()) {
                    return \Response::json(\View::make('comments', array('comments' => $comments, 'thread' => $thread))->render());
                }

                $commentsCount = Comment::where('thread_id', $id)->count();

                return view('show', compact('thread', 'comments', 'commentsCount', 'getByDomain', 'category'));
            }

            abort(403, 'Something Went Wrong While Loading the While loading the Expected BLog Post');
         }

        // If any error occur we ABORT with error message
        abort(403, 'Something Went Wrong While Loading the Home Page');
    }

    public function profile($id)
    {
        $id = (Int)$id;

        $user = User::find($id);
        if ($user != null) {
            return view('profile', compact('user'));
        }

        return redirect()->route('home')->withMessage("Profile Not Found");
    }

    public function section($id){

        $id = (Int) $id;
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        $dept = Department::find($id);
        $dept = $dept->name;

        // We want to get the Domain of the Current Domain the Use is ON
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();
        // We want to know if such Domain exist at all in our Database
        if ($getByDomain != null) {

            // If exist then let query the Thread Table to get all Sticky the Blog Post for that domain
            $threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->where('department', $id)
                            ->orderByDesc('updated_at')
                            ->paginate(10);

            return view('section_list', compact('threads', 'id', 'getByDomain', 'dept'));
        }
        else{
            // If any error occur we ABORT with error message
            abort(403, 'Something Went Wrong While Loading the Featured Articles');
        }
    }
}
