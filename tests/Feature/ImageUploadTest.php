<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Image;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function testImageUpload()
    {
        Storage::fake('public');

        $response = $this->post('/images/upload', [
            'images' => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.jpg'),
                UploadedFile::fake()->image('image3.jpg'),
                UploadedFile::fake()->image('image4.jpg'),
                UploadedFile::fake()->image('image5.jpg'),
            ],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/images');
        $this->assertEquals(5, Image::count());

        foreach (Image::all() as $image) {
            Storage::disk('public')->assertExists('images/'.$image->name);
            $this->assertMatchesRegularExpression('/^[a-z0-9-]+\.jpg$/', $image->name);
        }
    }
}
