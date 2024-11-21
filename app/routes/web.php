<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BugController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'index']);

Route::patch('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
Route::resource('/tasks', TaskController::class)->names('tasks');

Route::patch('/bugs/{id}/restore', [BugController::class, 'restore'])->name('bugs.restore');
Route::resource('/bugs', BugController::class)->names('bugs');

Route::resource('/comments', CommentController::class)->names('comments');
