<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'id',
        'token',
        'user_id',
        'last_used_at',
        'expires_at',
        'tokenable_type',
        'tokenable_id',
        'name',
    ];

    protected $dates = [
        'last_used_at',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tokenable()
    {
        return $this->morphTo();
    }
}
