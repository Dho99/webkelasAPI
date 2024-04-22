<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function create(Request $request)
    {
        $me = auth()->user()->id;
        $friend = $request->friend_id;

        $room = Room::where('users', $me.":".$friend)->orWhere("users", $friend.":".$me)->first();

        if(!$room){
            $dataRoom = Room::create([
                'users' => $me.":".$friend
            ]);
        }else{
            $dataRoom = $room;
        }


        return response()->json([
            'data' => $dataRoom
        ]);
    }
}
