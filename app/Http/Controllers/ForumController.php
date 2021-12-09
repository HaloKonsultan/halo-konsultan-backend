<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Resources\ConsultantForumResource;
use App\Http\Resources\UserForumResource;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ForumController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            'endConversation',
            'getConsultantAllConversation'
        ]]);

        $this->middleware('auth:api', ['only' => [
            'conversation',
            'getClientAllConversation'
        ]]);
    }

    public function conversation(Request $request) {
        $forum = Forum::where('user_id', $request->user_id)
        ->where('consultant_id', $request->consultant_id)
        ->first();

        if($forum) {
            if(Gate::denies('user-forum',$forum)) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }
            $forum->is_ended = 0;
            $forum->save();
        } else {
            $forum = Forum::create([
                'consultant_id' => $request->consultant_id,
                'user_id' => $request->user_id,
                'is_ended' => 0
            ]);
            if(Gate::denies('update-data-user',(int)$forum->user_id)) {
                return response()->json([
                    'code' => 403,
                    'message' => 'Forbidden'
                ],403);
            }
            $forum->is_ended = 0;
            $forum->save();
            $message = Message::create([
                'forum_id' => $forum->id,
                'sender' => 'consultant',
                'message' => 'Silahkan tuliskan masukkan judul dan deskripsi permasalahan',
                'is_read' => 0
            ]);
        }
        
        return response()->json([
            'code' => 200,
            'data' => new UserForumResource($forum),
            'message' => 'success'
        ], 200);
    }

    public function endConversation($id) {
        $data = Forum::findOrFail($id);
        if(Gate::denies('consultant-forum', $data)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }
        $data->is_ended = 1;
        $data->save();

        return response()->json([
            'code' => 200,
            'data' => new ConsultantForumResource($data)
        ], 200);
    }

    public function getClientAllConversation($id) {
        if(Gate::denies('show-user', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $data = Message::leftJoin('forums','messages.forum_id', '=','forums.id')
                ->rightJoin('users', 'forums.user_id', '=', 'users.id')
                ->rightJoin('consultants', 'forums.consultant_id', '=', 'consultants.id')
                ->rightJoin('categories', 'consultants.category_id', '=', 'categories.id')
                ->select('forums.id','consultants.id as consultant_id', 'users.id as user_id','forums.is_ended', 'categories.name as category',
                'consultants.name', 'consultants.photo', 'messages.message as last_message',
                DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') AS 
                last_messages_time"), 'messages.is_read as last_messages_is_read', 'messages.sender as last_messages_from')
                ->where('users.id', '=', $id)
                ->whereRaw('messages.id IN (SELECT MAX(`ID`) FROM messages GROUP BY FORUM_ID)')
                ->paginate(10);

        return response()->json([
            'code' => 200,
            'data' => $data,
        ], 200);
    }

    public function getConsultantAllConversation($id) {
        if(Gate::denies('show-consultant', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $data = Message::leftJoin('forums','messages.forum_id', '=','forums.id')
                ->rightJoin('consultants', 'forums.consultant_id', '=', 'consultants.id')
                ->rightJoin('users', 'forums.user_id', '=', 'users.id')
                ->select('forums.id', 'users.name as user_name',
                'users.id as user_id', 'messages.message as last_messages', 'forums.is_ended',
                DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') AS last_messages_time"),
                'messages.is_read as last_messages_is_read')
                ->where('consultants.id', '=', $id)
                ->whereRaw('messages.id IN (SELECT MAX(`ID`) from messages group by forum_id)')
                ->paginate(10);

        return response()->json([
            'code' => 200,
            'data' => $data
        ], 200);
    }
}
