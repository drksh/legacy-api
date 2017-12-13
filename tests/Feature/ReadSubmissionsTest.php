<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Submission;

class ReadSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_is_able_to_read_a_submission()
    {
        $submission = factory(Submission::class)->create();

        $response = $this->json('GET', url($submission->slug));

        $response->assertStatus(200)
            ->assertJson([
                'type' => $submission->content_type,
                'body' => $submission->content->body,
            ]);
    }
}
