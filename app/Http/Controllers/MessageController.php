<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Resources\ForumResource;
use App\Http\Resources\MessageResource;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            'getAllMessagesConsultant',
            'readByConsultant',
            'consultantSend'
        ]]);

        $this->middleware('auth:api', ['only' => [
            'readByUser',
            'userSend',
            'getAllMessagesClient'
        ]]);
    }

    public function readByConsultant($id) {
        $data = Message::findOrFail($id);
        $data->is_read = 1;
        $data->save();

        return response()->json([
            'code' => 200,
            'message' => 'Data Updated'
        ], 200);
    }

    public function readByUser($id) {
        $data = Message::findOrFail($id);
        $data->is_read = 1;
        $data->save();

        return response()->json([
            'code' => 200,
            'message' => 'Data Updated'
        ], 200);
    }

    public function userSend(Request $request, $id) {
        $message = Message::create([
            'forum_id' => $id,
            'sender' => $request->name,
            'message' => $request->message,
            'is_read' => 0
        ]);

        return response()->json([
            'code' => 201,
            'data' => new MessageResource($message)
        ], 201);
    }

    public function consultantSend(Request $request, $id) {
        $message = Message::create([
            'forum_id' => $id,
            'sender' => $request->name,
            'message' => $request->message,
            'is_read' => 0
        ]);

        return response()->json([
            'code' => 201,
            'data' => new MessageResource($message)
        ], 201);
    }

    public function getAllMessagesClient($id) {
        $response = Forum::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new ForumResource($response)
        ]);
    }

    public function getAllMessagesConsultant($id) {
        $response = Forum::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new ForumResource($response)
        ]);
    }
}
