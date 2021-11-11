<?php

namespace App\Http\Controllers;

use App\ConsultantSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConsultantSkillController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api');
    }
    
    public function destroy(Request $request, $id) {
        $data = ConsultantSkill::findOrFail($id);
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
