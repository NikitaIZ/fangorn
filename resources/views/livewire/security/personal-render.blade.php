





<div class="container-fluid ">




    <div class="container-fluid d-flex rounded-0">
        <div class="  rounded search-box border-secondary container-fluid d-flex align-items-center m-0 p-0  rounded-0">
            <div class="m-0 p-0 search-icon-box">
                <i class="fa-solid fa-magnifying-glass fa-lg p-0 m-0"></i>
            </div>
            <div class="border-0 m-0 p-0 flex-fill  ">
                <input type="search" wire:model="search" name="search" id="search" class="search-input border-0 bg-transparent m-0 p-0" placeholder="Buscar...">
            </div>
            <div class="border-0 m-0 p-0 ">
                <div class="dropdown">
                    <button class=" rounded-0 filter-button btn btn-secondary dropdown-toggle p-0 m-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Filtro
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a wire:click="filter('personals.name')" class="dropdown-item" href="#">Nombre</a></li>
                        <li><a wire:click="filter('personals.last_name')" class="dropdown-item" href="#">Apellido</a></li>
                        <li><a wire:click="filter('personals.identification')" class="dropdown-item" href="#">Cedula</a></li>
                        <li><a wire:click="filter('positions.name')" class="dropdown-item" href="#">Cargo</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-0 m-0 p-0 ">
                <div class="container p-0">
                    <a href="{{route('security.personal.register.get')}}" class="btn btn-info  btn-large add-button-box rounded-0">
                        <i class="fa-solid fa-user-plus fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div wire:loading class="container-fluid  d-flex justify-content-center">
        <div wire:loading  class="spinner-grow text-info" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div wire:loading.remove class="container-fluid table-responsive ">
        <table class="table table-striped border rounded-0 m-0 w-100 ">
            <thead>
                <tr>
                    <th scope="col" role="button" class="align-middle" wire:click="sort('name')">
                        <p style="width:fit-content;"class="m-0 p-0 d-flex gap-2">
                            Empleado
                            @if($this->sort_by == "name")   
                                @if($this->sort_order == "asc")
                                    <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                @else
                                    <i class="fa-solid fa-arrow-down-a-z fa-fw float-right mt-1"></i>
                                @endif
                                
                            @else
                                <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                            @endif
                        </p>
                    </th>
                    <th class="align-middle" scope="col" class="d-none d-sm-block"  role="button" wire:click="sort('identification')">
                        <p style="width:fit-content;"class="m-0 p-0 d-flex gap-2 ">
                            Cedula
                            @if($this->sort_by == "identification")
                                @if($this->sort_order == "asc")
                                <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                @else
                                <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                @endif
                            @else
                                <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                            @endif 
                        </p>
                        
                    </th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($data as $personal)
                    <!-- Modal -->
                    <div class="modal fade" id="modal{{$personal->identification}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal{{$personal->identification}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content p-0 m-0">
                                <div class="modal-header d-flex gap-2 align-items-center ">
                                    <i class="fa-solid fa-shield fa-xl"></i>
                                    <h5 class="modal-title" id="staticBackdropLabel">Detalles</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex flex-column gap-3 p-0 m-0">
                                    <div class="top-container container-fluid bg-dark d-flex flex-column align-items-center pt-3 pb-2 gap-2">
                                        <img style="box-shadow:0px 0px 3px black,box-shadow:0px 0px 6px #aaaa;" class="rounded-circle" src="{{asset('storage/personal_photos/photo')}}-{{$personal->identification}}.png" width="128" height="128" alt="">
                                        <div class="text-center">
                                            <h5 class="m-0 p-0" >{{$personal->name}}</h5>
                                            <p class="m-0 p-0" >{{$personal->identification}}</p>
                                        </div>
                                        @if($personal->state > 5)
                                            <div class="rounded-circle status-circle status-circle-5"></div>
                                        @else
                                            <div class="rounded-circle status-circle status-circle-{{$personal->state}}"></div>
                                        @endif
                                    </div>
                                    <div class="container-fluid">
                                        <h4>Codigo QR</h4>
                                        <img class="m-1" width="128" height="128"  src="{{asset('storage/qr-code/qrcode')}}-{{$personal->identification}}.svg" class="" alt="...">
                                    </div>
                                    <hr class="p-0 m-0">
                                    <div class="container-fluid m-0">
                                        <h4 class="">{{$personal->position_name}}</h4>
                                        <p>{{$personal->position_description}}</p>
                                    </div>
                                    <hr class="p-0 m-0">
                                    <div class="container-fluid m-0">
                                        <h4 class="">{{$personal->area_name}}</h4>
                                        <p>{{$personal->area_description}}</p>
                                    </div>
                                    <div class="container-fluid">
                                        <a href="{{route('security.personal.get',$personal->personal_id)}}" class="btn btn-primary btn-large w-50">Detalles</a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-large" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <tr>
                        <td   class="align-middle">
                            <div class="container-fluid d-flex  ">
                                <img  class="rounded-circle border" width="48" height="48" src="{{asset('storage/personal_photos/photo')}}-{{$personal->identification}}.png" alt="">
                                <div class="container-fluid d-flex flex-column d-block d-sm-none">
                                    <p class="p-0 m-0">{{$personal->name}}</p>
                                    <span style="color:gray;" class="span-gray">{{$personal->position_name}}</span>
                                </div>
                            </div>
                        </td>
                        <td  class="align-middle">
                            <p>{{$personal->identification}}</p>
                        </td>
                        <td class="align-middle">
                            @if($personal->state > 5)
                                <div class="rounded-circle status-circle status-circle-5"></div>
                            @else
                                <div class="rounded-circle status-circle status-circle-{{$personal->state}}"></div>
                            @endif
                            
                        </td>
                        <td class="align-middle">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-gear fa-lg"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" class="btn btn-primary dropdown-item" data-bs-toggle="modal" data-bs-target="#modal{{$personal->identification}}" >
                                            <i class="fa-solid fa-circle-info fa-lg"></i>
                                            Detalles
                                        </button>

                                        
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('security.personal.update.get',$personal->personal_id)}}">
                                            <i  class="fa-solid fa-pen-to-square fa-lg"></i>
                                            Actualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item disabled" href="{{route('security.personal.delete.get',$personal->personal_id)}}">
                                            <i  class="fa-solid fa-trash-can fa-lg"></i>
                                            Eliminar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{route('security.qr.get',$personal->personal_id)}}">
                                            <i class="fa-solid fa-qrcode fa-lg"></i>
                                            Generar QR
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex-fill m-0 bg-dark d-flex justify-content-center">
            <div class="d-flex align-items-center pt-4   align-items-bottom">
                {{$data->links()}}
            </div>
        </div>
    </div>

    
        
    
</div>