<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Status;
use App\Contracts\Comment;
use App\Traits\StatusProcesses;

class Bug extends Model implements Status, Comment
{
    use HasFactory, SoftDeletes, StatusProcesses;

    protected $guarded = ['status'];

    public function addComment($comment){
        //
    }
}
