<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\ConsultationDocument;
use App\Http\Resources\UserConsultationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ConsultationDocumentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            
        ]]);

        $this->middleware('auth:api', ['only' => [
            'uploadDoc',
            'updateDoc'
        ]]);
    }

    public function uploadDoc(Request $request, $id, $docId) {
        $request->validate([
            'file' => ['mimes:jpg,png,jpeg,pdf,docx', 'max:2048']
        ]);
        $data = ConsultationDocument::findOrFail($docId);
        $response = Consultation::findOrFail($id);
        if(Gate::denies('user-consultation-document', [$response, $data])) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $newFileName = Str::random(50) . '.' . $request->file->extension();
        $request->file->move(public_path('storage/' . $request->id), 
        $newFileName);
        $path = "storage/" . $request->id . "/" . $newFileName;    
        $data->file = $path;
        $data->save();
        return response()->json([
            'code ' => 200,
            'message' => 'data created',
            'data' =>  new UserConsultationResource($response)
        ],200);
    }
}
