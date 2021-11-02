<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Helpers\CollectionHelper;
use App\Http\Resources\ConsultantConsultationResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Exception;

class ConsultantConsultationController extends Controller
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
            'consultantConsultation', 
            'getConsultationHistory',
            'getIncomingConsultation',
            'getActiveConsultation',
            'getWaitingConsultation',
            'getTodayConsultation',
            'getCompletedConsultation',
            'getRejectedConsultation',
            'getConsultationStatus',
        ]]);
    }

    public function consultantConsultation(Request $request, $id) {
        $data =  Consultation::findOrFail($id);
        if($request->user()->cannot('view', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        return response()->json([
            'code' => 200,
            'data' => new ConsultantConsultationResource($data)
        ],200);
    }

    public function getConsultationHistory($id) {
        $data = Consultation::join('consultants', 'consultations.consultant_id', 
                '=', 'consultants.id')
                ->join('users', 'consultations.user_id', '=', 'users.id')
                ->select('consultations.id','consultants.id AS consultant_id',
                'consultations.title', 'users.name', 'consultations.date', 
                'consultations.time','consultations.status', 
                'consultations.is_confirmed')
                ->where('consultations.consultant_id', '=', $id)
                ->where('consultations.status', '=', 'done')
                ->get();
        if(Gate::denies('show-consultant-query', (int)$id)) {
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

    public function getConsultationStatus($id, $status) {
        $data = DB::table('consultations')
                ->join('consultants', 'consultations.consultant_id', '=',
                'consultants.id')
                ->select('consultations.id', 'consultations.title',
                'consultations.date', 'consultations.status')
                ->where('consultations.consultant_id', '=', $id)
                ->where('consultations.status', '=', $status)
                ->get();
        if(Gate::denies('show-consultant-query', (int)$id)) {
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

    public function getActiveConsultation($id) {
        if(Gate::denies('show-consultant-query', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data = DB::table('consultations')
                ->join('consultants', 'consultations.consultant_id', '=',
                'consultants.id')
                ->join('users', 'consultations.user_id', '=',
                'users.id')
                ->select('consultations.id', 'users.name', 
                'consultations.title', 'consultations.date', 
                'consultations.time', 'consultations.conference_link')
                ->where('consultations.consultant_id', '=', $id)
                ->where('consultations.status', '=', 'active')
                ->where('consultations.is_confirmed', '=', 1)
                ->get();
        $paginated = CollectionHelper::paginate($data,5);
        return response()->json([
            'code' => 200,
            'data' => $paginated
        ],200);
    }

    public function getWaitingConsultation($id) {
        if(Gate::denies('show-consultant-query', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data = DB::table('consultations')
                ->join('consultants', 'consultations.consultant_id', '=',
                'consultants.id')
                ->join('users', 'consultations.user_id', '=',
                'users.id')
                ->select('consultations.id','users.name', 
                'consultations.title', 'consultations.date', 
                'consultations.time')
                ->where('consultations.consultant_id', '=', $id)
                ->where('consultations.status', '=', 'waiting')
                ->where('consultations.is_confirmed', '=', 1)
                ->get();
        $paginated = CollectionHelper::paginate($data,5);
        return response()->json([
            'code' => 200,
            'data' => $paginated
        ],200);
    }

    public function getTodayConsultation($id) {
        if(Gate::denies('show-consultant-query', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $date = Carbon::now()->format('d-m-Y');
        $data = DB::table('consultations')
                ->join('consultants', 'consultations.consultant_id', '=',
                'consultants.id')
                ->join('users', 'consultations.user_id', '=',
                'users.id')
                ->select('consultations.id', 'users.name', 
                'consultations.title', 'consultations.date', 
                'consultations.time')
                ->where('consultants.id', '=', $id)
                ->where('consultations.status', '=', 'active')
                ->where('consultations.date', '=', $date)
                ->get();
        $paginated = CollectionHelper::paginate($data,5);
        return response()->json([
            'code' => 200,
            'data' => $paginated
        ],200);
    }

    public function getIncomingConsultation($id) {
        if(Gate::denies('show-consultant-query', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data = DB::table('consultations')
                ->join('consultants', 'consultations.consultant_id', '=',
                'consultants.id')
                ->join('users', 'consultations.user_id', '=',
                'users.id')
                ->select('consultations.id', 'users.name', 
                'consultations.title', 'consultations.date', 
                'consultations.time')
                ->where('consultations.consultant_id', '=', $id)
                ->where('consultations.status', '=', 'waiting')
                ->where('consultations.is_confirmed', '=', 0)
                ->get();
        $paginated = CollectionHelper::paginate($data,5);
        return response()->json([
            'code' => 200,
            'data' => $paginated
        ],200);
    }

    public function getCompletedConsultation($id) {
        if(Gate::denies('show-consultant-query', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data = DB::table('consultations')
                ->join('consultants', 'consultations.consultant_id', '=',
                'consultants.id')
                ->join('users', 'consultations.user_id', '=',
                'users.id')
                ->select('consultations.id', 'users.name',  
                'consultations.title', 'consultations.date', 
                'consultations.time')
                ->where('consultations.consultant_id', '=', $id)
                ->where('consultations.status', '=', 'done')
                ->where('consultations.is_confirmed', '=', 1)
                ->get();
        $paginated = CollectionHelper::paginate($data,5);
        return response()->json([
            'code' => 200,
            'data' => $paginated
        ],200);
    }

    public function getRejectedConsultation($id) {
        try {
            $data = DB::table('consultations')
                    ->join('consultants', 'consultations.consultant_id', '=',
                    'consultants.id')
                    ->join('users', 'consultations.user_id', '=',
                    'users.id')
                    ->select('consultations.id', 'users.name', 
                    'consultations.title', 'consultations.date', 
                    'consultations.time')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', 'done')
                    ->where('consultations.is_confirmed', '=', 0)
                    ->get();
            $paginated = CollectionHelper::paginate($data,5);
            return response()->json([
                'code' => 200,
                'data' => $paginated
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

}
