<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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

    public function login(Request $request) 
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $data = User::where('email', $email)->first();

        if(Hash::check($password, $data->password))
        {
            return response()->json([
                'status' => 'success',
                'message' => 'login successfully',
                'data' => $data
            ],201);
        }else
        {
            return response()->json([
                'success' => false,
                'message' => 'login failed',
                'data' => ''
            ]);
        }
    }

    public function profile($id) {
        $data =  User::findOrFail($id);
        return response()->json([
            'data' => new UserResource($data)
        ]);
    }

    public function consultation($id) {
        $data =  Consultation::findOrFail($id);
        return response()->json([
            'data' => new ConsultationResource($data)
        ]);
    }
}
