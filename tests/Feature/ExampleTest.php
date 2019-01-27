<?php

namespace Tests\Feature;

use App\Photo;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllPhotos() {

        $data = [];

        $photos = factory(Photo::class, 3)->create();

        $response = $this->json('GET', '/api/photos');

        foreach ($photos as $photo) {
            array_push($data, [
                'name' => $photo->name,
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
            'name' => 'new avatar',
            'photo' => $file,
        ]);

        // Storage::disk('local')->assertExists('avatars/' . $file->hashName());
         
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'new avatar',
                    'description' => null,
                    'photo' => 'avatars/' . $file->hashName(),
                    'id' => 1
                ]
            ]);
    }

    public function testGetPhoto() {

        $photo = factory(Photo::class)->create();

        $response = $this->json('GET', '/api/photos/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $photo->name,
                    'description' => $photo->description,
                    'photo' => $photo->photo,
                    'id' => 1
                ]
            ]);
    }

    public function testEditPhotoName() {

        $photo = factory(Photo::class)->create();

        $response = $this->json('GET', '/api/photos/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $photo->name,
                    'description' => $photo->description,
                    'photo' => $photo->photo,
                    'id' => 1
                ]
            ]);

        $response = $this->json('PATCH', '/api/photos/1', [
            'name' => 'new name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'new name',
                    'description' => $photo->description,
                    'photo' => $photo->photo,
                    'id' => 1
                ]
            ]);
    }
}
