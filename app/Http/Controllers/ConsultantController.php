<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ConsultantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['except' => ['login']]);
    }
    //
    public function show() {
        $data =  Consultant::all();
        return response()->json([
            'data' => $data
        ]);
    }

    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => ['required','string'],
            'email' => ['required','email','unique:consultants'],
            'password' => ['required'],
        ]);

        try {
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

    public function login() 
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('consultants-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout() 
    {
        auth('consultants-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

     /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
