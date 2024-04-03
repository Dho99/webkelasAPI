<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        // $comments = Comments::all();
        // return response()->json(['comments' => $comments], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->all();
        $payload['userId'] = auth()->user()->id;
        $validate = Validator::make($payload, [
            'body' => 'required',
            'postId' => 'required',
            'userId' => 'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }

        $comment = $validate->validated();

        try{
            Comments::create($comment);
            return response()->json(['message' => 'Comment Published'], 201);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comments $comment)
    {
        $payload = $request->all();
        $payload['userId'] = auth()->user()->id;
        $validate = Validator::make($payload, [
            'body' => 'required',
            'postId' => 'required',
            'userId' => 'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }

        $editedComment = $validate->validated();
        $editedComment['isEdited'] = true;
        try{
            $comment->update($editedComment);
            return response()->json(['message' => 'Comment Published'], 201);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comments $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Your Comment has been removed'], 201);
    }
}
