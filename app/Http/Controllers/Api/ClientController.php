<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = request()->user(); // Empresa autenticada

        return Client::where('company_id', $company->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'identificacion_tipo' => 'nullable|string',
            'identificacion' => 'nullable|string',
            'razon_social' => 'nullable|string',
            'nombre_comercial' => 'nullable|string',
            'nombre' => 'nullable|string',
            'apellido_paterno' => 'nullable|string',
            'apellido_materno' => 'nullable|string',
            'nombre_completo' => 'nullable|string',
            'direccion' => 'nullable|string',
            'departamento' => 'nullable|string',
            'provincia' => 'nullable|string',
            'distrito' => 'nullable|string',
            'ubigeo' => 'nullable|string',
            'ubigeo_id' => 'nullable|string',
            'estado' => 'nullable|string',
            'condicion' => 'nullable|string',
            'actividad_economica' => 'nullable|string',
            'ejecutivo' => 'nullable|string',
            'ejecutivo_identificacion' => 'nullable|string',
            'equipo' => 'nullable|string',
            'sede' => 'nullable|string',
            'supervisor' => 'nullable|string',
            'tipo_base' => 'nullable|string',
            'fecha_gestion' => 'nullable|string',
        ]);

        return Client::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $client->load('company');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'identificacion_tipo' => 'nullable|string',
            'identificacion' => 'nullable|string',
            'razon_social' => 'nullable|string',
            'nombre_comercial' => 'nullable|string',
            'nombre' => 'nullable|string',
            'apellido_paterno' => 'nullable|string',
            'apellido_materno' => 'nullable|string',
            'nombre_completo' => 'nullable|string',
            'direccion' => 'nullable|string',
            'departamento' => 'nullable|string',
            'provincia' => 'nullable|string',
            'distrito' => 'nullable|string',
            'ubigeo' => 'nullable|string',
            'ubigeo_id' => 'nullable|string',
            'estado' => 'nullable|string',
            'condicion' => 'nullable|string',
            'actividad_economica' => 'nullable|string',
            'ejecutivo' => 'nullable|string',
            'ejecutivo_identificacion' => 'nullable|string',
            'equipo' => 'nullable|string',
            'sede' => 'nullable|string',
            'supervisor' => 'nullable|string',
            'tipo_base' => 'nullable|string',
            'fecha_gestion' => 'nullable|string',
        ]);

        $client->update($data);

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Cliente eliminado']);
    }
}
