<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    protected $appends = ['is_reply'];

    public function getIsReplyAttribute(){
        if($this->object_type == 'App\Models\Comment')
            return true;
        return false;
    }

    public function comments(){
        return $this->morphMany('App\Models\Comment', 'object');
    }
}
