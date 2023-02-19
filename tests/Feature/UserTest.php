<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_an_unauthenticated_user_cannot_view_messages(): void
    {
        $response = $this->get('messages');

        $response->assertRedirectToRoute('login');

        $john = User::factory()->create();

        $this->be($john);

        $response = $this->get('messages');

        $response->assertStatus(200);
    }

    public function test_a_message_belongs_to_a_user(){
        $john = User::factory()->create();

        $this->be($john);

        dd(Auth::user()->name);
    }
}
