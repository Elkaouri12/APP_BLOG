<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request){
        return [
            "id"=>$this->id,
            "fullname"=>$this->full_name,
            "email"=>$this->email,
            "Tel"=>$this->Tel,
            "role"=>$this->role
            // "image"=>$this->image,
            // 'favorite'=>$this->favorite
        ];
    }    
}
