<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EntityController;
use App\Models\Task;
use App\Helpers\Crud;

class TaskController extends EntityController
{
    protected $crud;
    protected $route_names_prefix = "tasks";
    protected $fields_path = "pages.tasks.fields";

    public function __construct(){
        parent::__construct(Task::class);
    }


}
