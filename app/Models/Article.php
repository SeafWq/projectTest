<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_path',
        'text_article',
    ];

    public function likes() {
        return $this->hasMany(Like::class, 'article_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
