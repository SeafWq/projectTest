<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }


    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User  not authenticated.'], 401);
        }

        $request->validate([
            'article_id' => 'required|exists:articles,id',
        ]);

        $userId = Auth::id();
        $existingLike = Like::where('article_id', $request->article_id)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $likeCount = Like::where('article_id', $request->article_id)->count();
            return response()->json(['message' => 'success', 'likeCount' => $likeCount], 200);
        }

        $like = Like::create([
            'article_id' => $request->article_id,
            'user_id' => $userId
        ]);

        $likeCount = Like::where('article_id', $request->article_id)->count();
        return response()->json(['like' => $like, 'likeCount' => $likeCount], 201);
    }
}
