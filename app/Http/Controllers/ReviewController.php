<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $reviews = Review::all();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'You have successfully retrieved all reviews',
                    'data' => $reviews
                ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'rating'=>'required|max:255',
                'text'=>'required'

            ]);

            $review = new Review;
            $review->rating = $request->rating;
            $review->text = $request->text;
            $review->save();
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'Review Posted'
                ]);
        }catch (\Exception $exception){
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Review $review, $id)
    {
        try {
            $review = Review::find($id);
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'Post successfully retrieved',
                    'data'=>$review
                ]);

        }catch (\Exception $exception){
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Review $review)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        try {
//            Array filter remove empty keys
            Review::where('id', $id)
                ->update(array_filter($request->all()));

            return response()
                ->json([
                    "success"=>true,
                    "message"=>"Review Updated"
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Review::where('id', $id)
                ->delete();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Review Deleted Successfully',
                ]);
        }catch (\Exception $exception){
            return response()
                ->json([
                    'success' => false,
                    'message'=> $exception->getMessage(),
                    'error'=>$exception->getTrace()
                ]);
        }
    }
}
