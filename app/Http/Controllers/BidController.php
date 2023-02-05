<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store (Request $request, $id)
    {
        try {
//            $bid = new Bid();

            Bid::create([
                'user_id'=>Auth::id(),
                'post_id'=>$request->input('post_id')
            ]);
            return response()
                ->json([
                    "status"=>true,
                    "message"=>"You have successfully placed a bid for this post",
                ]);
        }catch (\Exception $exception){
            return response()
                ->json([
                    "status"=>false,
                    "message"=>$exception->getMessage(),
                    "error"=>$exception->getTrace()
                ]);
        }
    }
}
