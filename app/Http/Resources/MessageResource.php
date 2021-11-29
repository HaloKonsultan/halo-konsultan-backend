<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender' => $this->sender,
            'message' => $this->message,
            'is_read' => $this->is_read,
            'time' => Carbon::parse($this->created_at)->format('H:i')
        ];
    }
}
