<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     *
     */

    use DatabaseMigrations;

    public function test_guets_cannot_favorite_anything(){
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('replies/1/favorites')
            ->assertRedirect('/login');

    }

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');

        //If I post to a favorite endpoint

        $this->post('replies/'.$reply->id.'/favorites');

        // It should be in the database

        $this->assertCount(1,$reply->favorites);
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once(){

        $this->signIn();
        $reply = create('App\Reply');

        //If I post to a favorite endpoint

        $this->post('replies/'.$reply->id.'/favorites');
        $this->post('replies/'.$reply->id.'/favorites');

        // It should be in the database

        $this->assertCount(1,$reply->favorites);

    }


}
