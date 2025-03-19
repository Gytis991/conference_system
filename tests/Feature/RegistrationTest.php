<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    /** @test */
    public function client_can_register_for_a_conference()
    {
        $client = User::factory()->create(['roles' => 'client']);
        $conference = Conference::factory()->create(['start_date' => now()->addDays(5)]);

        $response = $this->actingAs($client)->post(route('registrations.create'), ['conference_id' => $conference->id]);

        $response->assertRedirect();
        $this->assertDatabaseHas('registrations', [
            'user_id' => $client->id,
            'conference_id' => $conference->id,
            'status' => 'confirmed'
        ]);
    }

    /** @test */
    public function client_cannot_register_for_a_past_conference()
    {
        $client = User::factory()->create(['roles' => 'client']);
        $conference = Conference::factory()->create(['start_date' => now()->subDays(2)]);

        $response = $this->actingAs($client)->post(route('registrations.create'), ['conference_id' => $conference->id]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('registrations', ['user_id' => $client->id, 'conference_id' => $conference->id]);
    }

    /** @test */
    public function client_can_cancel_registration()
    {
        $client = User::factory()->create(['roles' => 'client']);
        $conference = Conference::factory()->create(['start_date' => now()->addDays(5)]);
        $conference->users()->attach($client->id, ['status' => 'confirmed']);

        $response = $this->actingAs($client)->patch(route('registrations.cancel', $conference->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('registrations', [
            'user_id' => $client->id,
            'conference_id' => $conference->id,
            'status' => 'cancelled'
        ]);
    }

    /** @test */
    public function client_cannot_cancel_registration_for_a_past_conference()
    {
        $client = User::factory()->create(['roles' => 'client']);
        $conference = Conference::factory()->create(['start_date' => now()->subDays(2)]);
        $conference->users()->attach($client->id, ['status' => 'confirmed']);

        $response = $this->actingAs($client)->patch(route('registrations.cancel', $conference->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('registrations', [
            'user_id' => $client->id,
            'conference_id' => $conference->id,
            'status' => 'confirmed' // Should remain confirmed
        ]);
    }
}
