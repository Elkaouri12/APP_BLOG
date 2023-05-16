<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate',
        'user_id',
        'post_id',
    ];
    
    public function course(){
        return $this->belongsTo(Course::class,'post_id');
    }
    
}
