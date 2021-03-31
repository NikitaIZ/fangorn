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
                <form action="{{ route('reports.update') }}" method="POST">
                    @csrf
                    <label>
                        Numero del tanque:
                        <br>
                        <select id="tanks" name="tanque">
                            @foreach ($tanks as $tank)
                                <option value="{{ $tank->id }}">{{ $tank->id }}</option>
                            @endforeach
                        </select>
                    </label>
                    <br>
                    <label>
                        litros:
                        <br>
                        <input type="number"  name="litros">
                    </label>
                    <br>
                    <label>
                        Descripcion:
                        <br>
                        <textarea rows="5" name="descripcion"></textarea>
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