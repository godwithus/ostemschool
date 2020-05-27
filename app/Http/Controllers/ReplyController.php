<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReplyController extends Controller
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

        if (!auth()->user()->id) {
            return redirect()->route('home')->withMessage("Please Login");
        }

        $comment_id = (Int)$request->comment_id;

        $getComment = Comment::find($comment_id);

        if ($getComment == null) {
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

         // Validate
        $this->validate($request, [
            'content'=>'required',
            // 'g-recaptcha-response' => 'required|captcha',
        ]);

        $reply = new Reply();
        $reply->user_id = auth()->user()->id;;
        $reply->content = $request->content;
        $reply->comment_id = $request->comment_id;
        $reply->save();

        return back()->withMessage("Reply Submit");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $reply)
    {
        $reply = (Int)$reply;
        $getReply = Reply::find($reply);

        $comment = (Int)$request->comment_id;
        $getComment = Comment::find($comment);

        if($getComment == null || $getReply == null || $getComment->id != $getReply->comment_id)
        {
            // dd('getta');
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

        if (auth()->user()->id != $getReply->user_id) {
            // dd('not');
            return redirect()->route('home')->withMessage("Thread Not Found");
        }

         // Validate
        $this->validate($request, [
            'content'=>'required|min:2',
            // 'g-recaptcha-response' => 'required|captcha',
        ]);

        $replyUpdate = Reply::find($reply);
        $replyUpdate->content = (String)$request->content;
        $replyUpdate->save();

        return back()->withMessage("Reply Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy($reply)
    {
        $reply = (Int)$reply;
        $getReply = Reply::find($reply);

        if($getReply == null)
        {
            // dd('getta');
            return redirect()->route('home')->withMessage("Reply Not Found");
        }

        if (auth()->user()->id != $getReply->user_id) {
            // dd('not');
            return redirect()->route('home')->withMessage("Reply Not Found");
        }

        DB::table('replies')->where('id', '=', $getReply->id)->delete();

        return back()->withMessage("Reply Deleted");
      
    }
}
