<?php

namespace App\Http\Controllers;

use App\Consultant;
use App\ConsultantDocumentation;
use App\Http\Resources\ConsultantDocumentationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ConsultantDocumentationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api');
    }

    public function upload(Request $request, $id) {
        if(Gate::denies('update-data-consultant', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        
        $request->validate([
            'consultation_doc.id' => ['integer'],
            'consultation_doc.photo' =>  ['mimes:jpg,png,jpeg', 'max:1024']
        ]);

        foreach($request->consultation_doc as $doc) {
            if($doc["id"] < 0) {
                $consultantDoc = new ConsultantDocumentation();
                $consultantDoc->consultant_id = $id;
                $imageName = Str::random(50) . "." .  $doc["photo"]->extension();
                $path = public_path('images/');
                $doc["photo"]->move($path, $imageName);
                $image = "images/" . $imageName;
                $consultantDoc->photo = $image;
                $consultantDoc->save();
            } else {
                $consultantDoc = ConsultantDocumentation::find($doc["id"]);
                $consultantDoc->consultant_id = $id;
                $imageName = Str::random(50) . "." .  $doc["photo"]->extension();
                $path = public_path('images/');
                $doc["photo"]->move($path, $imageName);
                $image = "images/" . $imageName;
                $consultantDoc->photo = $image;
                $consultantDoc->save();
            }
        }

        $data = Consultant::findOrFail($id);

        return response()->json([
            'code' => 200,
            'data' => ConsultantDocumentationResource::collection($data->documentation)
        ], 200);
    }

    public function destroy(Request $request, $id) {
        $data = ConsultantDocumentation::findOrFail($id);
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
