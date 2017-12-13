<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function updating_a_resource_is_not_implemented()
    {
        $url = url('/a');

        $response = $this->json('PATCH', $url, []);

        $response->assertStatus(501)
            ->assertJson([
                'message' => 'Sorry, not implemented.',
            ]);
    }
}
