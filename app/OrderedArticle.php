<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedArticle extends Model
{
    protected $fillable = ['quantity', 'order_id', 'article_id'];

    public static function orderedArticleCount($article){
    	return OrderedArticle::where('article_id', $article)->sum('quantity');
    }
}
