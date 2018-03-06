<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory('App\Thread')->create();

    }

    public function test_a_user_can_view_all_threads()
    {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);



    }

    function test_a_user_can_read_a_single_thread(){

        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->title);
    }

    function test_a_user_can_read_replies_that_are_associated_with_a_thread(){


        $reply= factory('App\Reply')->create(['thread_id'=>$this->thread->id]);

        //when we visit the thread page
        //we should see the reply

        $response= $this->get($this->thread->path())
            ->assertSee($reply->body);

    }



    function test_a_thread_belongs_to_a_channel(){

        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
}
