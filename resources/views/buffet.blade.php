<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Buffet') }}
        </h2>
    </x-slot>
    <div class="bg-white lg:w-5/12 md:6/12 w-10/12 m-auto my-10 shadow-md">
            <form action="{{ route('buffet.update', ) }}" method="post" class="mt-6">
                @csrf
                @method('put')
                <div class="my-5 text-sm">
                    <table class="py-4 px-4 rounded-xl">
                        <thead>
                            <tr>
                                <th class="py-4 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Menu</th>
                                <th class="py-4 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Adults </th>
                                <th class="py-4 px-2 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Children</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buffet as $service)
                            <tbody>
                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-2 border-b border-grey-light text-center">{{ $service->service }}</td>
                                    <td class="py-4 px-2 border-b border-grey-light text-center"><input class="rounded-sm py-3 mt-3 focus:outline-none bg-gray-100 w-2/3" type="number" id="{{ $service->service }}_adults" name="{{ $service->service }}_adults" min="0" value="{{$service->adults}}"> $</td>
                                    <td class="py-4 px-2 border-b border-grey-light text-center"><input class="rounded-sm py-3 mt-3 focus:outline-none bg-gray-100 w-2/3" type="number" id="{{ $service->service }}_children" name="{{ $service->service }}_children" min="0" value="{{$service->children}}"> $</td>
                                </tr>
                            </tbody>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-2 pb-4 px-1 w-full lg:my-4 lg:px-4 text-center">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>