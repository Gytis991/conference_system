<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConferenceTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function admin_can_create_a_conference()
    {
        $admin = User::factory()->create(['roles' => 'admin']);

        $conferenceData = [
            'title' => 'Tech Conference',
            'organizer' => 'Tech Corp',
            'description' => 'A conference about the latest in technology.',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
        ];

        $response = $this->actingAs($admin)->post(route('conferences.create'), $conferenceData);

        $response->assertRedirect();
        $this->assertDatabaseHas('conferences', ['title' => 'Tech Conference']);
    }

    /** @test */
    public function non_admin_cannot_create_a_conference()
    {
        $user = User::factory()->create(['roles' => 'client']);

        $conferenceData = [
            'title' => 'Unauthorized Conference',
            'organizer' => 'Unknown',
            'description' => 'Unauthorized attempt',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
        ];

        $response = $this->actingAs($user)->post(route('conferences.create'), $conferenceData);

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_a_conference()
    {
        $admin = User::factory()->create(['roles' => 'admin']);
        $conference = Conference::factory()->create();

        $updateData = [
            'title' => 'Updated Conference',
            'organizer' => 'Updated Organizer',
            'description' => 'Updated description',
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(12)->toDateString(),
        ];

        $response = $this->actingAs($admin)->patch(route('conferences.update', $conference->id), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('conferences', ['title' => 'Updated Conference']);
    }

    /** @test */
    public function admin_can_cancel_a_conference()
    {
        $admin = User::factory()->create(['roles' => 'admin']);
        $conference = Conference::factory()->create(['status' => 'active']);

        $response = $this->actingAs($admin)->patch(route('conferences.cancel', $conference->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('conferences', ['id' => $conference->id, 'status' => 'cancelled']);
    }
}
