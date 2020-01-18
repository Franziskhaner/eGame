<?php

namespace Tests\Browser;

use App\Article;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminUserTest extends DuskTestCase
{
    public function testAdminCanSeeRecommendations()
    {
        $user = User::where('role', 'Admin')->first();

        $this->browse(function ($browser) use ($user){
            $browser->visit('eGame/public/login')
                    ->type('email', $user->email)
                    ->type('password', 'root92')
                    ->press('LOGIN')
                    ->assertPathIs('/eGame/public/')
                    ->assertSee('Admin Panel')
                    ->clickLink('Show Recommendations')
                    ->assertPathIs('/eGame/public/recommendations')
                    ->assertSee('Recommendations based on your purchases...',
                        'Recommendations based on other similar users...');;
        });
    }

    public function testAdminCanManageCRUD()
    {
        $user = User::where('role', 'Admin')->first();

        $this->browse(function ($browser) use ($user){
            $browser->visit('eGame/public/login')
                    ->type('email', $user->email)
                    ->type('password', 'root92')
                    ->press('LOGIN')
                    ->clickLink('Articles')
                    ->assertPathIs('/eGame/public/articles')
                    ->clickLink('add')
                    ->assertPathIs('/eGame/public/articles/create')
                    ->type('name', 'New article for testing')
                    ->type('price', 50)
                    ->type('quantity', 100)
                    ->type('release_date', '13-01-2020')
                    ->type('players_number', 2)
                    ->select('gender', 'Adventure')
                    ->select('platform', 'PC')
                    ->type('description', 'This is the best game of history...')
                    ->select('assessment', 5.0)
                    ->press('SAVE')
                    ->assertSee('Article created successfully!')
                    ->type('crud_search', 'New article for testing')
                    ->press('searchButton')
                    ->assertPathIs('/eGame/public/articles/crud_search?crud_search=New+article+for+testing')
                    ->press('edit')
                    ->assertPathIs('/eGame/public/articles/'.Article::all()->last()->id.'edit')
                    ->type('name', 'Article Edited')
                    ->press('SAVE')
                    ->assertSee('Article edited successfully!')
                    ->type('crud_search', 'Article Edited')
                    ->press('searchButton')
                    ->press('delete')
                    ->waitForText('Are you sure to delete?')
                    ->press('Aceptar')
                    ->assertSee('Article deleted successfully!');              
        });
    }
}
