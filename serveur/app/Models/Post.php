<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'slug',
        'heading_image',
        'user_id',
        'category_id'
    ];
  
    public function descriptions(): HasMany
    {
        return $this->hasMany(description::class, 'post_id', 'id');
    }
    
    
}
