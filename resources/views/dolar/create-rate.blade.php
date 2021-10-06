<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Nueva Tasa') }}
        </h2>
    </x-slot>
    <div class="bg-white lg:w-5/12 md:6/12 w-10/12 m-auto my-10 shadow-md">
        <form action="{{ route('dolar.update') }}" method="POST">
            @csrf
            <div class="my-5 mx-9 text-sm">
                <table class="rounded-xl">
                    <thead>
                        <tr>
                            <th class="py-4 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Fecha</th>
                            <th class="py-4 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Cambio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-grey-lighter">
                            <td class="py-4 px-2 border-b border-grey-light text-center"><input type="date" name="date" placeholder="dd/mm/yyyy"></td>
                            <td class="py-4 px-2 border-b border-grey-light text-center"><input type="number" name="daily_rate"></td>
                        </tr>
                        <tr class="hover:bg-grey-lighter">
                            <td class="py-4 px-2 border-b border-grey-light text-center">
                                <a href="{{ route('dolar.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancelar
                                </a>
                            </td>
                            <td class="py-4 px-2 border-b border-grey-light text-center">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                                    Enviar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</x-app-layout>