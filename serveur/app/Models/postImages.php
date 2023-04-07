<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class postImages extends Model
{
    use HasFactory;
    protected $fillable=[
        'post_id',
        'image',
        'description_id',
    ];

    public function Image(): BelongsTo
    {
        return $this->belongsTo(description::class, 'description_id');
    }
}
