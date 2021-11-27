<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
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
            'id' => $this->id,
            'consultant_name' => $this->consultant->name,
            'consultant_photo' => $this->consultant->photo,
            'consultant_category' => $this->consultant->category->name,
            'user_id' => $this->user_id,
            'is_ended' => $this->is_ended,
            'message' => MessageResource::collection($this->message)
        ];
    }
}
