<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tanques') }}
        </h2>
    </x-slot>

    <div class="pt-8 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex items-center justify-center">
                <x-stat-grid>
                    <x-slot name="average">
                        TEST
                    </x-slot>

                    <x-slot name="nominal">
                        TEST
                    </x-slot>

                    <x-slot name="lower">
                        TEST
                    </x-slot>

                    <x-slot name="higher">
                        TEST
                    </x-slot>
                </x-stat-grid>
            </div>
        </div>
    </div>

    <div class="pt-2 pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="m-4">
                    <a href="{{ route('reports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Nuevo Reporte
                    </a>

                    <a href="{{ route('tanks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Nuevo Tanque
                    </a>
                </div>
                <div class="m-2">
                    <table class="table w-full border-separate lg:border-collapse table-fixed">
                        <tr>
                            <th class="w-1/4">ID</th>
                            <th class="w-1/4">Usuario</th>
                            <th class="w-1/4">Nr. Tanque</th>
                            <th class="w-1/4">Ubicacion</th>
                            <th class="w-1/4">Litros</th>
                            <th class="w-1/4">Fecha</th>
                        </tr>
                        @foreach ($reports as $report)
                        <tr>
                            <td><a href="{{ route('tanks.show', $report->ID) }}">{{ $report->ID }}</a></td>
                            <td>{{ $report->Usuario }}</td>
                            <td>{{ $report->Tanque }}</td>
                            <td>{{ $report->Ubicación }}</td>
                            <td>{{ $report->Litros }}</td>
                            <td>{{ $report->Actualizado }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</x-app-layout>