<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['id', 'score', 'comment', 'user_id', 'article_id'];
}
