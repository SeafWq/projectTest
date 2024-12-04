<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $articles = Article::all();
        $users = User::all();

        foreach ($articles as $article) {
            $likeCount = rand(100, 1000);

            for ($i = 0; $i < $likeCount; $i++) {
                $user = $users->random();

                Like::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id,
                ]);
            }
        }
    }
}
