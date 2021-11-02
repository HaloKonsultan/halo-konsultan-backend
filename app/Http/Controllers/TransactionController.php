<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    public function update(Request $request, $id) {
        $data = Consultation::findOrFail($id);
        if($request->user()->cannot('update', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->status = "active";
        $data->save();
        return response()->json([
            'data' => $data,
            'message' => 'data updated'
        ],200);
    }

    public function end($id) {
        $data = Consultation::findOrFail($id);
        if(auth('consultants-api')->user()->cannot('update', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->status = "done";
        $data->save();
        return response()->json([
            'data' => $data,
            'message' => 'data updated'
        ],200);
    }
}
