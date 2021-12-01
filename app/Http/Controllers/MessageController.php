<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Resources\ConsultantForumResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserForumResource;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            'readByConsultant',
            'consultantSend',
            'getConsultantAllMessage'
        ]]);

        $this->middleware('auth:api', ['only' => [
            'readByUser',
            'userSend',
            'getUserAllMessage'
        ]]);
    }

    public function readByConsultant($id) {
        $data = Message::findOrFail($id);
        $data->is_read = 1;
        $consultantId = $data->forum->consultant_id;
        if(Gate::denies('consultant-update', $consultantId)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->save();

        return response()->json([
            'code' => 200,
            'message' => 'Data Updated'
        ], 200);
    }

    public function readByUser($id) {
        $data = Message::findOrFail($id);
        $data->is_read = 1;
        $userId = $data->forum->user_id;
        if(Gate::denies('update-data-user', $userId)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->save();

        return response()->json([
            'code' => 200,
            'message' => 'Data Updated'
        ], 200);
    }

    public function userSend(Request $request, $id) {
        if(Gate::denies('update-data-user', (int)$request->user_id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $message = Message::create([
            'forum_id' => $id,
            'sender' => 'client',
            'message' => $request->message,
            'is_read' => 0
        ]);

        return response()->json([
            'code' => 201,
            'data' => new MessageResource($message)
        ], 201);
    }

    public function consultantSend(Request $request, $id) {
        if(Gate::denies('consultant-update', (int)$request->consultant_id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $message = Message::create([
            'forum_id' => $id,
            'sender' => 'consultant',
            'message' => $request->message,
            'is_read' => 0
        ]);

        return response()->json([
            'code' => 201,
            'data' => new MessageResource($message)
        ], 201);
    }

    public function getConsultantAllMessage($id) {
        $data = Forum::findOrFail($id);
        if(Gate::denies('consultant-forum', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        return response()->json([
            'code' => 200,
            'data' => MessageResource::collection($data->message)
        ]);
    }

    public function getUserAllMessage($id) {
        $data = Forum::findOrFail($id);
        if(Gate::denies('user-forum', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        return response()->json([
            'code' => 200,
            'data' => MessageResource::collection($data->message)
        ]);
    }
}
