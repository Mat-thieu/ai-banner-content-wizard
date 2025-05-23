<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentWizardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/content-wizard')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_content_wizard(): void
    {
        $this->actingAs($user = User::factory()->create());

        $this->get('/content-wizard')->assertStatus(200);
    }
}
