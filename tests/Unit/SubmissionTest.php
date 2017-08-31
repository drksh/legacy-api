<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Submission;
use App\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Snippet;
use App\File;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_slug_based_on_its_id()
    {
        $submissionA = factory(Submission::class)->create();
        $submissionB = factory(Submission::class)->create();
        $submissionC = factory(Submission::class)->create();

        $this->assertEquals(1, $submissionA->id);
        $this->assertEquals('a', $submissionA->slug);
        $this->assertDatabaseHas('submissions', ['slug' => 'a']);

        $this->assertEquals(2, $submissionB->id);
        $this->assertEquals('b', $submissionB->slug);
        $this->assertDatabaseHas('submissions', ['slug' => 'b']);

        $this->assertEquals(3, $submissionC->id);
        $this->assertEquals('c', $submissionC->slug);
        $this->assertDatabaseHas('submissions', ['slug' => 'c']);
    }

    /** @test */
    public function it_can_be_a_short_url()
    {
        $submission = factory(Submission::class, 'url')->create();

        $this->assertInstanceOf(Url::class, $submission->content);
        $this->assertEquals($submission->content->id, $submission->content_id);
        $this->assertEquals('url', $submission->content_type);
    }

    /** @test */
    public function it_can_be_a_text_snippet()
    {
        $submission = factory(Submission::class, 'snippet')->create();

        $this->assertInstanceOf(Snippet::class, $submission->content);
        $this->assertEquals($submission->content->id, $submission->content_id);
        $this->assertEquals('snippet', $submission->content_type);
    }

    /** @test */
     public function it_can_be_a_file_upload()
    {
        $submission = factory(Submission::class, 'file')->create();
        $this->assertInstanceOf(File::class, $submission->content);
        $this->assertEquals($submission->content->id, $submission->content_id);
        $this->assertEquals('file', $submission->content_type);
    }
}
