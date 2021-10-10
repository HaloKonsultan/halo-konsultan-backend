<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Http\Resources\UserConsultationResource;
use Illuminate\Http\Request;

class ConsultationPreferenceDateController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            
        ]]);

        $this->middleware('auth:api', ['only' => [
            'sendDate'
        ]]);
    }

    public function sendDate(Request $request, $id) {
        $this->validate($request,[
            'date' => ['string'],
            'time' => ['string']
        ]);

        $data = Consultation::findOrFail($id);
        $data->date = $request->date;
        $data->time = $request->time;
        $data->save();

        return response()->json([
            'code ' => 200,
            'message' => 'data updated',
            'data' =>  new UserConsultationResource($data)
        ],200);
    }
}
