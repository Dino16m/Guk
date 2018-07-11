<?php

namespace App\Http\Controllers;
use App\comments;
use Illuminate\Http\Request;

class commentController extends Controller
{   
    public function addCommentView(){
        return view('addcomment');
    }
    public function addComment(Request $request) {
        $comment = new comments();
        $comment->comment_content= $request->input('content');
        $comment->post_id= $request->input('postId');
        $comment->user()->associate($request->user());
        if(!$request->user()){$comment->user_id=0;}
        $comment->comment_type = 1;
        $comment->owner_id=$request->input('user');
        $comment->save();
        if($request->ajax()|$request->wantsJson()){
          $done = true;
          return response()->Json(['done'=>$done]);   
        }
        return back();
        
        
    }
    public function getComments($postId, Request $request){
        $request->session()->flush();
        if ($request->session()->has('taken')){ 
           $taken= $request->session()->get('taken');
       }
       if(!$request->session()->has('postID')&& ($request->session()->get('postID')!= $postId)){ 
           $taken = 0;
           $comments= comments::where('post_id',$postId)->orderBy('created_at','asc')->take(10)->get();
       }
       else {$comments= comments::where('post_id',$postId)->skip($taken)->orderBy('created_at','asc')->take(10)->get();}
        $taken+=10;
        $i=0;
        foreach ($comments as $comment){
           if($comment->comment_type!=0){ $commented[$i]= $comment;
            $reply[$i]= comments::find($comment->id)->replies()->where('comment_type', 0)->get();
        $i++; }}
        $request->session()->put('postID',$postId);
        $request->session()->put('taken',$taken);
       if($request->ajax()|$request->wantsJson()){
           return response()->Json(['comments'=> $commented, 'replies'=>$reply]);
       }
       return view('posts')->with(['comments'=> $commented, 'replies'=>$reply]);
    }
    public function addReply(Request $request){ 
        $reply = new comments();
        $postId=$request->input('postId');
        $reply->comment_content= $request->input('content');
        $reply->post_id = $postId;
        $reply->comment_id=$request->input('parent_id');
        $reply->user()->associate($request->user());
        if(!$request->user()){$reply->user_id=0;}
        $reply->owner_id=$request->input('user');
        $reply->comment_type = 0;
        $reply->save();
        $done = true;
        return response()->Json(['done'=>$done]);
    }
    public function getReplies(Request $request, $parentId){
        if($request->session()->has('takenReplies')){
            $takenReplies=$request->session()->get('takenReplies');
        }
        if(!$request->session()->has('parentId')&& $request->session()->get('parentId')!=$parentId ){
            $takenReplies=0;
        }
        $replies = comments::where('comment_id',$parentId)->skip($takenReplies)->orderBy('created_at', 'asc')->take(3);
        $takenReplies+=3;
        $request->session()->put('parentId',$parentId);
        $request->session()->put('takenReplies',$takenReplies);
        if($request->ajax()|$request->wantsJson()){
            return response()->Json(['replies'=>$replies]);
        }
        return $replies;
        
    }
}
