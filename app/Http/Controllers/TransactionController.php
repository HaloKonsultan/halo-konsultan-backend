<?php

namespace App\Http\Controllers;

use App\Consultation;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    public function update($id) {
        try {
            $data = Consultation::findOrFail($id);
            $data->status = "active";
            $data->save();
            return response()->json([
                'data' => $data,
                'message' => 'data updated'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'code' => 400,
                'message' => $e
            ], 400);
        }
    }

    public function end($id) {
        try {
            $data = Consultation::findOrFail($id);
            $data->status = "done";
            $data->save();
            return response()->json([
                'data' => $data,
                'message' => 'data updated'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'code' => 404,
                'message' => $e
            ], 404);
        }
    }
}
