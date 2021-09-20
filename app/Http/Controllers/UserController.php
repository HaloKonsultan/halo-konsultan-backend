<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    //
    public function show() {
        $data =  User::all();
        return response()->json([
            'data' => $data
        ]);
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

    // public function login()
    // {
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     $data = User::where('email', $email)->first();

    //     if(Hash::check($password, $data->password))
    //     {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'login successfully',
    //             'data' => $data
    //         ],201);
    //     }else
    //     {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'login failed',
    //             'data' => ''
    //         ]);
    //     }     
    // }

    public function login() 
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

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
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
