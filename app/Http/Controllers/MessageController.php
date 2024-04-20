<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

    public function messages()
    {
        $messages = Message::with('user')->get();
        return response()->json(['messages' => $messages], 200);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $message = $request->validate([
            'messageBody' => 'required'
        ]);

        try{
            $sendMessage = Message::create([
                'senderId' => auth()->user()->id,
                'messageBody' => $request->messageBody,
                'receiverId' => $chatId
            ]);

            SendMessage::dispatch($sendMessage);

            return response()->json(['message' => $sendMessage], 201);

        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }

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
