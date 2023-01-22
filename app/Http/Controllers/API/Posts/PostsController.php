<?php

namespace App\Http\Controllers\API\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use PHPUnit\Exception;
use function MongoDB\BSON\toRelaxedExtendedJSON;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $posts = Post::all();
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'You have successfully retrieved all posts',
                    'data'=>$posts
                ],200);
        }catch (\Exception $exception){
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' =>'required|max:255',
            'country'=>'required',
            'price'=>'required',
            'description'=>'required',
            'tags'=>'required'
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->country = $request->country;
        $post->price = $request->price;
        $post->description = $request->description;
        $post->tags = $request->tags;
        $post->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $post = Post::find($id);
            return response()
                ->json([
                    "success"=>true,
                    "message"=>"You have successfully retrieved a post",
                    "data"=>$post
                ],200);
        }catch (\Exception $exception){
            return response()
                ->json([
                    'success'=>false,
                    'message' => $exception ->getMessage(),
                    'error'=>$exception->getTrace()
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
//            Array filter remove empty keys
            Post::where('id', $id)
                ->update(array_filter($request->all()));

            return response()
                ->json([
                    "success"=>true,
                    "message"=>"You have successfully updated the er"
                ], 200);
        }catch (\Exception $exception){
            return response()
                ->json([
                    "success"=>false,
                    "message"=>$exception->getMessage(),
                    "error"=>$exception->getTrace()
                ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Post::where('id', $id)
                ->delete();
            return response()
                ->json([
                    "success"=>true,
                    "message"=>"You have successfully deleted the post"
                ],200);
        }catch (\Exception $exception){
            return response()
                ->json([
                    "success"=>false,
                    "message"=>$exception->getMessage(),
                    "error"=>$exception->getTrace()
                ],500);
        }
    }
}
