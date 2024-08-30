<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Template;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        Template::create([
            'template' => '[]',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
