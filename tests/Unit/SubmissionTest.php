<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Submission;
use App\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Snippet;
use App\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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

    /** @test */
    public function it_can_create_the_appropriate_resource_based_on_given_type()
    {
        $urlSubmission = Submission::createFromType('url', [
            'body' => 'https://example.com',
        ]);
        $this->assertInstanceOf(Url::class, $urlSubmission->content);
        $this->assertEquals('https://example.com', $urlSubmission->content->body);

        $snippetSubmission = Submission::createFromType('snippet', [
            'body' => 'Example snippet.',
        ]);
        $this->assertInstanceOf(Snippet::class, $snippetSubmission->content);
        $this->assertEquals('Example snippet.', $snippetSubmission->content->body);

        Storage::fake('void');
        $fakeFile = UploadedFile::fake()->create('myFile.txt', 1);
        $fileSubmission = Submission::createFromType('file', [
            'body' => $fakeFile,
        ]);
        $this->assertInstanceOf(File::class, $fileSubmission->content);
        $this->assertEquals(
            Storage::disk('void')->url($fakeFile->hashName()),
            $fileSubmission->content->body
        );
    }
}
