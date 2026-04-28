<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = request()->user(); // Empresa autenticada
        $perPage = request('per_page', 10);

        return Client::with('contacts.phones', 'comments')
            ->where('company_id', $company->id)
            ->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $companyId = request()->user()->id;
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

            // CONTACTOS
            'contacts' => 'nullable|array',
            'contacts.*.dni' => 'nullable|string',
            'contacts.*.nombre_completo' => 'required|string',
            'contacts.*.correo_electronico' => 'nullable|email',
            'contacts.*.cargo' => 'nullable|string',

            // TELÉFONOS
            'contacts.*.phones' => 'nullable|array',
            'contacts.*.phones.*.numero' => 'required|string',
            'contacts.*.phones.*.tipo' => 'nullable|string',

            // COMENTARIOS
            'comments' => 'nullable|array',
            'comments.*.external_crm' => 'required|string',
            'comments.*.external_user_id' => 'required|string',
            'comments.*.ejecutivo_nombre' => 'required|string',
            'comments.*.equipo' => 'required|string',
            'comments.*.supervisor' => 'required|string',
            'comments.*.comentario' => 'required|string',
            'comments.*.etiqueta' => 'nullable|string',
            'comments.*.tipo_contactabilidad' => 'nullable|string',
            'comments.*.estado_etapa' => 'nullable|string',
        ]);
        $data['company_id'] = $companyId;

        $client = Client::create($data);

        if (!empty($data['contacts'])) {
            foreach ($data['contacts'] as $contactData) {
                $phones = $contactData['phones'] ?? [];
                unset($contactData['phones']);

                $contact = $client->contacts()->create($contactData);

                foreach ($phones as $phone) {
                    $contact->phones()->create($phone);
                }
            }
        }

        if (!empty($data['comments'])) {
            foreach ($data['comments'] as $comment) {
                $comment['company_id'] = $companyId;
                $client->comments()->create($comment);
            }
        }

        return response()->json([
            'message' => 'Cliente registrado correctamente',
            'data' => $client->load('contacts.phones', 'comments')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $companyId = request()->user()->id;
        $client = Client::where('company_id', $companyId)
            ->with('contacts.phones', 'comments')
            ->findOrFail($id);

        return response()->json([
            'data' => $client
        ], 200);
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

        DB::transaction(function () use ($client, $data) {
            $client->update($data);

            $existingContactIds = $client->contacts()->pluck('id')->toArray();
            $sentContactIds = [];

            if (!empty($data['contacts'])) {
                foreach ($data['contacts'] as $contactData) {
                    $phones = $contactData['phones'] ?? [];
                    unset($contactData['phones']);

                    // UPDATE o CREATE
                    if (isset($contactData['id'])) {
                        $contact = $client->contacts()->find($contactData['id']);
                        if ($contact) {
                            $contact->update($contactData);
                            $sentContactIds[] = $contact->id;
                        }
                    } else {
                        $contact = $client->contacts()->create($contactData);
                        $sentContactIds[] = $contact->id;
                    }

                    // 👉 UPDATE PHONES
                    $existingPhoneIds = $contact->phones()->pluck('id')->toArray();
                    $sentPhoneIds = [];

                    foreach ($phones as $phoneData) {
                        if (isset($phoneData['id'])) {
                            $phone = $contact->phones()->find($phoneData['id']);
                            if ($phone) {
                                $phone->update($phoneData);
                                $sentPhoneIds[] = $phone->id;
                            }
                        } else {
                            $phone = $contact->phones()->create($phoneData);
                            $sentPhoneIds[] = $phone->id;
                        }
                    }

                    // ❌ eliminar phones que ya no vienen
                    $phonesToDelete = array_diff($existingPhoneIds, $sentPhoneIds);
                    $contact->phones()->whereIn('id', $phonesToDelete)->delete();
                }
            }

            // ❌ eliminar contactos que ya no vienen
            $contactsToDelete = array_diff($existingContactIds, $sentContactIds);
            $client->contacts()->whereIn('id', $contactsToDelete)->delete();


            $existingCommentIds = $client->comments()->pluck('id')->toArray();
            $sentCommentIds = [];

            if (!empty($data['comments'])) {
                foreach ($data['comments'] as $commentData) {
                    if (isset($commentData['id'])) {
                        $comment = $client->comments()->find($commentData['id']);
                        if ($comment) {
                            $comment->update($commentData);
                            $sentCommentIds[] = $comment->id;
                        }
                    } else {
                        $comment = $client->comments()->create($commentData);
                        $sentCommentIds[] = $comment->id;
                    }
                }
            }

            // ❌ eliminar comentarios eliminados
            $commentsToDelete = array_diff($existingCommentIds, $sentCommentIds);
            $client->comments()->whereIn('id', $commentsToDelete)->delete();
        });

        return response()->json(
            $client->load('contacts.phones', 'comments'),
            200
        );
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
