<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

//    public function __construct(){
//        $this->middleware('jwt.auth');
//    }

    public function index(Request $request) {
        $page = $request->get('page', 1);
        $articles = Article::withCount(['likes', 'comments'])
            ->paginate(13, ['*'], 'page', $page);

        return response()->json([
            'status'=>'success',
            'articles' => $articles
        ]);
    }
}

