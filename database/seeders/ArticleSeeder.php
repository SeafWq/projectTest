<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user = User::first();

         for ($i = 0; $i < 15; $i++){
             $article = Article::create([
                 'text_article'=> 'Article_'.$i,
                 'like_count'=>rand(0, 3000),
                 'comment_count'=>rand(0, 250),
                 'user_id'=>$user->id
             ]);

             $this->call(CommentSeeder::class, ['article'=>$article]);
         }
    }
}
