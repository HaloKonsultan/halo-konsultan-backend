<?php

namespace App\Http\Resources;

use App\ConsultantDocumentation;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultantResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'description' => $this->description,
            'location' => $this->location,
            'photo' => $this->photo,
            'likes_total' => $this->likes_total,
            'chat_price' => $this->chat_price,
            'consultation_price' => $this->consultation_price,
            'firebase_id' => $this->firebase_id,
            'position' => $this->category->name ?? '',
            'consultant_documentation' => ConsultantDocumentationResource::collection($this->documentation),
            'consultant_education' => ConsultantEducationResource::collection($this->educations),
            'consultant_skill' => ConsultantSkillResource::collection($this->skills),
            'consultant_virtual_accounts' => ConsultantVirtualAccountResource::collection($this->virtualAccount),
            'consultant_experience' => ConsultantExperienceResource::collection($this->experience)
        ];
    }
}
