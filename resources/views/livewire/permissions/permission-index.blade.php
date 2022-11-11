<div class="col-lg-10 col-12">
    <div class="card">
        <div class="card-header bg-warning p-2">
            <div class="d-flex bd-highlight">
                <div class="flex-shrink-1 pr-2">
                    <select wire:model='cant' class="form-select" aria-label="Default select example">
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="flex-grow-1 bd-highlight pr-2">
                    <input wire:model="search" class="form-control" placeholder="Ingrese Nombre" aria-label="Ingrese Nombre">
                </div>
                @can('permissions.store')
                    @livewire('permissions.permission-create', [], key('create_permission'))
                @endcan
            </div>
        </div>
        <div class="card-body p-0" wire:init='loadPermissions'>
            @if (count($permissions))
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-warning">
                            <tr>
                                <th scope="col" class="text-left col-1" role="button" tabindex="0" wire:click="order('id')">
                                    ID
                                    @if ($sort == 'id')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-left col-3" role="button" tabindex="0" wire:click="order('name')">
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
                                <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('description')">
                                    Descripción
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
                                    <th scope="col" colspan="2"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td scope="row">{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->description }}</td>
                                    @can('restaurant.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $permission->id }}" wire:click='edit({{ $permission }})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{ $permission->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $permission->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $permission->name }}</h5>
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
                                                                    <input class="form-control" name="name" type="text" wire:model="permission.name" autocomplete="off">
                                                                    @error('permission.name')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="description" class="col-form-label text-body">Descripción</label>
                                                                    <textarea class="form-control" name="description" rows="2" wire:model.defer="permission.description"></textarea>
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
                                            <button class="btn btn-outline-danger" wire:click="$emit('deletePermission', {{ $permission->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($permissions->hasPages())
                    <div class="card-footer bg-warning father">
                        <div class="child">
                            {{ $permissions->onEachSide(0)->links() }}
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
                        <div class="spinner-grow text-warning" style="width: 5rem; height: 5rem;" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>