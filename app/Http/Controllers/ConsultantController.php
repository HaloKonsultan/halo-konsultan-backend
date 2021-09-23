<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultantController extends Controller
{
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

    public function login(Request $request) 
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $data = Consultant::where('email', $email)->first();

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
                'message' => 'Login failed',
                'data' => ''
            ]);
        }
    }
}
