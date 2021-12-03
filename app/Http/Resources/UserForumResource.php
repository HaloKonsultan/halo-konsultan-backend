<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserForumResource extends JsonResource
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
            'name' => $this->consultant->name,
            'photo' => $this->consultant->photo,
            'category' => $this->consultant->category->name,
            'user_id' => $this->user_id,
            'consultant_id' => $this->consultant_id,
            'is_ended' => $this->is_ended,
            'time' => Carbon::parse($this->created_at)->format('d m Y'),
            'message' => MessageResource::collection($this->message)
        ];
    }
}
