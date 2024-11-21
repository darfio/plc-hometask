<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Status;
use App\Contracts\Comment;
use App\Traits\StatusProcesses;

class Task extends Model implements Status, Comment
{
    use HasFactory, SoftDeletes, StatusProcesses;

    protected $guarded = ['status'];

    public function addComment($comment){
        $this->comments()->create([
            'text' => $comment,
        ]);
    }

    public function comments(){
        return $this->morphMany('App\Models\Comment', 'object');
    }

    public function logs(){
        return $this->morphMany('App\Models\Log', 'object');
    }
}

