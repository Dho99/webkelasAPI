<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\SendMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function loadMessage($roomId)
    {
        $message = Message::where('chatId', $chatId)->orderBy('updated_at', 'asc')->get();
        return response()->json(['data' => $message], 200);
    }

    public function sendMessage(Request $request)
    {
        $chatId = $request->chatId;
        $userId = auth()->user()->id;
        $message = $request->message;

        broadcast(new SendMessage($chatId, $userId, $message));

        Message::create([
            'chatId' => $chatId,
            'userId' => $userId,
            'message' => $message
        ]);

        return response()->json(['message' => 'Pesan berhasil dikirim', 'success' => true], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
