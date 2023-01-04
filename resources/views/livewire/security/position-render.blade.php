<div class="container-fluid">


    <div class="container-fluid d-flex rounded-0">
        <div class="  rounded search-box border-secondary container-fluid d-flex align-items-center m-0 p-0  rounded-0">
            <div class="m-0 p-0 search-icon-box">
                <i class="fa-solid fa-magnifying-glass fa-lg p-0 m-0"></i>
            </div>
            <div class="border-0 m-0 p-0 flex-fill  ">
                <input type="search" wire:model="search" name="search" id="search" class="search-input border-0 bg-transparent m-0 p-0" placeholder="Buscar...">
            </div>
           
            <div class="border-0 m-0 p-0 ">
                <div class="container p-0">
                    <a href="{{route('security.position.register.get')}}" class="btn btn-info  btn-large add-button-box rounded-0">
                    <i class="fa-solid fa-plus fa-sm"></i>
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
        <table class="table table-striped border rounded-0 m-0 table-fixed">
            <thead>
                <tr>
                    <th scope="col" role="button" class="align-middle" wire:click="sort('name')">
                        <p style="width:fit-content;" class="p-0 m-0 d-flex gap-2">
                        Title
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
                    <th  scope="col" class=""  role="button" wire:click="sort('identification')">
                        Descripcion
                       
                    </th>
                    <th  scope="col" class=""  role="button" wire:click="sort('identification')">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $position)
                    <tr>
                        <td   class="align-middle">
                            {{$position->name}}
                        </td>
                        <td  class="align-middle">
                            {{$position->description}}
                        </td>
                        <td class="align-middle">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-gear fa-lg"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{route('security.position.update.get',$position->id)}}">
                                            <i  class="fa-solid fa-pen-to-square fa-lg"></i>
                                            Actualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item disabled" href="">
                                            <i  class="fa-solid fa-trash-can fa-lg"></i>
                                            Eliminar
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