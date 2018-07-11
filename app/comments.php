<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $attributes = ['user_id'=>0];
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function replies(){
        return $this->hasMany(comments::class,'comment_id', 'id');
    }
}
