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
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'text'=>'required|string|max:2048'
        ]);

        $userId = Auth::id();

        $comment = Comment::create([
            'article_id'=>$request->article_id,
            'text'=>$request->text
        ]);

        $commentCount = Comment::where('article_id', $request->article_id)->count();
        return response()->json(['comment'=>$comment, 'commentCount'=> $commentCount],201);
    }
}
