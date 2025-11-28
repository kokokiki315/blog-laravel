<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'published_at',
        'user_id',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
