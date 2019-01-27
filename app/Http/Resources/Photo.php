<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Photo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'photo' => $this->photo,
            'id' => $this->id,
        ];
    }
}
