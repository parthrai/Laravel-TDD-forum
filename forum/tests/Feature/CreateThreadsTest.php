<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     *
     */
     use DatabaseMigrations;

    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        //Given we have a signed in user
            $this->actingAs(factory('App\User')->create());


        // When we hit the endpoint to create new thread
            $thread = factory('App\Thread')->make();

            $this->post('/threads',$thread->toArray());

        // then, when we visit the thread page
            $this->get($thread->path())


        // we shoud see the new thread

            ->assertSee($thread->title)
                    ->assertSee($thread->body);
    }

    function test_guests_may_not_create_threads(){

        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $thread = factory('App\Thread')->make();

        $this->post('/threads',$thread->toArray());
    }
}
