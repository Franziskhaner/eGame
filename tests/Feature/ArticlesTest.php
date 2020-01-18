<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticlesTest extends TestCase
{
    /**
     @test
     */
    public function show_an_article_with_recommendations()
    {
            $article = new Article;

            $article->name = 'Action Game';
            $article->price = '45';
            $article->quantity = '50';
            $article->release_date = '2020-01-11';
            $article->players_num = '2';
            $article->gender = 'Action';
            $article->platform = 'PC';
            $article->description = 'This is the perfect game for an action man!';
            $article->assessment = '5.0';

            $article->save();

            $response = $this->get('articles/'.$article->id)->assertSee('Action Game');
    }
}
