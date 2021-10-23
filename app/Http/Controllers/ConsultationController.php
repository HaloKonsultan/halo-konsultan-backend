<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\ConsultationDocument;
use App\ConsultationPreferenceDate;
use App\Helpers\CollectionHelper;
use App\Http\Resources\ConsultantConsultationResource;
use App\Http\Resources\UserConsultationResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'consultantConsultation',
            'getConsultationHistory',
            'getIncomingConsultation',
            'getActiveConsultation',
            'getWaitingConsultation',
            'getTodayConsultation',
            'getCompletedConsultation',
            'getRejectedConsultation',
            'getConsultationStatus',
            'sendLink',
            'acceptConsultation',
            'declineConsultation'
        ]]);

        $this->middleware('auth:api', ['only' => [
            'userConsultation',
            'booking',
            'userConsultationStatus'
        ]]);
    }

    public function consultantConsultation($id) {
        // dd(auth('consultants-api')->user()->id);
        try {
            $data =  Consultation::findOrFail($id);
            return response()->json([
                'code' => 200,
                'data' => new ConsultantConsultationResource($data)
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function userConsultation($id) {
        try {
            $data = Consultation::findOrFail($id);
            if( auth('api')->user()->id == $data->user_id) {
                return response()->json([
                    'code' => 200,
                    'data' => new UserConsultationResource($data)
                ]);
            } else {
                return response()->json([
                    'code' => 401,
                    'message' => 'Unauthorized'
                ],401);
            }
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
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
        try {
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
            $paginated = CollectionHelper::paginate($data,10);
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

    public function getConsultationHistory($id) {
        try {
            $data = DB::table('consultations')
                    ->join('consultants', 'consultations.consultant_id', '=',
                    'consultants.id')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title',
                    'users.name', 'consultations.date', 'consultations.time',
                    'consultations.status', 'consultations.is_confirmed')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', 'done')
                    ->get();
            $paginated = CollectionHelper::paginate($data,10);
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

    public function getConsultationStatus($id, $status) {
        try {
            $data = DB::table('consultations')
                    ->join('consultants', 'consultations.consultant_id', '=',
                    'consultants.id')
                    ->select('consultations.id', 'consultations.title',
                    'consultations.date', 'consultations.status')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', $status)
                    ->get();
            $paginated = CollectionHelper::paginate($data,10);
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

    public function getActiveConsultation($id) {
        try {
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
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function getWaitingConsultation($id) {
        try {
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
        }catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function getTodayConsultation($id) {
        try {
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
            //dd($date);
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

    public function getIncomingConsultation($id) {
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
                    ->where('consultations.status', '=', 'waiting')
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

    public function getCompletedConsultation($id) {
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
                    ->where('consultations.is_confirmed', '=', 1)
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

    public function sendLink(Request $request, $id) {
        try {
            $request->validate([
                'link' => ['string']
            ]);
            $data = Consultation::findOrFail($id);
            $data->conference_link = $request->link;
            $data->save();
            return response()->json([
                'code' => 200,
                'message' => 'Data Updated'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 400,
                'message' => 'Bad Request'
            ], 400);
        }
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

    public function declineConsultation(Request $request, $id) {
        try {
            $request->validate([
                'confirmed' => ['integer']
            ]);

            if($request->confirmed == 0) {
                $data = Consultation::findOrFail($id);
                $data->is_confirmed = $request->confirmed;
                $data->status = 'done';
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

    public function updateConsultation(Request $request, $id) {
        try {
            $request->validate([
                'preference' => ['string'],
                'price' => ['integer'],
                'date.date' => ['string'],
                'date.time' => ['string'],
                'document.title' => ['string'],
                'document.description' => ['string'],
            ]);

            $consulData = Consultation::findOrFail($id);
            // if(auth('consultants-api')->user()->id == $consulData->consultant_id) {
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
                // $consulData->preferenceDate = $date;
                // $consulData->document = $document;
                $consulData->save();
            // } else {
                return response()->json([
                        'code' => 201,
                        'message' => new ConsultantConsultationResource($consulData)
                ], 201);
            // }
            //dd(auth('consultants-api')->user());
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ], 404);
        }
    }
}
