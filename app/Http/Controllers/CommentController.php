<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Thread;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommentController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'content' => 'required|min:5',
            'thread_id' => 'required',
        ]);

        if($request->reply_to != ''){
            $reply = (Int) $request->reply_to;
            $reply = Comment::find($reply);

            if($reply == null){
                return back()->with('error', "Some thing went wrong when replying to comment");
            }else {
                $reply = $reply->id;
            }

        } else{
            $reply = 0;
        }

        $comment = new Comment();
        $comment->thread_id = $request->thread_id;
        $comment->content = $request->content;
        $comment->reply_to = $reply;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back()->withMessage("Comment Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comment)
    {

        $comment = (Int)$comment;
        $getComment = Comment::find($comment);

        $thread = (Int)$request->thread_id;
        $getThread = Thread::find($thread);

        if($getComment == null || $getThread == null || $getThread->id != $getComment->thread_id){
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

        if (auth()->user()->id != $getComment->user_id) {
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

         // Validate
        $this->validate($request, [
            'content'=>'required|min:2',
            // 'g-recaptcha-response' => 'required|captcha',
        ]);

        $commentUpdate = Comment::find($comment);
        $commentUpdate->content = (String)$request->content;
        $commentUpdate->save();

        return back()->withMessage("Comment Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment)
    {
        
        $comment = (Int)$comment;
        $getComment = Comment::find($comment);

        if($getComment == null){
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

        if (auth()->user()->id != $getComment->user_id) {
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

        DB::table('comments')->where('id', '=', $getComment->id)->delete();

        DB::table('replies')->where('comment_id', '=', $getComment->id)->delete();

        return back()->withMessage("Comment Deleted");
    }
}
