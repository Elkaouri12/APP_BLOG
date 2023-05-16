<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return parent::toArray($request);

        // return [
        //     'name'=>$this->name,
        //     'image'=>$this->image,
        //     'slug'=>$this->slug,
        //     'description'=>$this->description,
        // ];
    }
}
