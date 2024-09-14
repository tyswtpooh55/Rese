<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'review_id',
        'img_url',
    ];

    public function reviewWithImages()
    {
        return $this->belongsTo(ReviewWithImages::class, 'review_id');
    }
}
