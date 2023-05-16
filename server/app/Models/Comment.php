<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];

    public function post(){
        return $this->belongsTo(post::class,'post_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
