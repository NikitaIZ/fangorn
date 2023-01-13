
<div class="container-fluid ">

@livewire("security.personal.personal-data-modal")
@livewire("security.personal.personal-qr-modal")
<div class="container-fluid d-flex">
    <select style="width:fit-content;" class="form-select rounded-0" wire:model='limit' aria-label="Default select example">
        <option value="5" selected>5</option>
        <option value="10">10</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    <select  class="form-select filter-button flex-fill rounded-0" wire:model='filter_by' aria-label="Default select example">
        <option value="personals.name" selected>Nombre</option>
        <option value="personals.identification">Cedula</option>
        <option value="positions.name">Cargo</option>
    </select>
</div>
<div class="container-fluid d-flex rounded-0">
    <div class="  rounded search-box border-secondary container-fluid d-flex align-items-center m-0 p-0  rounded-0">
        <div class="m-0 p-0 search-icon-box">
            <i class="fa-solid fa-magnifying-glass fa-lg p-0 m-0"></i>
        </div>
        <div class="border-0 m-0 p-0 flex-fill  ">
            <input type="search" wire:model.lazy="search" name="search" id="search" class="search-input border-0 bg-transparent m-0 p-0" placeholder="Buscar...">
        </div>
        <div class="border-0 m-0 p-0 ">
            
        </div>
        @can('personal.create')
            <div class="border-0 m-0 p-0 ">
                <div class="container p-0">
                    <a href="{{route('security.personal.register.get')}}" class="btn btn-info  btn-large add-button-box rounded-0">
                        <i class="fa-solid fa-user-plus fa-sm"></i>
                    </a>
                </div>
            </div>
        @endcan
    </div>
</div>

<div wire:loading class="container-fluid  d-flex justify-content-center">
    <div wire:loading  class="spinner-grow text-info" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<div id="table-box" wire:init="loadPersonal" wire:loading.remove class="container-fluid table-responsive ">
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
                <th class="align-middle" scope="col" class=""  role="button" wire:click="sort('identification')">
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
                
                <tr>
                    <td class="align-middle ">
                        <div class="container-fluid d-flex  ">
                            <img  class="rounded-circle border d-none d-sm-block" width="48" height="48" src="{{asset('storage/personal_photos/photo')}}-{{$personal->identification}}.png" alt="">
                            <div class="container-fluid d-flex flex-column">
                                <p class="p-0 m-0"> {{$personal->name}}</p>
                                <span style="color:gray;" class="span-gray d-none d-sm-block">{{$personal->position_name}}</span>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        {{$personal->identification}}
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
                                @can('personal.show')
                                    <li>
                                        <a wire:click="$emitTo('security.personal.personal-data-modal','loadPersonal',{{$personal}})" role="button" class="btn btn-primary dropdown-item" data-bs-toggle="modal" data-bs-target="#data-modal" >
                                            <i class="fa-solid fa-circle-info fa-lg"></i>
                                            Detalles
                                        </a>
                                    </li>
                                @endcan
                                @can('personal.update')
                                    <li>
                                        <a class="dropdown-item" href="{{route('security.personal.update.get',$personal->personal_id)}}">
                                            <i  class="fa-solid fa-pen-to-square fa-lg"></i>
                                            Actualizar
                                        </a>
                                    </li>
                                @endcan
                                <li>
                                    <a class="dropdown-item disabled" href="#">
                                        <i  class="fa-solid fa-trash-can fa-lg"></i>
                                        Eliminar
                                    </a>
                                </li>
                                @can('personal.qr')
                                <li>
                                    <a wire:click="$emitTo('security.personal.personal-qr-modal','loadPersonalId',{{$personal->personal_id}})"  data-bs-toggle="modal" data-bs-target="#qr-modal" class="dropdown-item" href="">
                                        <i class="fa-solid fa-qrcode fa-lg"></i>
                                        Generar QR
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="flex-fill m-0 bg-dark d-flex justify-content-center mx-2">
    <div class="d-flex align-items-center pt-4   align-items-bottom">
        @if($readyToLoad)
            {{$data->links()}}
        @endif
    </div>
</div>
</div>
