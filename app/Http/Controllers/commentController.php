<?php

namespace App\Http\Controllers;
use App\comments;
use Illuminate\Http\Request;
use App\Events\onComment;

class commentController extends Controller
{  
 /**
 * this method was created for testing purposes and isn't of much use otherwise
 * @return type Json or back() depending on the nature of the request
 */
    public function addCommentView(){
        return view('addcomment');
    }
    /**
     * this method adds comments to the database, it accepts data from form input
     * it gets the id of the post to be modified from the post input
     * @param Request $request
     * @return  Json or back() Json or back() depending on the nature of the request
     */
    public function addComment(Request $request) {
        $comment = new comments();
        $comment->comment_content= $request->input('content');
        $comment->post_id= $request->input('postId');
        $comment->user()->associate($request->user());
        $comment->comment_type = 1;
        $comment->owner_id=$request->input('user');
        $request->user()? $comment->owner_id=$request->user()->username : $comment->user_id=0;
        $comment->guest_email= $request->input('email');
        $comment->save();
        event(new onComment($comment));
        if($request->ajax()|$request->wantsJson()){
          $done = true;
          return response()->Json(['done'=>$done]);   
        }
        return back();    
    }
    /**
     * 
     * @param type $postId gotten from the route parameter, reference the route that calls this method
     * @param Request $request
     * @return type
     */
    public function getComments($postId, Request $request){
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
            $reply[$i]= comments::find($comment->id)->replies()->where('comment_type', 0)->orderBy('created_at','asc')->take(10)->get();
        $i++; }}
        $request->session()->put('postID',$postId);
        $request->session()->put('taken',$taken);
       if($request->ajax()|$request->wantsJson()){
           return response()->Json(['comments'=> $commented, 'replies'=>$reply]);
       }
       return view('posts')->with(['comments'=> $commented, 'replies'=>$reply]);
    }
    /**
     * this method adds a reply to the database, it should be called by an api and it returns a json object with a key of 'done' and the value of true
     * @param Request $request
     * @return type JSON
     */
    public function addReply(Request $request){ 
        $reply = new comments();
        $postId=$request->input('postId');
        $reply->comment_content= $request->input('content');
        $reply->post_id = $postId;
        $reply->comment_id=$request->input('parent_id');
        $reply->user()->associate($request->user());
        $reply->owner_id=$request->input('user');
        $request->user()? $reply->owner_id=$request->user()->username : $reply->user_id=0;
        $reply->guest_email = $request->input('email');
        $reply->comment_type = 0;
        $reply->save();
        $done = true;
        return response()->Json(['done'=>$done]);
    }
    /**
     * this method returns a JSON of replies of a particular node be it a comment or even a reply
     * @param Request $request
     * @param int $parentId
     * @return type json
     */
    
    public function getReplies(Request $request, $parentId){
        if($request->session()->has('takenReplies')){
            $takenReplies=$request->session()->get('takenReplies');
        }
        if(!$request->session()->has('parentId')&& $request->session()->get('parentId')!=$parentId ){
            $takenReplies=0;
            $replies = comments::where('comment_id',$parentId)->orderBy('created_at', 'asc')->take(3)->get();
        }
        else{$replies = comments::where('comment_id',$parentId)->skip($takenReplies)->orderBy('created_at', 'asc')->take(3)->get(); }
        $takenReplies+=3;
        $request->session()->put('parentId',$parentId);
        $request->session()->put('takenReplies',$takenReplies);
        if($request->ajax()|$request->wantsJson()){
            return response()->Json(['replies'=>$replies]);
        }
        return $replies;
        
    }
}
