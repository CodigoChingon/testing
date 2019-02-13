<?php

namespace Tests\Feature;

use App\Photo;
use Tests\TestCase;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllPhotos() {
        $photos = factory(Photo::class, 3)->create();

        $data = [];

        $response = $this->json('GET', '/api/photos');

        foreach($photos as $photo) {
            array_push( $data, [
                'title' => $photo->title,
                'description' => $photo->description,
                'photo' => $photo->photo,
                'id' => $photo->id
            ]);
        }

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $data
            ]);
    }

    public function testUploadPhoto() {
        
        Storage::fake('local');

        $file = UploadedFile::fake()->image('avatar.jpg', 100, 200);
        
        $response = $this->json('POST', '/api/photos',[
            'title' => 'new avatar',
            'photo' => $file,
        ]);
         
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'new avatar',
                    'description' => null,
                    'photo' => 'avatars/' . $file->hashName(),
                    'id' => 1
                ]
            ]);
    }
}
