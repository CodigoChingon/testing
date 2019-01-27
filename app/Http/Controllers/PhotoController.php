<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Http\Requests\PhotoCreateRequest;
use App\Http\Requests\PhotoUpdateRequest;
use App\Http\Resources\Photo as PhotoResource;
use App\Http\Resources\PhotoCollection as PhotoResourceCollection;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PhotoResourceCollection(Photo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhotoCreateRequest $request)
    {
        $path_photo = $request->photo->store('avatars');
        
        $photo = Photo::create([
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $path_photo,
        ]);

        return new PhotoResource($photo);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return new PhotoResource($photo);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(PhotoUpdateRequest $request, Photo $photo)
    {
        $photo->name = ($request->name) ? $request->name : $photo->name;
        $photo->description = ($request->description) ? $request->description : $photo->description;
        $photo->save();

        return new PhotoResource($photo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
