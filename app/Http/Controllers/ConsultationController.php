<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\HistoryResource;

class ConsultationController extends Controller
{
    //
    public function consultation($id) {
        $data =  Consultation::findOrFail($id);
        return response()->json([
            'data' => new ConsultationResource($data)
        ]);
    }
}
