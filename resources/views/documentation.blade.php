<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentación API</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f4f6f8; }
        .card { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
        .method { font-weight: bold; padding: 5px 10px; border-radius: 5px; color: white; }
        .get { background: green; }
        .post { background: blue; }
        pre { background: #222; color: #0f0; padding: 15px; border-radius: 8px; overflow-x: auto; }
    </style>
</head>
<body>

    <h1>📘 Documentación de la API</h1>

    {{-- 🔐 AUTENTICACIÓN --}}
    <div class="card">
        <h2>🔐 Autenticación</h2>
        <p>Todas las peticiones requieren token:</p>

<pre>
Authorization: Bearer TU_TOKEN
Accept: application/json
</pre>
    </div>

    {{-- 📥 GET CLIENTES --}}
    <div class="card">
        <h2>
            <span class="method get">GET</span>
            /api/v1/clients
        </h2>

        <p>Obtiene la lista de clientes.</p>

        <h4>Headers</h4>
<pre>
Authorization: Bearer TU_TOKEN
Accept: application/json
</pre>

        <h4>Respuesta</h4>
<pre>
[
    {
        "id": 1,
        "company_id": 1,
        "identificacion_tipo": "ruc",
        "identificacion": "10749023681",
        "razon_social": "abraham alanya",
        "nombre_comercial": "abrahamalanya",
        "nombre": "abraham",
        "apellido_paterno": "alanya",
        "apellido_materno": null,
        "nombre_completo": "abraham alanya",
        "direccion": "huancayo",
        "departamento": "junín",
        "provincia": "huancayo",
        "distrito": "huancayo",
        "ubigeo": "12001",
        "ubigeo_id": "18",
        "estado": "activo",
        "condicion": null,
        "actividad_economica": "desarrollador web",
        "ejecutivo": "laravel",
        "ejecutivo_identificacion": "12345678",
        "equipo": "laravel",
        "sede": "huancayo",
        "supervisor": "laravel",
        "tipo_base": "sistema",
        "fecha_gestion": "2026-04-18 00:00:00",
        "created_at": "2026-04-07T08:02:52.000000Z",
        "updated_at": "2026-04-07T08:02:52.000000Z"
    }
]
</pre>
    </div>

    {{-- 📤 POST CLIENTE --}}
    <div class="card">
        <h2>
            <span class="method post">POST</span>
            /api/v1/clients
        </h2>

        <p>Crea un nuevo cliente.</p>

        <h4>Headers</h4>
<pre>
Authorization: Bearer TU_TOKEN
Accept: application/json
Content-Type: application/json
</pre>

        <h4>Body</h4>
<pre>
{
    "company_id": 1,
    "identificacion_tipo": "ruc",
    "identificacion": "10749023681",
    "razon_social": "abraham alanya",
    "nombre_comercial": "abrahamalanya",
    "nombre": "abraham",
    "apellido_paterno": "alanya",
    "apellido_materno": "",
    "nombre_completo": "abraham alanya",
    "direccion": "huancayo",
    "departamento": "junín",
    "provincia": "huancayo",
    "distrito": "huancayo",
    "ubigeo": "12001",
    "ubigeo_id": "18",
    "estado": "activo",
    "condicion": "",
    "actividad_economica": "desarrollador web",
    "ejecutivo": "laravel",
    "ejecutivo_identificacion": "12345678",
    "equipo": "laravel",
    "sede": "huancayo",
    "supervisor": "laravel",
    "tipo_base": "sistema",
    "fecha_gestion": "2026/04/18"
}
</pre>

        <h4>Respuesta</h4>
<pre>
{
    "message": "Cliente creado correctamente"
}
</pre>
    </div>

</body>
</html>