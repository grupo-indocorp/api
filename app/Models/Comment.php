<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'client_id',
        'company_id',
        'external_crm',
        'external_user_id',
        'ejecutivo_nombre',
        'equipo',
        'supervisor',
        'comentario',
        'etiqueta',
        'tipo_contactabilidad',
        'estado_etapa',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
