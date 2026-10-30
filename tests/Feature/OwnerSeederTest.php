<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OwnerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Tests\TestCase;

class OwnerSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'owner.name' => 'Portfolio Owner',
            'owner.email' => 'OWNER@example.test',
            'owner.password' => 'chosen-owner-password',
        ]);
    }

    public function test_owner_is_seeded_with_a_hashed_password_and_can_log_in(): void
    {
        $this->seed(OwnerSeeder::class);

        $owner = User::sole();
        $this->assertTrue($owner->is_owner);
        $this->assertSame('owner@example.test', $owner->email);
        $this->assertNotNull($owner->email_verified_at);
        $this->assertNotSame('chosen-owner-password', $owner->password);
        $this->assertTrue(Hash::check('chosen-owner-password', $owner->password));

        $this->post('/login', [
            'email' => $owner->email,
            'password' => 'chosen-owner-password',
        ])->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($owner);
        $this->get('/dashboard')->assertOk();
    }

    public function test_repeated_seeding_preserves_profile_and_password_changes_without_bootstrap_credentials(): void
    {
        $this->seed(OwnerSeeder::class);
        User::sole()->update([
            'name' => 'Updated owner',
            'email' => 'updated@example.test',
            'password' => Hash::make('updated-owner-password'),
        ]);
        config(['owner.email' => null, 'owner.password' => null]);

        $this->seed(OwnerSeeder::class);

        $owner = User::sole();
        $this->assertSame('Updated owner', $owner->name);
        $this->assertSame('updated@example.test', $owner->email);
        $this->assertTrue(Hash::check('updated-owner-password', $owner->password));
    }

    public function test_matching_existing_account_is_promoted_without_creating_a_duplicate(): void
    {
        $existing = User::factory()->create(['email' => 'Owner@example.test']);

        $this->seed(OwnerSeeder::class);

        $owner = User::sole();
        $this->assertSame($existing->id, $owner->id);
        $this->assertTrue($owner->is_owner);
        $this->assertTrue(Hash::check('chosen-owner-password', $owner->password));
        $this->assertNull($owner->remember_token);
    }

    public function test_missing_bootstrap_password_cannot_create_an_owner(): void
    {
        config(['owner.password' => null]);

        try {
            $this->seed(OwnerSeeder::class);
            $this->fail('An initial owner must have an explicitly configured password.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('password', $exception->errors());
        }

        $this->assertDatabaseCount('users', 0);
    }

    public function test_multiple_existing_owners_are_rejected(): void
    {
        User::factory()->owner()->count(2)->create();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('More than one owner account exists.');

        $this->seed(OwnerSeeder::class);
    }
}
