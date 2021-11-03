<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Http\Resources\UserConsultationResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConsultationPreferenceDateController extends Controller
{
    //
    public function __construct()
    {
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
        if(Gate::denies('user-consultation', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

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
