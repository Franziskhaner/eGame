<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Rating extends Model
{
    protected $fillable = ['id', 'score', 'comment', 'user_id', 'article_id'];

    public static function userRatings(){
    	$ratings = Rating::where('user_id', Auth::user()->id)->get();
    	return $ratings;
    }

    public static function userComments(){
    	$ratings = Rating::where('user_id', Auth::user()->id)->get();

    	$comments = array();

    	foreach ($ratings as $rating) {
    		if($rating->comment)
    			$comments[] = $rating->comment;
    	}
    	return $comments;
    }
}
