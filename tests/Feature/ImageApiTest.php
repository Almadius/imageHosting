<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Image;

class ImageApiTest extends TestCase
{
    use RefreshDatabase;

    public function testGetImageById()
    {
        $image = Image::create([
            'name' => 'testimage.jpg',
            'uploaded_at' => now(),
        ]);

        $response = $this->getJson("/api/images/{$image->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $image->id,
                'name' => $image->name,
            ]);
    }

    public function testGetImageByInvalidId()
    {
        $response = $this->getJson('/api/images/999');

        $response->assertStatus(404)
            ->assertJson(['error' => 'Image not found']);
    }
}
