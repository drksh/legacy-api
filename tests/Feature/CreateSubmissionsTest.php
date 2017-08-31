<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_shorten_a_url()
    {
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

    /** @test */
    public function user_can_create_a_snippet()
    {
        $response = $this->json('POST', '/', [
            'type' => 'snippet',
            'body' => 'Example snippet.',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'snippet',
                'body' => 'Example snippet.',
                'url' => url('/a'),
            ]);

        $this->assertDatabaseHas('submissions', [
            'slug' => 'a',
        ]);
        $this->assertDatabaseHas('snippets', [
            'body' => 'Example snippet.',
        ]);
    }

    /** @test */
    public function user_can_upload_a_file()
    {
        $this->withoutExceptionHandling();

        Storage::fake('void');
        $fakeFile = UploadedFile::fake()->create('myfile.txt', 1);

        $response = $this->json('POST', '/', [
            'type' => 'file',
            'body' => $fakeFile,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'file',
                'body' => Storage::disk('void')->url($fakeFile->hashName()),
                'url' => url('/a'),
            ]);

        Storage::disk('void')->assertExists($fakeFile->hashName());
        $this->assertDatabaseHas('submissions', [
            'slug' => 'a',
        ]);
        $this->assertDatabaseHas('files', [
            'body' => Storage::disk('void')->url($fakeFile->hashName()),
        ]);
    }
}
