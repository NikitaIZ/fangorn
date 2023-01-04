<div class="col-lg-10 col-12">
    <div class="card" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
        <div class="card-header bg-info p-2">
            <div class="d-flex bd-highlight">
                <div class="flex-shrink-1 pr-1">
                    <select class="form-select" wire:model='cant' aria-label="Default select example">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="flex-grow-1 bd-highlight pr-1">
                    <input wire:model="search" class="form-control" placeholder="Ingrese Usuario o Fecha">
                </div>
            </div>
        </div>
        <div class="card-body p-0" wire:init='loadUsers'>
            @if (count($users))
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-info">
                            <tr>
                                <th scope="col" class="col-auto" role="button" tabindex="0" wire:click="order('id')">
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
                                <th scope="col" class="col-auto" role="button" tabindex="0" wire:click="order('name')" style="min-width: 10rem;">
                                    Nombre y Apellido
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
                                <th scope="col" class="col-auto" role="button" tabindex="0" wire:click="order('email')" style="min-width: 7rem;">
                                    Email
                                    @if ($sort == 'email')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" role="button" tabindex="0" wire:click="order('role')" style="min-width: 11rem;">
                                    Role
                                    @if ($sort == 'role')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                @can('dolar.edit')
                                    <th scope="col"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($users as $user)
                                <tr>
                                    <td scope="row">
                                        {{ $user->id }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $user->name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $user->email }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $user->role }}
                                    </td>
                                    @can('dolar.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{$user->id}}" wire:click='edit({{$user->id}})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{$user->id}}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $user->name }}</h5>
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
                                                                    <label for="name" class="col-form-label text-body">Nombre y Apellido</label>
                                                                    <input class="form-control" autocomplete="off" name="name" type="email" wire:model.defer="user.name">
                                                                    @error('user.name')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, añada un nombre
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="email" class="col-form-label text-body">Correo</label>
                                                                    <input class="form-control" autocomplete="off" name="email" wire:model.defer="user.email">
                                                                    @error('user.email')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, añada un email
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="password" class="col-form-label text-body">Cambiar contraseña</label>
                                                                    <input class="form-control" autocomplete="off" name="password" type="password" wire:model.defer="">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="role" class="col-form-label text-body">Role</label>
                                                                    <select class="form-select" wire:model.defer="user.role" aria-label="Default select example">
                                                                        <option value="">Seleccione</option>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
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
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-info father">
                <div class="child">
                    {{ $users->onEachSide(0)->links() }}
                </div>
            </div>
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