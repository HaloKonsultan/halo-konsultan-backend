<?php

namespace App\Http\Controllers;

use App\Consultant;
use App\Consultation;
use App\ConsultationDocument;
use App\Helpers\CollectionHelper;
use App\Http\Resources\ConsultantResource;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\UserConsultationResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use Exception; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'login', 
            'register', 
            'logout'
        ]]);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => ['required','string'],
            'email' => ['required','email','unique:users'],
            'password' => ['required'],
        ]);

        try {
            $data = new User;
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->password = Hash::make($request->input('password'));

            $data->save();

            return response()->json([
                'code ' => 201,
                'message' => 'registered',
                'data' => $data
            ],201);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'register failed',
            ], 403);
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
            $data = User::where('email', $email)->first();
    
            if(Hash::check($password, $data->password))
            {
                if(! $token = auth()->login($data)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                } else {
                    return $this->respondWithToken($token, $data);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Login failed'
                ],401);
            }
        }catch(\Exception $e){
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized'
            ],401);
        }
    }

    public function profile($id) {
        try {
            $data =  User::findOrFail($id);
            return response()->json([
                'code' => 200,
                'data' => new UserResource($data)
            ],200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function consultant($id) {
        try {
            $data = Consultant::findOrFail($id);
            return response()->json([
                'code' => 200,
                'data' => new ConsultantResource($data)
            ],200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function searchConsultant($name) {
        try {
            $data = DB::table('consultants')
                    ->leftJoin('categories', 'consultants.category_id', '=', 
                    'categories.id')
                    ->select('consultants.id', 'consultants.name', 
                    'categories.name AS position', 'consultants.likes_total',
                    'consultants.city', 'consultants.photo')
                    ->where('consultants.name', 'LIKE', '%'.$name.'%')
                    ->get();
            $paginated = CollectionHelper::paginate($data,2);
            return response()->json([
                'code' => 200,
                'data' => $paginated
            ],200);
        } catch(Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => 'Not Found'
            ],404);
        }
    }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'name' => ['string'],
                'province' => ['string'],
                'city' => ['string']
            ]);
    
            $data = User::findOrFail($id);
            $data->name = $request->input('name');
            $data->province = $request->input('province');
            $data->city = $request->input('city');
            $data->save();

            return response()->json([
                'code' => 200,
                'data' => new UserResource($data)
            ],200);
        } catch(Exception $e) {
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
        auth('api')->logout();

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
        ],200);
    }
}
