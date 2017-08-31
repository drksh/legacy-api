<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateShortLinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_shorten_a_url()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('POST', '/', [
            'type' => 'url',
            'body' => 'https://example.com',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'url',
                'body' => 'https://example.com',
                'url' => url('/a'),
            ]);

        $this->assertDatabaseHas('submissions', [
            'slug' => 'a',
        ]);
        $this->assertDatabaseHas('urls', [
            'body' => 'https://example.com',
        ]);
    }
}
