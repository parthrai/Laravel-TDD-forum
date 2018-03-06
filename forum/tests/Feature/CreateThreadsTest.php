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

            $thread = make('App\Thread'); // simplyfying the above line

            $response = $this->post('/threads',$thread->toArray());


        // then, when we visit the thread page
            $this->get($response->headers->get('Location'))


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

    function test_a_thread_requires_a_title(){

        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }


    function test_a_thread_requires_a_valid_channel(){

        factory('App\Channel',2)->create();

        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = []){

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->signIn();

        $thread = make('App\Thread',['title'=>null]);



       return $this->post('/threads',$thread->toArray());


    }


}
