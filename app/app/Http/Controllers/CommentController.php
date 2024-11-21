<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EntityController;
use App\Models\Comment;
use App\Models\Task;
use App\Helpers\Crud;

class CommentController extends EntityController
{
    protected $crud;
    protected $route_names_prefix = "comments";
    protected $fields_path = "pages.comments.fields";

    public function __construct(){
        parent::__construct(Comment::class);
    }

    public function store(Request $request){
        // dd($request->object_id);

        if($request->object_type == 'Task'){
            $task = Task::findOrFail($request->object_id);
            $task->addComment($request->text);
        }

        // $this->crud->store($request);
        return redirect()->back();
    }

}
