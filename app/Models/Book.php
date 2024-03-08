<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'author',
        'category',
        'availability',
        'isbn',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations');
    }
}
