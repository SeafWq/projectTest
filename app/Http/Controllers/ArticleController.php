<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

//    public function __construct(){
//        $this->middleware('jwt.auth');
//    }

    public function index(Request $request) {
        $page = $request->get('page', 1);
        $userId = Auth::id();

        $articles = Article::withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $likedArticleIds = Like::where('user_id', $userId)->pluck('article_id')->toArray();

        foreach ($articles as $article) {
            $article->liked = in_array($article->id, $likedArticleIds);
        }

        return response()->json([
            'status' => 'success',
            'articles' => $articles,
        ]);
    }

    public function show($id) {
        $userId = Auth::id();
        $article = Article::with('comments')->where('id', $id)->first();

        if ($article !== null) {

            $likeCount = $article->likes()->count();

            $liked = Like::where('article_id', $id)->where('user_id', $userId)->exists();

            return response()->json([
                'status' => 'success',
                'article' => $article,
                'liked' => $liked,
                'like_count' => $likeCount
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Такого поста не существует'
            ], 404);
        }
    }
}

