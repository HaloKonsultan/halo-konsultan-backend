<?php

namespace App\Http\Resources;

use App\ConsultationDocument;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
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
            'conference_link' => $this->conference_link,
            'preference' => $this->preference,
            'transaction' => TransactionResource::collection($this->transaction),
            'consultation_preference_date' => ConsultationPreferenceDateResource::collection($this->preferenceDate),
            'consultation_document' => ConsultationDocumentResource::collection($this->document)
        ];
    }
}
