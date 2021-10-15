<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserConsultationResource extends JsonResource
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
            'description' => $this->description,
            'title' => $this->title,
            'consultation_price' => $this->consultation_price,
            'location' => $this->location,
            'status' => $this->status,
            'is_confirmed' => $this->is_confirmed,
            'date' => $this->date,
            'time' => $this->time,
            'conference_link' => $this->conference_link,
            'preference' => $this->preference,
            'consultant' => [
                'id' => $this->consultant->id ?? '',
                'name' => $this->consultant->name ?? '',
                'position' => $this->consultant->category->name ?? '',
                'photo' => $this->consultant->photo ?? ''
            ],
            'transaction' => new TransactionResource($this->transaction),
            'consultation_document' => ConsultationDocumentResource::collection($this->document),
            'consultation_preference_date' => ConsultationPreferenceDateResource::collection($this->preferenceDate)
        ];
    }
}
