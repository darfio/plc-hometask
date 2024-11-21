<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EntityApiController;
use App\Http\Controllers\Api\EntityCommentApiController;
use App\Http\Controllers\Api\CommentReplyApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/entities/{type}', [EntityApiController::class, 'index']);
Route::post('/entities/{type}', [EntityApiController::class, 'store']);
Route::get('/entities/{type}/{id}', [EntityApiController::class, 'show']);
Route::put('/entities/{type}/{id}/update', [EntityApiController::class, 'update']);
Route::delete('/entities/{type}/{id}/delete', [EntityApiController::class, 'destroy']);
Route::patch('/entities/{type}/{id}/restore', [EntityApiController::class, 'restore']);

Route::post('/entities/{type}/{entity_id}/comments', [EntityCommentApiController::class, 'store']);
Route::post('/comments/{id}/reply', [CommentReplyApiController::class, 'store']);
