<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Añadir Nuevo Tanque') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="m-2">
                <form action="{{ route('tanks.store') }}" method="POST">
                    @csrf
                    <label>
                        Ubicación:
                        <br>
                        <input type="text" name="ubicacion">
                    </label>
                    <br>
                    <label>
                        Capacidad:
                        <br>
                        <input type="number" name="capacidad" min="1" pattern="^[0-9]+">
                    </label>
                    <br>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        Enviar Formulario
                    </button>
                    <br>
                    <a href="{{ route('tanks.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Cancelar
                    </a>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>