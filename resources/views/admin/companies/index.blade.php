<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Empresas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('companies.create') }}" class="text-green-600 hover:text-green-800">Crear</a>

                    @if(session('token'))
                        <p>Token: {{ session('token') }}</p>
                    @endif

                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2 text-left">Expira</th>
                                <th class="px-4 py-2 text-left">Estado</th>
                                <th class="px-4 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $company->id }}</td>
                                    <td class="px-4 py-2">{{ $company->name }}</td>
                                    <td class="px-4 py-2">{{ $company->expires_at ?? 'Ilimitado' }}</td>
                                    <td class="px-4 py-2">
                                        @if($company->is_active)
                                            <span class="text-green-600">Activo</span>
                                        @else
                                            <span class="text-red-600">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('companies.destroy', $company) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                        </form>
                                        <form method="POST" action="{{ route('companies.toggle', $company) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                {{ $company->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('companies.regenerateToken', $company) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800">Regenerar Token</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>