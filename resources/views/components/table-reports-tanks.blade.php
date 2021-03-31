<!-- component -->
<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
    <div class="flex flex-wrap mx-1 lg:-mx-4">
        <div class="my-2 px-1 w-full md:w-1/2 lg:my-4 lg:px-6 lg:w-8/12">
            <div class="flex justify-between">
                <div class="inline-flex border rounded w-full h-12 bg-transparent">
                    <div class="flex flex-wrap items-stretch w-full h-full mb-6 relative">
                        <div class="flex mx-2">
                            <span class="flex items-center leading-normal bg-transparent rounded rounded-r-none border border-r-0 border-none lg:px-3 py-2 whitespace-no-wrap text-grey-dark text-sm">
                                <svg width="18" height="18" class="w-4 lg:w-auto" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.11086 15.2217C12.0381 15.2217 15.2217 12.0381 15.2217 8.11086C15.2217 4.18364 12.0381 1 8.11086 1C4.18364 1 1 4.18364 1 8.11086C1 12.0381 4.18364 15.2217 8.11086 15.2217Z" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.9993 16.9993L13.1328 13.1328" stroke="#455A64" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                        <input type="text" class="flex-shrink flex-grow flex-auto leading-normal tracking-wide w-px border border-none border-l-0 rounded rounded-l-none px-3 relative focus:outline-none text-xxs lg:text-base text-gray-500 font-thin" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>
        <div class="my-2 pt-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-4/12">
            <div class="float-left">
                <div class="flex justify-between">
                    <div class="inline-flex w-full">
                        {{ $boton1 }}
                    </div>
                </div>
            </div>
            <div class="float-right">
                <div class="flex justify-between">
                    <div class="inline-flex w-full">
                        {{ $boton2 }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="align-middle inline-block min-w-full overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
        <table class="min-w-full">
            <thead>
                {{ $thead }}
            </thead>
            <tbody class="bg-white">
                {{ $tbody }}
            </tbody>
        </table>
        <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
            {{ $pagination }}
        </div>
    </div>
</div>