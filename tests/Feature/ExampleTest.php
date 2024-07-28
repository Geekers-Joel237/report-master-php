<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Core\Shared\Infrastructure\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        User::factory(10)->create();
        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertCount(10, User::all());
    }
}
