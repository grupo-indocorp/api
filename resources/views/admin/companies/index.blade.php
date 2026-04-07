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

                    <a href="{{ route('companies.create') }}">Crear</a>

                    @if(session('token'))
                        <p>Token: {{ session('token') }}</p>
                    @endif

                    @foreach($companies as $company)
                        <div>
                            {{ $company->name }}
                            <p>
                                Expira:
                                {{ $company->expires_at ?? 'Ilimitado' }}
                            </p>

                            <form method="POST" action="{{ route('companies.destroy', $company) }}">
                                @csrf
                                @method('DELETE')
                                <button>Eliminar</button>
                            </form>

                            <form method="POST" action="{{ route('companies.toggle', $company) }}">
                                @csrf
                                @method('PATCH')
                                <button>
                                    {{ $company->is_active ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('companies.regenerateToken', $company) }}">
                                @csrf
                                <button>Regenerar Token</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>