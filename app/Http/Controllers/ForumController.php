<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Resources\ForumResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:consultants-api', ['only' => [
            'endConversation'
        ]]);

        $this->middleware('auth:api', ['only' => [
            'conversation'
        ]]);
    }

    public function conversation(Request $request) {
        $forum = Forum::where('user_id', $request->user_id)
        ->where('consultant_id', $request->consultant_id)
        ->first();

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
        
        $response = Forum::join('consultants', 'forums.consultant_id', '=', 
                    'consultants.id')
                    ->join('categories', 'categories.id', '=', 
                    'consultants.category_id')
                    ->select('forums.id', 'forums.consultant_id', 
                    'forums.user_id', 'forums.is_ended', 
                    'consultants.photo AS consultant_photo', 
                    'consultants.name AS consultant_name', 
                    'categories.name AS consultant_category')
                    ->where('forums.id', $forum->id)
                    ->get();

        return response()->json([
            'code' => 200,
            'message' => $response
        ], 200);
    }

    public function endConversation($id) {
        $data = Forum::findOrFail($id);
        $data->is_ended = 1;
        $data->save();

        return response()->json([
            'code' => 200,
            'data' => new ForumResource($data)
        ], 200);
    }

    public function getAllConversation($id) {
        $response = Forum::join('messages', 'forums.id', '=', 'messages.forum_id')
                    ->join('users', 'forums.user_id', '=', 'users.id')
                    ->join('consultants', 'forums.consultant_id', '=', 'consultants.id')
                    ->select('forums.id AS forum_id', 'consultants.name', 'consultants.photo',
                    'messages.message',
                    DB::raw("DATE_FORMAT(messages.created_at, '%H:%i') AS time"))
                    ->distinct('consultants.name')
                    ->where('forums.user_id', '=', $id)
                    ->latest('messages.created_at')
                    ->paginate(10);
        
        return response()->json([
            'code' => 200,
            'message' => $response
        ]);
    }
}
