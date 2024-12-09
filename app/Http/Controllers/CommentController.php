<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function store (Request $request) {

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();

        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'text'=>'required|string|max:2048'
        ]);

        $comment = Comment::create([
            'user_id' => $userId,
            'article_id'=> $request->article_id,
            'text' => $request->text,
        ]);

        $commentCount = Comment::where('article_id', $request->article_id)->count();
        return response()->json(['comment'=>$comment, 'commentCount'=> $commentCount],201);
    }
}
