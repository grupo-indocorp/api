<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'client_id',
        'dni',
        'nombre_completo',
        'correo_electronico',
        'cargo',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function phones()
    {
        return $this->hasMany(ContactPhone::class);
    }
}
