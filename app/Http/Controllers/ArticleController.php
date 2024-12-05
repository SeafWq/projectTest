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
        $articles = Article::paginate(10);

        return response()->json([
            'status'=>'success',
            'articles' => $articles
        ]);
    }

    public function show($id){
        $article = Article::with('comments')->where('id', $id)->first();
        if ($article !== null) {
            return response()->json([
                'status'=>'success',
                'article'=>$article
            ]);
        } else {
            return response()->json([
                'status'=>'error',
                'error'=>'Такого поста не существует'
            ], 404);
        }
    }
}

