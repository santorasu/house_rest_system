<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('requires authentication to update profile', function () {
    postJson('/api/user/profile', [
        'phone' => '1234567890',
    ])->assertUnauthorized();
});

it('updates profile and marks as incomplete if missing fields', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson('/api/user/profile', [
        'phone' => '1234567890',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.phone', '1234567890')
        ->assertJsonPath('data.is_profile_completed', false);

    $this->assertDatabaseHas('user_profiles', [
        'user_id' => $user->id,
        'phone' => '1234567890',
        'is_profile_completed' => false,
    ]);
});

it('updates profile and marks as complete when required fields are present', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson('/api/user/profile', [
        'phone' => '1234567890',
        'address' => '123 Main St, Springfield',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.phone', '1234567890')
        ->assertJsonPath('data.address', '123 Main St, Springfield')
        ->assertJsonPath('data.is_profile_completed', true);

    $this->assertDatabaseHas('user_profiles', [
        'user_id' => $user->id,
        'phone' => '1234567890',
        'address' => '123 Main St, Springfield',
        'is_profile_completed' => true,
    ]);
});

it('validates profile data', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson('/api/user/profile', [
        'phone' => str_repeat('1', 25), // Too long
        'avatar_url' => 'not-a-url', // Invalid URL
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['phone', 'avatar_url']);
});
