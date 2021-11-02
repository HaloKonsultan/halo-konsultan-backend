<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\ConsultationDocument;
use App\ConsultationPreferenceDate;
use App\Http\Resources\ConsultantConsultationResource;
use Exception;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            'sendLink',
            'acceptConsultation',
            'rejectConsultation'
        ]]);
    }
    
    public function rejectConsultation(Request $request, $id) {
        $data = Consultation::findOrFail($id);
        if(auth('consultants-api')->user()->cannot('update', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $request->validate([
            'message' => ['required'],
            'confirmed' => ['integer']
        ]);

        if($request->confirmed == 0) {
            $data->is_confirmed = $request->confirmed;
            $data->status = 'done';
            $data->message = $request->input('message');
            $data->save();
        }
        return response()->json([
            'code' => 200,
            'data' => new ConsultantConsultationResource($data)
        ]);
    }

    public function sendLink(Request $request, $id) {
        $data = Consultation::findOrFail($id);
        if(auth('consultants-api')->user()->cannot('update', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $request->validate([
            'link' => ['string']
        ]);
        $data->conference_link = $request->link;
        $data->save();
        return response()->json([
            'code' => 200,
            'message' => 'Data Updated'
        ], 200);
    }

    public function acceptConsultation(Request $request, $id) {
        try {
            $request->validate([
                'confirmed' => ['integer']
            ]);

            if($request->confirmed == 1) {
                $data = Consultation::findOrFail($id);
                $data->is_confirmed = $request->confirmed;
                $data->save();
                return response()->json([
                    'code' => 200,
                    'message' => 'Data Updated'
                ], 200);
            } else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request'
                ], 400);
            }
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ], 404);
        }
    }

    // public function declineConsultation(Request $request, $id) {
    //     try {
    //         $request->validate([
    //             'confirmed' => ['integer']
    //         ]);

    //         if($request->confirmed == 0) {
    //             $data = Consultation::findOrFail($id);
    //             $data->is_confirmed = $request->confirmed;
    //             $data->status = 'done';
    //             $data->save();
    //             return response()->json([
    //                 'code' => 200,
    //                 'message' => 'Data Updated'
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'code' => 400,
    //                 'message' => 'Bad Request'
    //             ], 400);
    //         }
    //     }catch(Exception $e) {
    //         return response()->json([
    //             'code' => 404,
    //             'message' => $e
    //         ], 404);
    //     }
    // }

    public function updateConsultation(Request $request, $id) {
        $consulData = Consultation::findOrFail($id);

        if(auth('consultants-api')->user()->cannot('update', $consulData)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        
        $request->validate([
            'preference' => ['string'],
            'price' => ['integer'],
            'date.date' => ['string'],
            'date.time' => ['string'],
            'document.title' => ['string'],
            'document.description' => ['string'],
        ]);

        foreach($request->date as $data) {
            $date = new ConsultationPreferenceDate;
            $date->consultation_id = $id;
            $date->date = $data["date"];
            $date->time = $data["time"];
            $date->save();
        }

        foreach($request->document as $data) {
            $document = new ConsultationDocument;
            $document->consultation_id = $id;
            $document->name = $data["title"];
            $document->description = $data["description"];
            $document->save();
        }

        $consulData->preference = $request->preference;
        $consulData->consultation_price= $request->price;
        $consulData->save();
        return response()->json([
                'code' => 201,
                'message' => new ConsultantConsultationResource($consulData)
        ], 201);
    }
}
