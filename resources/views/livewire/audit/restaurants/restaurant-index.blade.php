<div class="col-lg-10 col-12">
    <div class="card" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
        <div class="card-header bg-info">
            <div class="input-group pt-3 pb-2">
                <div class="flex-grow-1 bd-highlight pr-2">
                    <input wire:model="search" class="form-control" placeholder="Ingrese Nombre" aria-label="Ingrese Nombre">
                </div>
                @can('restaurant.edit')
                    @livewire('audit.restaurants.restaurant-create', [], key('create_restaurant'))
                @endcan
            </div>
        </div>
        <div class="card-body p-0" wire:init='loadRestaurants'>
            @if (count($restaurants))
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-info" style="color: #17a2b8">
                            <tr>
                                <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('name')" style="min-width: 15rem;">
                                    Nombre
                                    @if ($sort == 'name')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                @can('restaurant.edit')
                                    <th scope="col" colspan="3"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td scope="row">{{ $restaurant->name }}</td>
                                    <td class="text-center align-middle" width="10px">
                                        <a class="btn btn-outline-primary" href="{{ route('audit.menus.index', ['lang' => 'es', 'id' => $restaurant->id]) }}"><i class="fa-solid fa-hand-pointer"></i></a>
                                    </td>
                                    @can('restaurant.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $restaurant->id }}" wire:click='edit({{ $restaurant }})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{ $restaurant->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $restaurant->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $restaurant->name }}</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid" wire:loading wire:target='edit'>
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="spinner-border text-info" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center" wire:loading.remove wire:target='edit'>
                                                                <div class="col-12">
                                                                    <label for="name" class="col-form-label text-body">Nombre:</label>
                                                                    <input class="form-control" name="name" type="text" wire:model="restaurant.name" autocomplete="off">
                                                                    @error('restaurant.name')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="d-flex bd-highlight align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <label class="col-form-label text-body mr-4">Comida:</label>
                                                                            <div class="ml-2 form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" role="switch" wire:model="restaurant.food">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="d-flex bd-highlight align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <label class="col-form-label text-body mr-4">Bebida:</label>
                                                                            <div class="ml-2 form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" role="switch" wire:model="restaurant.drink">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="d-flex bd-highlight align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <label class="col-form-label text-body mr-4">Cóctel:</label>
                                                                            <div class="ml-2 form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" role="switch" wire:model="restaurant.coctel">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-info">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click='update' wire:loading.remove wire:target='update'>Actualizar</button>
                                                            <span class="text-body" wire:loading wire:target='update'>Cargando...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="10px">
                                            <button class="btn btn-outline-danger" wire:click="$emit('deleteRestaurant', {{ $restaurant->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($restaurants->hasPages())
                    <div class="card-footer bg-info father">
                        <div class="child">
                            {{ $restaurants->onEachSide(0)->links() }}
                        </div>
                    </div>
                @endif
            @else
                @if ($this->readyToLoad)
                    <div class="p-4 text-center">
                        <strong>
                            No hay registro
                        </strong>
                    </div>
                @else
                    <div class="p-4 d-flex justify-content-center">
                        <div class="spinner-grow text-info" style="width: 5rem; height: 5rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
