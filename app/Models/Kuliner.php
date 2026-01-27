<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    protected $table = 'kuliner';

    protected $fillable = [
        'nama_kuliner',
        'deskripsi',
        'asal_daerah',
        'gambar',
        'google_maps_url',
        'external_image_url',
        'is_vegetarian',
        'is_halal',
        'place_id',
        'created_by',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'kuliner_categories', 'kuliner_id', 'category_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
