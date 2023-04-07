<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\postImages;
use App\Models\description;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::all();
        return new PostResource($posts);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:255',
            'heading_image' => 'required|max:255',
            
            // 'heading_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required',
            // 'descriptions.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
  
        

        

    //     if (isset($request->heading_image) && !empty($request->heading_image)) {
    //     return response()->json([
    //         'back heading_image' => time().'.'.$request->heading_image->extension(),                    
    //     ]);
    // }
    //---------------------------------------------------------------------------
        // $imageName = time().'.'.$request->heading_image->extension();
        // $imageName='http://127.0.0.1:8000/images/'.$imageName;
        // $request->heading_image->move(public_path('images'), $imageName);
        

        $slug=Str::slug($request->input('title'));
        $counter=1;
        while(Post::whereSlug($slug)->exists()){
            $slug=$slug.'-'.$counter;
            $counter++;
        }
        
        
        // $post = Post::create([
        //     'title' => $request->input('title'),
        //     'slug' => $slug,
        //     'heading_image' => $imageName,
        //     'user_id' => auth()->user()->id,
        //     'category_id' => $request->input('category_id'),
        // ]);
    //---------------------------------------------------------------------------
        
                    foreach ($request->input('descriptions') as  $descriptionInput) {
                        // $description = new Description();
                        // $description->post_id = $post->id;
                        // $description->heading= $descriptionInput['heading'];
                        // $description->description = $descriptionInput['description'];
                        // $description->save();
                        // var_dump($descriptionInput);
                                            if (isset($descriptionInput['image']) && !empty($descriptionInput['image'])) {
                                                return response()->json([
                                                        'back description' => 'description image exist',                    
                                                        // 'back description image' => $descriptionInput['image'],                    
                                                        'back description image' => time().'.'.$descriptionInput['image']->extension(),                    
                                                    ]);

                                                $imageName = time().'.'.$descriptionInput['image']->extension();
                                                $imageName = 'http://127.0.0.1:8000/description/'.$imageName;
                                                $descriptionInput['image']->move(public_path('description'), $imageName);
                                                
                                                
                                                        
                                            }else{
                                                        return response()->json([
                                                                'back description' => 'description image not exist',
                                                            ]);
                                            }
                            
                       

                            // $postImage = new postImages();
                            // $postImage->post_id = $post->id;
                            // $postImage->description_id = $description->id;
                            // $postImage->image = $imageName;
                            // $postImage->save();
                    }

        return response()->json([
            'message' => 'Post created successfully.',
            // 'post' => $post,
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post=Post::find($id);
        if($post){
            return response()->json([
                'post'=>$post
            ]);
        }else{
            return response()->json([
                "message"=>'Post does not exist'
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post =Post::find($id);
        if($post){
            $post->delete();
            return response()->json([
                "message"=>'Post deleted secceccfuly'
            ]);
        }else{
            return response()->json([
                "message"=>'Post does not exist'
            ]);
        }
    }
}
