<?php

namespace Tests\Feature;

use App\User;
use App\Rating;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRateGameTest extends TestCase
{
    /** @test */
    public function user_can_rate_a_game()
    {
    	$rating   = new Rating;

        $this->get('rate_your_order/Super Mario Party')->assertSee('Rate your purchased games', 'title')->assertSee('Price:', '60.00', 'Gender:', 'Minigames', 'Platform:', 'NINTENDO SWITCH', 'Release Date: 2018-10-05', 'body');

        $rating = [
        	'user_id'    => '48',
            'score'      => '4',
            'comment'    => 'A comment for rate this game',
            'article_id' => '105'
        ];

        $response = $this->post('ratings', $rating);

        $user = User::find($rating['user_id']);

        if($user->role == 'User')
        	 $response->assertRedirect('your_ratings');
    }
}
