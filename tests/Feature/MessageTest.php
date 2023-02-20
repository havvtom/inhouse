<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Message;
use Database\Factories\MessageFactory;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_an_unauthenticated_user_cannot_view_messages(): void
    {
        // the middleware is in the controller to block unauthenticated users

        $response = $this->get('messages');

        $response->assertRedirectToRoute('login');

        $john = User::factory()->create();

        $this->be($john);

        $response = $this->get('messages');

        $response->assertStatus(200);
    }

    public function test_only_an_authenticated_user_can_send_messages(){
        
        //send a message without login in
        //user  should be redirected to the login page
        $message = Message::factory()->make();

        $response = $this->post('/messages', [$message]);

        $response->assertRedirect('login');

        //send a message after loggin in
        $john = User::factory()->create();

        $this->be($john);

        $response = $this->post('/messages', [$message]);

        $response->assertSuccessful();

    }

    public function test_a_message_without_a_subject_cannot_be_sent(){
        //login a user
        $john = User::factory()->create();

        $this->be($john);
        //send a message without a subject
        $message = Message::factory()->make([
           'subject' => '', 
        ]);
        //post the message
        $response = $this->post('/messages', [$message]);
        //the user should get an error
        $response->assertSessionHasErrors([
            'subject' => 'The subject field is required.'
        ]);
    }

    public function test_a_message_without_message_content_cannot_be_sent(){
        //login a user
        $john = User::factory()->create();

        $this->be($john);

        //send a message without a message body
        $message = Message::factory()->make([
           'message' => '', 
        ]);

        //post the message
        $response = $this->post('/messages', [$message]);
        
        //the user should get an error
        $response->assertSessionHasErrors([
            'message' => 'The message field is required.'
        ]);
    }

    public function test_authenticated_users_can_send_messages(){
        //login a user
        $john = User::factory()->create();

        $this->be($john);
        //send a message
        
        $m1 = Message::factory()->raw([
            'created_by_id' => $john->id
        ]);

        $this->post('/messages', $m1);
        //the message should be created in the database

        $this->assertDatabaseHas('messages', [
            'created_by_id' => $john->id
        ]);
    }
    
}
