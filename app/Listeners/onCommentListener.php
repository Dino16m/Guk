<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Mail;
use App\Events\onComment;
use App\User;
use App\posts;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;

class onCommentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $comment;
    protected $name;
    protected $parentContent;
    public function __construct($comment, $name, $parentContent)
    {
        $this->comment=$comment;
        $this->name= $name;
        $this->parentContent= $parentContent;
    }

    /**
     * Handle the event.
     *
     * @param  onComment  $event
     * @return void
     */
    public function handle(onComment $event)
    {
        if($event->comment->comment_type ==1){
          $post =  posts::find($event->comment->post_id)->first();
          $receiver = User::where('id',$post->User_id)->first();    
          $receiveremail= $receiver->email;
          $name = $receiver->username;
          $listener= new onCommentListener($event->comment, $name, $post->post_content);
        }
        if($event->comment->comment_type==0 && $event->comment->user_id==0 ){
            $post = comments::find($event->comment->comment_id)->first();
            $receiveremail = $post->guest_email;
            $name = $post->owner_id;
            $listener= new onCommentListener($event->comment, $name, $post->comment_content);
        }
        if($event->comment->comment_type==0 && $event->user_id!=0){
            $post = comments::find($event->comment->comment_id)->first();
            $receiver = User::where('id',$post->user_id)->first(); 
            $receiveremail= $receiver->email;
            $name = $receiver->username;
            $listener= new onCommentListener($event->comment, $name, $post->comment_content);
        }
        if ($receiver != null){
            return Mail::to(['email'=>$receiveremail, 'name'=>$name])->send(new \App\Mail\commentAdded($listener));
        }
    }
}
