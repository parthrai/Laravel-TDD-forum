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

        $this->signIn();


        // When we hit the endpoint to create new thread
            //$thread = factory('App\Thread')->make();

            $thread = create('App\Thread'); // simplyfying the above line

            $this->post('/threads',$thread->toArray());

        // then, when we visit the thread page
            $this->get($thread->path())


        // we shoud see the new thread

            ->assertSee($thread->title)
                    ->assertSee($thread->body);
    }

    function test_guests_may_not_create_threads(){

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');

    }


}
