<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'external_id' => $this->external_id,
            'status_invoice'=> $this->status_invoice,
            'status_disbursment' => $this->status_disbursment, 
            'amount' => $this->amount,
            'invoice_url' => $this->invoice_url, 
            'expiry_date' => $this->expiry_date,
            'bank_code' => $this->bank_code, 
            'account_holder_name' => $this->account_holder_name, 
            'account_number' => $this->account_number
        ];
    }
}
