<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultantForumResource extends JsonResource
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
            'user_name' => $this->user->name,
            'consultant_id' => $this->user_id,
            'is_ended' => $this->is_ended,
            'time' => Carbon::parse($this->created_at)->format('d m Y'),
            'message' => MessageResource::collection($this->message)
        ];
    }
}
