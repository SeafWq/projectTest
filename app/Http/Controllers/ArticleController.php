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
            if ($article->image_path !== null) {
                $article->image_path = asset('storage/' . $article->image_path);
            }
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
            $commentCount = $article->comments()->count();

            $liked = Like::where('article_id', $id)->where('user_id', $userId)->exists();
            if ($article->image_path !== null) {
                $article->image_path = asset('storage/' . $article->image_path);
            }

            return response()->json([
                'status' => 'success',
                'article' => $article,
                'liked' => $liked,
                'like_count' => $likeCount,
                'comments_count'=>$commentCount,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Такого поста не существует'
            ], 404);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'nameArticle'=> 'required|string|max:255',
            'imagePath'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'textArticle'=> 'required|string|max:2048'
        ]);
        $imagePath = $request->file('imagePath')->store('images', 'public');

        $article = Article::create([
            'user_id' => Auth::id(),
            'name_article'=>$request->nameArticle,
            'text_article'=>$request->textArticle,
            'image_path'=>$imagePath
        ]);

        return response()->json([
            'status'=>'success',
            'article'=>$article
        ]);
    }
}

