<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }


    public function index()
    {
        $posts = Post::with('comments')->get();

        return response()->json(['data' => $posts], 200);
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
        // testing use only
            // $dummyPostBody = 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum soluta dolores porro. Harum laudantium soluta error et quasi, enim itaque molestias delectus natus incidunt quia, consequuntur minus, dolor ducimus. Vero, vel soluta facere dolor dolorem ipsa? Impedit eius pariatur sint saepe architecto repellendus iusto, vel omnis, praesentium neque sit fuga.';

            // $images = [];

            // foreach(range(0, 5) as $range){
            //     $images[$range] = fake()->imageUrl(640, 480, 'animals', true);
            // }
            // $requestPayload['title'] = fake()->paragraph();
            // $requestPayload['categoryId'] = mt_rand(0,10);
            // $requestPayload['thumbnail'] = fake()->imageUrl(640, 480, 'animals', true);
            // $requestPayload['bodyImages'] = json_encode($images);
            // $requestPayload['body'] = $dummyPostBody;



        $requestPayload = $request->all();
        $requestPayload['userId'] = auth()->user()->id;
        $requestPayload['slug'] = strtolower(Str::slug($requestPayload['title']));
        $requestPayload['excerpt'] = strip_tags($request->body, 200);
        $requestPayload['bodyImages'] = json_encode($requestPayload['bodyImages']);

        $validate = Validator::make($requestPayload,[
            'title' => 'required|unique:posts,title',
            'slug' => 'required',
            'userId' => 'required',
            'categoryId' => 'required',
            'thumbnail' => 'required',
            'bodyImages' => 'required|json',
            'body' => 'required|min:40',
            'excerpt' => 'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }


        $validatedPayload = $validate->validated();
        $post = $validatedPayload;
        if($request->file('thumbnail')){
            $post['thumbnail'] = $request->file('thumbnail')->store('thumbnail');
        }

        try{
            Post::create($post);
            return response()->json(['message' => 'Post created Succesfully'], 201);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // return response()->json(['test' => $requestPayload], 200);
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
        $payload['userId'] = auth()->user()->id;
        $payload['slug'] = strtolower(Str::slug($payload['title']));
        if(!empty($payload)){
            $validate = Validator::make($payload,[
                'title' => 'required|unique:posts|min:10',
                'userId' => 'required',
                'categoryId' => 'required',
                'thumbnail' => 'required',
                'bodyImages' => 'required|json',
                'body' => 'required|min:40',
                'slug' => 'required',
                'excerpt' => 'required'
            ]);

            if($validate->fails()){
                return response()->json($validate->errors());
            }


            $validatedPayload = $validate->validated();
        }else{
            $validatedPayload = $payload;
        }

        $updatedPost = $validatedPayload;
        if($request->file('thumbnail')){
            $updatedPost['thumbnail'] = $request->file('thumbnail')->store('thumbnail');
        }

        try{
            $post->update($updatedPost);
            return response()->json(['message' => 'Post updated Succesfully'], 204);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
        // return response()->json(['post' => $payload], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try{
            $postData = $post;
            $deleteThumbnail = Storage::delete($post->thumbnail);
            //
            // Step untuk menghapus semua image yang diupload di post body bertipe data JSON untuk dihapus dengan looping terlebih dahulu
            // $images = [];
            foreach(json_decode($post->bodyImages) as $key => $image){
                // $images[$key] = $image;
                Storage::delete($image);
            }

            $post->delete();
            return response()->json(['message' => 'Post deleted Succesfully'], 202);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
