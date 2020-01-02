<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Rating extends Model
{
    
    protected $fillable = ['id', 'score', 'comment', 'user_id', 'article_id'];

    public static function totalUserRatings(){
        return count(Rating::where('user_id', Auth::user()->id)->get());
    }

    public static function userRatings(){
    	$ratings = Rating::orderBy('id', 'DESC')->where('user_id', Auth::user()->id)->paginate(4);
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

    public static function getReviews($article)
    {
        return Rating::where('article_id', $article)->get();
    }

    public static function articleAverageRating($article){
        $total = Rating::where('article_id', $article)->sum('score');
        $count = Rating::where('article_id', $article)->count();
        $avgAssessment = $total/$count;
        return $avgAssessment;
    }

    public function averageRating(){
        return $this->ratings()->avg('rating');
    }

    public function sumRating(){
        return $this->ratings()->sum('rating');
    }

    public function userAverageRating(){
        return $this->ratings()->where('user_id', \Auth::id())->avg('rating');
    }

    public function userSumRating(){
        return $this->ratings()->where('user_id', \Auth::id())->sum('rating');
    }

    public function ratingPercent($max = 5){
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();
        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }
}
