<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateArticleWithMiddleware()
    {
        $user = [
			      'first_name'  => 'New_User',
            'last_name'   => 'For_Test',
            'email'       => 'test@mail.com',
            'password'    => bcrypt('root92'),
            'address'     => 'test_address',
            'city'        => 'test_city',
            'postal_code' => '12345',
            'telephone'   => '012345678',
            'role'        => 'User'
        ];

        $response = $this->post('users/create', $user);
      	$response->assertRedirect('/users');
    }
}
