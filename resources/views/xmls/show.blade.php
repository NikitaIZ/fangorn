<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Reporte '. $data[0]->Documento . ' Fecha '. $data[0]->Fecha) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full table-auto">
                    <thead class="justify-between">
                        <tr class="bg-gray-800">
                            <th class="px-16 py-2">
                            <span class="text-gray-300">Descripción</span>
                            </th>
                            <th class="px-16 py-2">
                            <span class="text-gray-300">Día</span>
                            </th>
                            <th class="px-16 py-2">
                            <span class="text-gray-300">Mes</span>
                            </th>
                            <th class="px-16 py-2">
                            <span class="text-gray-300">Año</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-200">
                        @foreach ($data as $dato)
                            <tr class="bg-white border-4 border-gray-200">
                                <td class="px-16 py-2">
                                    <span class="text-center font-semibold">{{ $dato->Descripción }}</span>
                                </td>
                                <td class="px-16 py-2 text-center">
                                    @if ($dato->Dia == "")
                                        <span>{{ $dato->Dia }}</span>           
                                    @else
                                        <span>{{ round($dato->Dia, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-16 py-2 text-center">
                                    @if ($dato->Mes == "")
                                        <span>{{ $dato->Mes }}</span>           
                                    @else
                                        <span>{{ round($dato->Mes, 2) }}</span>
                                    @endif
                                </td>
                                <td class="px-16 py-2 text-center">
                                    @if ($dato->Año == "")
                                        <span>{{ $dato->Año }}</span>           
                                    @else
                                        <span>{{ round($dato->Año, 2) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>