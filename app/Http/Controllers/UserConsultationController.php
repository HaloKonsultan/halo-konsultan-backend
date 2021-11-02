<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Helpers\CollectionHelper;
use App\Http\Resources\UserConsultationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserConsultationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => [
            'userConsultation',
            'booking',
            'userConsultationStatus'
        ]]);
    }

    public function userConsultation(Request $request, $id) {
        $data = Consultation::findOrFail($id);
        if($request->user()->cannot('view', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        return response()->json([
            'code' => 200,
            'data' => new UserConsultationResource($data)
        ]);
    }

    public function booking(Request $request) {
        $this->validate($request,[
            'title' => 'string',
            'description' => 'string',
            'consultant' => 'integer',
            'user' => 'integer',
            'is_online' => 'integer',
            'is_offline' => 'integer',
            'location' => 'string',
        ]);

        if($request->input('is_online') == 1 &&
        $request->input('is_offline') == 1) {
            $request->preference = "online offline";
        } else if($request->input('is_online') == 1) {
            $request->preference = "online";
        }else if($request->input('is_offline') == 1) {
            $request->preference = "offline";
        }else {
            $request->preference = "";
        }

        $response = Consultation::create([
            'title' => $request->title,
            'consultant_id' => $request->consultant,
            'user_id' => $request->user,
            'description' =>  $request->description,
            'preference' =>  $request->preference,
            'location' =>$request->location,
            'status' => "waiting",
            'is_confirmed' => 0
        ]);

        $data = Consultation::findOrFail($response->id);
        return response()->json([
            'code ' => 201,
            'message' => 'data created',
            'data' =>  new UserConsultationResource($data)
        ],201);
    }

    public function userConsultationStatus(Request $request, $id, $status) {
        $data = DB::table('consultations')
                    ->join('consultants', 'consultations.consultant_id',
                    '=', 'consultants.id')
                    ->select('consultations.id',
                    'consultations.consultant_id', 'consultants.name',
                    'consultations.title', 'consultations.status',
                    'consultations.is_confirmed', 'consultations.date',
                    'consultations.time')
                    ->where('consultations.user_id', '=', $id)
                    ->where('consultations.status', '=', $status)
                    ->get();
        if($request->user()->cannot('view', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $paginated = CollectionHelper::paginate($data,10);
        return response()->json([
            'code' => 200,
            'data' => $paginated
        ],200);
    }
}
