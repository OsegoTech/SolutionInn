<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $users=User::all();
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'You have successfully retrieved users',
                    'data'=>$users
                ],200);

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            $user=User::find($id);
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'You have successfully retrieved user details',
                    'data'=>$user
                ],200);

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
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
        try{
            //array filter remove empty keys
            User::where('id',$id)
                ->update(array_filter($request->all()));
            //
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'You have successfully update user details',
                ],200);

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
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
        try{
            //array filter remove empty keys
            User::where('id',$id)
                ->delete();
            //check how to work with Trashed.
            return response()
                ->json([
                    'success'=>true,
                    'message'=>'You have successfully deleted user',
                ],200);

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
    }
}
