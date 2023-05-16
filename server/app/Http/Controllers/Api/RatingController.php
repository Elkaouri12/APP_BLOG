<?php

namespace App\Http\Controllers\Api;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingResource;
use App\Http\Resources\Rating\RatingCollection;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $rating= Rating::all();
    return new RatingCollection($rating);

    }

   
    public function store(Request $request)
    {
          $this->validate($request,[
            'rate'=>'required',
            'user_id'=>'required', 
            'post_id'=>'required',
        ]);


        $rate = Rating::updateOrCreate(
            [
                'user_id' => $request->input('user_id'),
                'course_id' => $request->input('course_id')
            ],
            [
                'rate' => $request->input('rate')
            ]
        );
        
        $message = $rate->wasRecentlyCreated ? 'Rate created successfully' : 'Rate updated successfully';
        
        return response()->json([
            'message' => $message,
            'rate' => $rate
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        return new RatingResource($rating);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1|max:5',
        ]);
    
        // $rating = Rating::findOrFail($id);
    
        $rating->rate = $request->input('rate');
        $rating->save();
    
        return response()->json([
            'message' => 'Rating updated successfully',
            'rating' => $rating,
        ]);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return response()->json([
            'message'=>'rating deleted seccefuly'
        ]);
    }
}
