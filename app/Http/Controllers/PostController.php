<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }


    public function index()
    {
        return response()->json(['data' => Post::all()], 200);
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
        $dummyPostBody = 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum soluta dolores porro. Harum laudantium soluta error et quasi, enim itaque molestias delectus natus incidunt quia, consequuntur minus, dolor ducimus. Vero, vel soluta facere dolor dolorem ipsa? Impedit eius pariatur sint saepe architecto repellendus iusto, vel omnis, praesentium neque sit fuga.';


        $requestPayload = $request->all();
        $requestPayload['userId'] = auth()->user()->id;
        $requestPayload['slug'] = strtolower(Str::slug($requestPayload['title']));

        $validate = Validator::make($requestPayload,[
            'title' => 'required|unique:posts,title',
            'slug' => 'required',
            'userId' => 'required',
            'categoryId' => 'required',
            'thumbnail' => 'required',
            'bodyImages' => 'required',
            'body' => 'required|min:40'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }

        $validatedPayload = $validate->validated();
        $post = $validatedPayload;

        try{
            Post::create($post);
            return response()->json(['message' => 'Post created Succesfully'], 201);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // return response()->json(['test' => $post], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
       return response()->json([
        'post' => $post
       ], 200);



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return response()->json([
            'post' => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $payload = $request->all();
        if(!empty($payload)){
            $validate = Validator::make($payload,[
                'userId' => 'required',
                'categoryId' => 'required',
                'thumbnail' => 'required',
                'bodyImages' => 'required',
                'body' => 'required|min:40'
            ]);

            if($validate->fails()){
                return response()->json($validate->errors());
            }

            $validatedPayload = $validate->validated();
        }else{
            $validatedPayload = $payload;

        }

        $updatedPost = $validatedPayload;

        try{
            $post->update($updatedPost);
            return response()->json(['message' => 'Post updated Succesfully'], 201);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
