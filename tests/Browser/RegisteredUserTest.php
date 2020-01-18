<?php

namespace Tests\Browser;

use App\User;
use App\Rating;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisteredUserTest extends DuskTestCase
{
    public function testRegisterUser(){

        $user = User::find(20);

        $this->browse(function($browser) use ($user){
            $browser->visit('eGame/public/register')
            ->press('REGISTER')
            ->assertPathIs('/eGame/public/register')
            ->assertSee(
                'The first name field is required.',
                'The last name field is required.', 
                'The email field is required.',
                'The password field is required.',
                'The address field is required.',
                'The city field is required.',
                'The postal code field is required.',
                'The telephone field is required.')
            ->visit('eGame/public/register')
            ->type('password', 'root92')
            ->type('password_confirmation', 'root')
            ->press('REGISTER')
            ->assertPathIs('/eGame/public/register')
            ->assertSee('The password confirmation does not match.')
            ->visit('eGame/public/register')
            ->type('email', $user->email)
            ->press('REGISTER')
            ->assertPathIs('/eGame/public/register')
            ->assertSee('The email has already been taken.')
            ->visit('eGame/public/register')
            ->type('first_name', 'New_User')
            ->type('last_name', 'For_Test')
            ->type('email', 'test@mail.com')
            ->type('password', 'root92')
            ->type('password_confirmation', 'root92')
            ->type('address', 'Test Street 1')
            ->type('city', 'Test City')
            ->type('postal_code', '12345')
            ->type('telephone', '123456789')
            ->press('REGISTER')
            ->pause(2000)
            ->assertPathIs('/eGame/public/')
            ->assertSee('Top Ratings', 'Top Sales')
            ->assertDontSee('Recommendations based on your purchases...',
                        'Recommendations based on other similar users...');
        });
    }

    public function testUserCanSearchAndBuyAnArticle()
    {
        $user = User::all()->last();

        $this->browse(function ($browser) use ($user) {
            $browser->visit('eGame/public/login')
                    ->type('email', $user->email)
                    ->type('password', 'root92')
                    ->press('LOGIN')
                    ->assertPathIs('/eGame/public/')
                    ->type('search', 'God of War')
                    ->press('SearchButton')
                    ->assertSee('Results with "God of War"')
                    ->press('Add to cart')
                    ->visit('/eGame/public/cart')
                    ->assertSee('Your shopping cart')
                    ->clickLink('Checkout')
                    ->type('recipient_name', 'User Name')
                    ->type('line1', 'Test Street 2')
                    ->type('city', 'Test City')
                    ->type('postal_code', '12345')
                    ->type('state', 'Test Province')
                    ->type('country_code', 'Test Country Code')
                    ->press('Continue')
                    ->assertPathIs('/eGame/public/payment_method')
                    ->press('PayPalButton')
                    ->waitForText('Your payment was procesed successfully!', 45);
        });
    } 

    public function testUserCanSeeRecommendations(){
        $user = User::all()->last();

        Rating::create([
            'score' => 5,
            'article_id' => 1,
            'user_id' => $user->id
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('eGame/public/login')
                    ->type('email', $user->email)
                    ->type('password', 'root92')
                    ->press('LOGIN')
                    ->assertPathIs('/eGame/public/')
                    ->assertSee('Recommendations based on your purchases...',
                        'Recommendations based on other similar users...');
        });
    } 
}

