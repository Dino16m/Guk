<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
 
   public function user(){
       
   return $this->belongsTo(User::class);
   
   }
   public function comments(){
       return $this->hasMany(comments::class,'post_id');
   }
}
