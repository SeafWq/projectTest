<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();
        $users = User::all();
        foreach ($articles as $article){
            for ($j = 0; $j < rand(0, 5); $j++){
                $user = $users->random();
                Comment::create([
                    'user_id'=>$user->id,
                    'article_id'=>$article->id,
                    'text'=>'Comment'.($j+1).'for article '. $article->id
                ]);
            }
        }
    }
}
