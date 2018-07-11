<?php

namespace App\Http\Controllers;
use App\posts;

use Illuminate\Http\Request;

class postController extends Controller
{
    /**
     * returns all the posts in the database
     * @param Request $request
     * @return type JSON or View depending on the request origin
     */
    public function index(Request $request){
        $posts= posts::all(); 
        if($request->ajax()|$request->wantsJson()){
            $posts->toArray();
            return response()->json(['posts'=>$posts]); 
        }
        return view('postIndex')->with(['posts'=>$posts]);
    }
    /**
     * returns the view to add posts to the database
     * @return type View
     */
    public function addPostIndex(){
        return view('addPostIndex');
    }
    /**
     * this gets a particular post from the database, it accepts a generared uri request
     * @param type $uri
     * @param Request $request
     * @return type JSON or View depending on the origin of the request
     */
    public function getPost($uri, Request $request){
        if(!$uri){return redirect()->route('posts');}
        $dbpost = posts::where('uri',$uri)->first();
        $comments=$dbpost->comments()->orderBy('created_at','asc')->take(10)->get();
        $post['title']=$dbpost->title;
        $post['content']=$dbpost->post_content;
        $post['id']=$dbpost->id;
        if($request->ajax()|$request->wantsJson()){
            return response()->json(['post'=>$post,'comments'=>$comments]);
        }
        return view('posts')->with(['post'=>$post,'comments'=>$comments]);
    }
    /**
     * adds a post to the database
     * @param Request $request
     * @return type back()
     */
    public function addPost(Request $request){
      $post = new posts();
      $uri = preg_replace('/\s+/','_',$request->input('title'));
      $post->user()->associate($request->user());
      $post->post_content = $request->input('content');
      $post->title=$request->input('title');
      $post->uri= $uri;
      $post->save();
      return back();
    }
}
