<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_routes_are_not_registered(): void
    {
        $this->assertFalse(Route::has('register'));
        $this->assertFalse(Route::has('register.store'));
        $this->get('/register')->assertNotFound();
    }

    public function test_posting_registration_details_cannot_create_an_account(): void
    {
        $this->post('/register', [
            'name' => 'Uninvited user',
            'email' => 'uninvited@example.test',
            'password' => 'uninvited-password',
            'password_confirmation' => 'uninvited-password',
        ])->assertNotFound();

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_login_page_has_no_registration_link(): void
    {
        $this->get('/login')->assertOk()->assertDontSee('/register');
    }
}
