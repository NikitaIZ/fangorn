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
                        {{ $data['average'] }}
                    </x-slot>

                    <x-slot name="lower">
                        {{ $data['min'] }}
                    </x-slot>

                    <x-slot name="higher">
                        {{ $data['max'] }}
                    </x-slot>
                </x-stat-grid>
            </div>
        </div>
    </div>

    <div class="pt-2 pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-7xl w-full mx-auto py-6 sm:px-6 lg:px-8">
                    <x-table-reports-tanks>
                        <x-slot name="boton1">
                            <a href="{{ route('tanks.reports.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Reporte
                            </a>
                        </x-slot>
                        <x-slot name="boton2">
                            <a href="{{ route('tanks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Tanque
                            </a>
                        </x-slot>
                        <x-slot name="thead">
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">ID</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Usuario</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Nr. Tanque</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Ubicacion</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Litros</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Fecha</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($reports as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                    <div class="text-sm leading-5 text-blue-900">
                                        {{ $report->ID }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $report->Usuario }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $report->Tanque }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $report->Ubicación }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $report->Litros }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $report->Actualizado }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                                    <a href="{{ route('tanks.show', $report->ID) }}">
                                        <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">Detalles</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </x-slot>
                        <x-slot name="pagination">
                            {{ $reports->links() }}
                        </x-slot>
                    </x-table-reports-tanks>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>