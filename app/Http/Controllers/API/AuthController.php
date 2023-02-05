<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try{
            //validate the request
            $validator=Validator::make($request->all(),[
               'first_name'=>'required',
               'last_name'=>'required',
               'username'=>'required|unique:users',
               'email'=>'required|unique:users|email',
               'phone_number'=>'required|unique:users',
                'password'=>'required|min:8|max:12',
                'confirm_password'=>'required|same:password'
            ]);
            //check if the validation rule has been met
            if ($validator->fails()){
                return response()
                    ->json([
                        'success'=>false,
                        'message'=>$validator->errors()->first(),
                        'error'=>$validator->errors()
                    ],400);
            }
            // else validation passed
            $user=User::create([
                'first_name'    =>$request->input('first_name'),
                'last_name'     =>$request->input('last_name'),
                'username'      =>$request->input('username'),
                'email'         =>$request->input('email'),
                'phone_number'  =>$request->input('phone_number'),
                'password'      =>Hash::make($request->input('password')),
            ]);
            $role=Role::where("name","ADMIN")->first();
            $user->assignRole($role);
            return response()
                ->json([
                    'success'=>true,
                    'message'=>"You have successfully registered on ".config('app.name'),
                    'data'=>$user
                ],201);
        } catch (Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
    }
    //
    public function login(Request $request)
    {
        try{
            $validator=Validator::make($request->all(),[
                'email'=>'required|email',
                'password'=>'required'
            ]);

            if ($validator->fails()){
                return response()
                    ->json([
                        "success" =>false,
                        "message"=>$validator->errors()->first(),
                        "error"=>$validator->errors()
                    ],400 );
            }

//            Else Authentication passed
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)){
                $user=User::where("email",$credentials['email'])->first();
                return response()
                    ->json([
                        "success" =>true,
                        "message"=>"You have successfully logged in",
                        "data" =>Auth::user(),
                        "token"=>$user->createToken('secret')->plainTextToken
                    ],200);
            }
        }
        catch (Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
    }
    public function logout()
    {

        try{
            $user=Auth::user();
            $user->tokens()->delete();
            return response()
                ->json([
                    'success'=>true,
                    'message'=>"Logged Out",
                ],200);
        }
        catch (Exception $exception) {
            return response()
                ->json([
                    'success'=>false,
                    'message'=>$exception->getMessage(),
                    'error'=>$exception->getTrace()
                ],500);
        }
    }
}
