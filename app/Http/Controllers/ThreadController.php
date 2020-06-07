<?php

namespace App\Http\Controllers;

use App\Thread;
// use App\Category;
use App\User;
use App\CreateSite;
use App\Department;
use App\AddMedia;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThreadController extends Controller
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
    public function create(Request $request)
    {
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        $dept = Department::all();                    

        $addMedias = AddMedia::where('site_id', $getByDomain->getUrl()->id)->orderByDesc('updated_at')->paginate(1);

        $addMediasCount = AddMedia::where('site_id', $getByDomain->getUrl()->id)->count();

        if ($request->ajax()) {
            return \Response::json(\View::make('choose_image', array('addMedias' => $addMedias))->render());
        }

        return view('blog.create', compact('dept', 'addMedias', 'addMediasCount'));
    }

    public function sitesearch(Request $request)
    {
        // We want to get the Domain of the Current Domain the Use is ON
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        $url_id = $getByDomain->getUrl()->id;

        $threads = $users = DB::table('threads')
            ->inRandomOrder()
            ->paginate(20);

    	if($request->has('search')){
            $threads = Thread::where('site_id',  $url_id)
                    ->search($request->get('search'))
                    ->paginate(20);	
        }
        
        return view('sitesearch', compact('threads', 'getByDomain', 'threads'));
    }    

    public function allBlog()
    {
        // We want to get the Domain of the Current Domain the Use is ON
        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);

        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        // We want to know if such Domain exist at all in our Database
        if ($getByDomain != null) {

            // If exist then let query the Thread Table to get all Sticky the Blog Post for that domain
            $threads = Thread::where('site_id', $getByDomain->getUrl()->id )
                            ->inRandomOrder()
                            ->paginate(20);
            
            return view('blog', compact('getByDomain', 'threads'));
        } 
        elseif (count($currentDomain) == 2 &&  $currentDomain[0] == 'ostemschool' && $currentDomain[1] == 'test') {
            
            $threads = $users = DB::table('threads')
                    ->inRandomOrder()
                    ->paginate(20);

            $getByDomain = '';

            return view('allblog', compact('getByDomain', 'threads'));
        }
        elseif (count($currentDomain) == 2 &&  $currentDomain[0] == 'ostem' && $currentDomain[1] == 'school') {
            
            $threads = $users = DB::table('threads')
                    ->inRandomOrder()
                    ->paginate(20);

            $getByDomain = '';

            return view('allblog', compact('getByDomain', 'threads'));
        }
        else{
            // If any error occur we ABORT with error message 
            abort(403, 'Something Went Wrong While Loading List of Blog Posts');
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
        // Validating the Request
        $this->validate($request, [
            'title' => 'required|min:5|max:50',
            'content' => 'required|min:5',
            'site_id' => 'required|int',
            'department' => 'required|int',
            'feature' => 'image|mimes:jpeg,png,jpg,jpeg,gif|max:2048',
            'stick_post' => 'string',
        ]);
        
        // Working on the Domain making the User is Real
        $site_id = new CreateSite();
        $getByDomain = $site_id->confirmDomainId($request->site_id);
        
        if($getByDomain == null){
            return back()->withMessage("Web URL Modified");
        }


        $img_new_name = '';
        if ($request->file('feature') != '') {
            $image = $request->file('feature');
            $img_new_name = rand() . '_'. auth()->user()->id . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('feature_images'), $img_new_name);
        }
        
        // Inserting the new Record into Database
        $thread = new Thread(); 
        $thread->title = $request->title;
        $thread->slug = Str::slug($request->title, '-');
        $thread->feature_image = $img_new_name; 
        $thread->content = $request->content;
        $thread->department = $request->department;
        $thread->stick_post = $request->stick_post == '' ? 'no' : 'yes';
        $thread->user_id = auth()->user()->id; 
        $thread->site_id = $request->site_id;
        $thread->save();

        return redirect()->route('show.post', ['id' => $thread->id, 'slug' => $thread->slug, ])->with('success', 'New Article Successfully Created');


        return redirect()->route('home')->withMessage("Thread Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread, $id)
    {
        $threads = Thread::find($id);

        $list = (Int) auth()->user()->group_section;
        $category = Category::find($list);
        $allCategory = Category::all();


        if($threads == null){
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

            $comments = Comment::where('thread_id', $id)->get();

            $commentsCount = Comment::where('thread_id', $id)->count();

        return view('forum.show', compact('threads', 'comments', 'commentsCount', 'category', 'allCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = new CreateSite();
        $getByDomain = $domain->getUrl();

        $id = (Int)$id;
        $thread = Thread::where('id', $id)->first();
        $dept = Department::all(); 

        if ($thread != null) {
            return view('blog.edit', compact('thread', 'dept', 'getByDomain'));
        }
        
        if (auth()->user()->id != $thread->user_id) {
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

        return back()->withMessage("Thread Created");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = (Int)$id;
        
        // Validating the Request
        $this->validate($request, [
            'title' => 'required|min:5|max:50',
            'content' => 'required|min:5',
            'site_id' => 'required|int',
            'feature' => 'image|mimes:jpeg,png,jpg,jpeg,gif|max:2048',
            'stick_post' => 'string',
        ]);
        
        // Working on the Domain making the User is Real
        $site_id = new CreateSite();
        $getByDomain = $site_id->confirmDomainId($request->site_id);
        
        if($getByDomain == null){
            return back()->withMessage("Web URL Modified");
        }

        $checkThread = Thread::where('id', $id)
                        ->where('site_id', $request->site_id)
                        ->count();

        if ($checkThread < 1) {
            abort(403, 'An Error Occur :( Could not update Post');
        }
        
        $thread = Thread::find($id);
        $imageUpload = new User();
        
        $featureimage = $request->file('feature');
        $uploadFeatureImage = $imageUpload->uploadImage($thread, $featureimage, 'feature_images', 'feature', 300);
        
       // Let Check if the User have Logo Image uploaded already or not
        if ($thread->feature_image != '' && $request->file('feature') != null) {
            $image_path = "/feature_images/$thread->feature_image"; 
            if(\File::exists(public_path($image_path))) {
                \File::delete(public_path($image_path));
            }
        } 
        
        elseif ($request->file('feature') == null) {
            $uploadFeatureImage = $thread->feature_image;
        }


        // Inserting the new Record into Database
        $thread->title = $request->title;
        $thread->slug = Str::slug($request->title, '-');
        $thread->feature_image = $uploadFeatureImage; 
        $thread->content = $request->content;
        $thread->stick_post = $request->stick_post == '' ? 'no' : 'yes';
        $thread->user_id = auth()->user()->id; 
        $thread->site_id = $request->site_id;
        $thread->updated_at = date('Y-m-d H:i:s');
        $thread->save();

        return redirect()->route('show.post', ['id' => $thread->id, 'slug' => $thread->slug])->with('success', 'Article Successfully Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
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

        $getThread = Thread::where('id', $id)->first();

        if ($getThread == null) {
            return back()->withMessage("Something Went Wrong");
        }

        if ((auth()->user()->id != $getThread->user_id) || ($getByDomain->user_id != auth()->user()->id)) {
            return redirect()->route('home')->withMessage("Article Not Found");
        }

        if ($getThread != null) {
            DB::table('threads')->where('id', '=', $getThread->id)->delete();
            return redirect()->route('home')->with('success', 'Article Deleted Successfully');
        } 
        
        return redirect()->route('home')->with('error', 'Article Could Not Be Deleted');
    }
}
