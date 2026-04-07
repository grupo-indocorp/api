<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class Company extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'is_active',
        'expires_at'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function tokens()
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }
}
