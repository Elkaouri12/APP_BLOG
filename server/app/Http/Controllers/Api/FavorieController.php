<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Favorite\FavorieResource;

class FavorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorite=Favorite::all();
        return new FavorieResource($favorite);
        return new FavorieResource($favorite);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $this->validate($request,[
            'user_id'=>'required',
            'post_id'=>'required',
        ]);

        $user_favorite=Favorite::where('user_id',$request->input('user_id'))
                                ->where('post_id',$request->input('post_id'))
                                ->first();
        if(!$user_favorite){
            $favorite=Favorite::create([
                'user_id'=>$request->input('user_id'),
                'post_id'=>$request->input('post_id'),
            ]);
            return response()->json([
                'message'=>'favorite added seccessfully',
                'favorite'=>$favorite
    
            ]);
        }else{
            return response()->json([
                'message'=>'favorite alrady exist',
            ]);

        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $favorite=Favorite::find($id);
        if($favorite){
            return response()->json([
                'favorite'=>$favorite
            ]);
            
        }else{   
            return response()->json([
                'message'=>'Favorite Not found'
            ]);
        }
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $favorite=Favorite::find($id);
        $favorite->delete();
        return response()->json([
            'message'=>'Favorite deleted seccefully',
            'favorite'=>$favorite
        ]);
    }
}
