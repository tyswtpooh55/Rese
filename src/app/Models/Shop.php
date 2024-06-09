<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $guarded =
    [
        'id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'shop_user', 'shop_id', 'user_id')->withTimestamps();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'shop_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'shop_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
