<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultant;
use App\Consultation;
use App\Helpers\CollectionHelper;
use App\Http\Resources\ConsultantConsultationResource;
use App\Http\Resources\ConsultantResource;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultantController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['except' => ['login']]);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email','unique:consultants'],
            'password' => ['required'],
            ]);

            $data = new Consultant;
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));

            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'registered',
                'data' => $data
            ],201);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'register failed',
            ], 409);
        }
    }

    public function login(Request $request) 
    {
        try {
            $request->validate([
                'email' => ['required','email'],
                'password' => ['required'],
            ]);
            $email = $request->input('email');
            $password = $request->input('password');
            $data = Consultant::where('email', $email)->first();
    
            if(Hash::check($password, $data->password))
            {
                if(! $token = auth()->login($data)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                } else {
                    return $this->respondWithToken($token, $data);
                }
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'Login failed'
            ]);
        }
    }

    public function profile($id) {
        try {
            $data =  Consultant::findOrFail($id);
            return response()->json([
                'code' => 200,
                'data' => new ConsultantResource($data)
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function history() {
        try {
            $data = DB::table('consultations')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title', 'users.name', 'consultations.date', 'consultations.status')
                    ->get();
            $paginated = CollectionHelper::paginate($data,1);
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

    public function showAllConsultation() {
        try {
            $data = Consultation::all();
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

    public function consultation($id) {
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

    public function status($id, $status) {
        try {
            $data = DB::table('consultations')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title', 'users.name', 'consultations.date')
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

    public function active($id) {
        try {
            $data = DB::table('consultations')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title', 'users.name', 'consultations.date')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', 'active')
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

    public function waiting($id) {
        try {
            $data = DB::table('consultations')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title', 'users.name', 'consultations.date')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', 'waiting')
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

    public function today($id) {
        try {
             $data = DB::table('consultations')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title', 'users.name', 'consultations.date')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', 'today')
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

    public function incoming($id) {
        try {
            $data = DB::table('consultations')
                    ->join('users', 'consultations.user_id', '=', 'users.id')
                    ->select('consultations.id', 'consultations.title', 'users.name', 'consultations.date')
                    ->where('consultations.consultant_id', '=', $id)
                    ->where('consultations.status', '=', 'incoming')
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

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$data)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => $data
        ]);
    }
}
