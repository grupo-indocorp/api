<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'company_id',
        'identificacion_tipo',
        'identificacion',
        'razon_social',
        'nombre_comercial',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'nombre_completo',
        'direccion',
        'departamento',
        'provincia',
        'distrito',
        'ubigeo',
        'ubigeo_id',
        'estado',
        'condicion',
        'actividad_economica',
        'ejecutivo',
        'ejecutivo_identificacion',
        'equipo',
        'sede',
        'supervisor',
        'tipo_base',
        'fecha_gestion',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
