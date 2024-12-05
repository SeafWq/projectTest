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

         for ($i = 0; $i < 200; $i++){
             $article = Article::create([
                 'name_article'=> 'Статья '.$i,
                 'text_article'=> 'I\'m a thing. But, like most politicians, he promised more than he could deliver. You won\'t have time for sleeping, soldier, not with all the bed making you\'ll be doing. Then we\'ll go with that data file! Hey, you add a one and two zeros to that or we walk! You\'re going to do his laundry? I\'ve got to find a way to escape. I\'m a thing. But, like most politicians, he promised more than he could deliver. You won\'t have time for sleeping, soldier, not with all the bed making you\'ll be doing. Then we\'ll go with that data file! Hey, you add a one and two zeros to that or we walk! You\'re going to do his laundry? I\'ve got to find a way to escape. I\'m a thing. But, like most politicians, he promised more than he could deliver. You won\'t have time for sleeping, soldier, not with all the bed making you\'ll be doing. Then we\'ll go with that data file! Hey, you add a one and two zeros to that or we walk! You\'re going to do his laundry? I\'ve got to find a way to escape.',
                 'like_count'=>rand(0, 300),
                 'watch_count'=>rand(100, 4000),
                 'comment_count'=>rand(0, 150),
                 'user_id'=>$user->id
             ]);

             $this->call(CommentSeeder::class, ['article'=>$article]);
         }
    }
}
