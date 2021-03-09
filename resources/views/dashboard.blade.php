<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-8 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex items-center justify-center">
                <div class="max-w-7xl w-full mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row w-full lg:space-x-2 space-y-2 lg:space-y-0 mb-2 lg:mb-0">
                        <div class="w-full lg:w-1/2">
                            <div class="mx-2 widget w-full p-4 rounded-lg bg-white border-l-4 border-blue-400">
                                <div class="flex items-center">
                                    <div class="icon w-14 p-3 bg-blue-400 text-white rounded-full mr-3">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="calendar-day" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-calendar-day fa-w-14 fa-2x" style="padding-left: 2px;">
                                            <path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h96c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-96zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z" class=""></path>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <div class="text-lg">{{ $date }}</div>
                                        <div class="text-sm text-gray-400">Fecha</div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="w-full lg:w-1/2">
                            <div class="mx-2 widget w-full p-4 rounded-lg bg-white border-l-4 border-green-400">
                                <div class="flex items-center">
                                    <div class="icon w-14 p-3.5 bg-green-400 text-white rounded-full mr-3">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-dollar-sign fa-w-9 fa-2x" style="padding-left: 6px;">
                                            <path fill="currentColor" d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z" class=""></path>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <div class="text-lg">{{ $dolar->dolartoday }}</div>
                                        <div class="text-sm text-gray-400">Tasa del Día</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-1 lg:-mx-4">
                <div class="my-2 px-1 w-full md:w-1/2 lg:my-4 lg:px-6 lg:w-1/2">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        {{ $data[0]->Descripción }} : {{ $data[0]->Dia }}
                        <br>
                        Pax:
                        <br>
                        Porcentaje:
                    </div>
                </div>
                <div class="my-2 px-1 w-full md:w-1/2 lg:my-4 lg:px-6 lg:w-1/2">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        Buffet
                        <table>
                            <thead>
                                <td></td>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
