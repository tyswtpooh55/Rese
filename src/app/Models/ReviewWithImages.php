<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewWithImages extends Model
{
    use HasFactory;

    protected $table = 'reviews_with_images';

    protected $fillable =
    [
        'shop_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function reviewImages()
    {
        return $this->hasMany(ReviewImage::class, 'review_id');
    }
}
