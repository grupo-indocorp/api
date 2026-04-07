<h1>Crear Empresa</h1>

<form method="POST" action="{{ route('companies.store') }}">
    @csrf

    <input name="name" placeholder="Nombre">
    <input name="email" placeholder="Email">
    <input type="datetime-local" name="expires_at">

    <button>Guardar</button>
</form>