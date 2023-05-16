<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\Category\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return new  CategoryResource($categories);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;



        $slug=Str::slug($request->input('name'));
        $counter=1;
        while(Category::whereSlug($slug)->exists()){
            $slug=$slug.'-'.$counter;
            $counter++;
        }
        
        $category->slug = $slug;

        if($request->hasFile('image')) {
                $imageName = time().'.'. $request->image->extension();
                $imageName='http://127.0.0.1:8000/category/'.$imageName;
                $request->image->move(public_path('category'), $imageName);
                $category->image=$imageName;
        }
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category added successfully!',
            'data' => $category
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
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
    public function update(Request $request, string $id)
    {
    
        $category = Category::find($id);


        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found!',
            ], 404);
        }
        $category->name = $request->name;
        $category->description = $request->description;

        $slug = Str::slug($request->input('name'));
        $counter = 1;
        while(Category::whereSlug($slug)->where('id', '!=', $id)->exists()){
            $slug = $slug.'-'.$counter;
            $counter++;
        }
        $category->slug = $slug;


        if($request->hasFile('image')) {
            $imageName = time().'.'. $request->image->extension();
            $imageName='http://127.0.0.1:8000/category/'.$imageName;
            $request->image->move(public_path('category'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'data' => $category
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
        if (file_exists(public_path('category/').$category->image)){
            unlink(public_path('category/').$category->image);
        }  
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!'
        ]);
    
    }
}
