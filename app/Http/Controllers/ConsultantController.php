<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultant;
use App\Consultation;
use App\Http\Resources\ConsultantResource;
use App\Http\Resources\ConsultationResource;
use Exception;
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
                return response()->json([
                    'status' => 'success',
                    'message' => 'login successfully',
                    'data' => $data
                ],201);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'Login failed'
            ]);
        }
    }

    public function profile($id) {
        $data =  Consultant::findOrFail($id);
        return response()->json([
            'data' => new ConsultantResource($data)
        ]);
    }

    public function consultation($id) {
        $data =  Consultation::findOrFail($id);
        return response()->json([
            'data' => new ConsultationResource($data)
        ]);
    }
}
