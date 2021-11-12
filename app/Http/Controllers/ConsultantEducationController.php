<?php

namespace App\Http\Controllers;

use App\ConsultantEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConsultantEducationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api');
    }
    
    public function destroy(Request $request, $id) {
        $data = ConsultantEducation::findOrFail($id);
        // dd($data);
        if($request->user()->cannot('delete', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->delete();
        return response()->json([
            'code' => 200,
            'message' => 'Data deleted'
        ], 200);
    }
}
