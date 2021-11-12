<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Consultant;
use Exception;
use App\Helpers\CollectionHelper;
use App\Http\Resources\UserConsultationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\returnSelf;

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

    public function userConsultation($id) {
        $data = Consultation::findOrFail($id);
        if(Gate::denies('user-consultation', $data)) {
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

    public function userConsultationStatus($id, $status) {
        $data = Consultation::join('consultants', 'consultations.consultant_id',
                    '=', 'consultants.id')
                    ->select('consultations.id', 'consultations.user_id AS user_id',
                    'consultations.consultant_id', 'consultants.name',
                    'consultations.title', 'consultations.status',
                    'consultations.is_confirmed', 'consultations.date',
                    'consultations.time')
                    ->where('consultations.user_id', '=', $id)
                    ->where('consultations.status', '=', $status)
                    ->paginate(10);
                    
        if(Gate::denies('show-user', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        // $paginated = CollectionHelper::paginate($data,10);
        return response()->json([
            'code' => 200,
            'data' => $data
        ],200);
    }

    public function reviewConsultation(Request $request, $id) {
        $this->validate($request,[
            'is_like' => 'integer'
        ]);

        try {
            $consultation = Consultation::findOrFail($id);
            $data = Consultant::findOrFail($consultation->consultant_id);
            // dd($request->is_like);
            if ($request->is_like == '1') {
                $data->likes_total++;
            }
            $data->save();
            return response()->json([
                'code' => 200,
                'data' => $data
            ],200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ], 404);
        }
    }
}
