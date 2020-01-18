<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
	/** @test */
	public function it_loads_the_login_page() 
	{
	  $this->get('/login')
	    ->assertStatus(200)
	    ->assertSee('Login');
	}

    /** @test */
	public function authentication_user_test() 
	{
		$user = User::create([
			'first_name'  => 'New_User',
            'last_name'   => 'For_Test',
            'email'       => 'test@mail.com',
            'password'    => bcrypt('root92'),
            'address'     => 'test_address',
            'city'        => 'test_city',
            'postal_code' => '12345',
            'telephone'   => '012345678',
            'role'        => 'User'
        ]);

		$credentials = [
			'email' => 'test@mail.com',
			'password' => 'root92'
		];

		$response = $this->post('/login', $credentials);

		$response->assertRedirect('/');
	}

	/** @test */
	public function not_authenticate_with_invalid_credentials()
	{
		$credentials = [
			"email" => "test_fail@mail.com",
			"password" => "root"
		];
		$response = $this->post('/login', $credentials);

		$response->assertSessionHasErrors(['email' => 'These credentials do not match our records.']);
	}

	/** @test */
	public function email_and_password_are_required_for_authenticate()
	{
		$credentials = [
			'email' => null,
			'password' => null
		];

		$response = $this->post('/login', $credentials);

		$response->assertSessionHasErrors([
			'email' => 'The email field is required.',
			'password' => 'The password field is required.'
		]);
	}
}

