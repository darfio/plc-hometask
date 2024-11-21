<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentReplyApiController extends Controller
{
    public function store(Request $request, $id)
    {
        $item = Comment::find($id);
        $reply = $item->comments()->create([
            'text' => $request->text,
        ]);
        $data = [
            'data' => $reply,
        ];
        return response()->json($data);
    }

}
