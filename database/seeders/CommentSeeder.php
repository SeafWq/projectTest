<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();

        foreach ($articles as $article){
            for ($j = 0; $j < rand(5, 10); $j++){
                Comment::create([
                    'article_id'=>$article->id,
                    'text'=>'Comment'.($j+1).'for article '. $article->id
                ]);
            }
        }
    }
}
