<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Resources\ConsultantForumResource;
use App\Http\Resources\UserForumResource;
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

        if(Gate::denies('user-forum', $forum)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        if($forum) {
            $forum->is_ended = 0;
            $forum->save();
        } else {
            $forum = Forum::create([
                'consultant_id' => $request->consultant_id,
                'user_id' => $request->user_id,
                'is_ended' => 0
            ]);
        }
        
        return response()->json([
            'code' => 200,
            'message' => new UserForumResource($forum)
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

        $data = DB::table('messages')
                ->leftJoin('forums','messages.forum_id', '=','forums.id')
                ->rightJoin('users', 'forums.user_id', '=', 'users.id')
                ->rightJoin('consultants', 'forums.consultant_id', '=', 'consultants.id')
                ->select('messages.forum_id', 'messages.message', 
                'consultants.name', 'consultants.photo', 
                DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') AS 
                time"))
                ->where('users.id', '=', $id)
                ->whereRaw('messages.id IN (SELECT MAX(`ID`) FROM MESSAGES GROUP BY FORUM_ID)')
                ->paginate(10);

        return response()->json([
            'code' => 200,
            'message' => $data
        ]);
    }

    public function getConsultantAllConversation($id) {
        if(Gate::denies('show-consultant', (int)$id)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden'
            ],403);
        }

        $data = DB::table('messages')
                ->leftJoin('forums','messages.forum_id', '=','forums.id')
                ->rightJoin('consultants', 'forums.consultant_id', '=', 'consultants.id')
                ->rightJoin('users', 'forums.user_id', '=', 'users.id')
                ->select('messages.forum_id', 'messages.message', 'users.name',
                DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') AS 
                time"))
                ->where('consultants.id', '=', $id)
                ->whereRaw('messages.id IN (SELECT MAX(`ID`) FROM MESSAGES GROUP BY FORUM_ID)')
                ->paginate(10);

        return response()->json([
            'code' => 200,
            'message' => $data
        ]);
    }
}
