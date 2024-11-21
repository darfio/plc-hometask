<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TestController extends Controller
{
    public function index(){
        // $tasks = Task::all();
        $task = Task::find(1);
        $task->changeStatus('in progress');
        $task->refresh();
        dd($task);
    }
}
