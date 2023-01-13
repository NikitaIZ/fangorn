<div class="col-12 col-sm-8">
    <div class="card" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
        <div class="card-header bg-info">
            <div class="input-group pt-3 pb-2">
                <div class="flex-grow-1 bd-highlight pr-2">
                    <input wire:model="search" class="form-control" placeholder="Ingrese Servicio" aria-label="Ingrese Servicio">
                </div>
                @can('buffet.edit')
                    @livewire('audit.buffet-create', [], key('create_buffet'))
                @endcan
            </div>
        </div>
        <div class="card-body p-0" wire:init='loadBuffets'>
            @if (count($buffets))
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-info" style="color: #17a2b8">
                            <tr>
                                <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('service')" style="min-width: 10rem;">
                                    Servicio
                                    @if ($sort == 'service')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('adults')" style="min-width: 8rem;">
                                    Adultos
                                    @if ($sort == 'adults')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('children')" style="min-width: 8rem;">
                                    Niños
                                    @if ($sort == 'children')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                @can('buffet.edit')
                                    <th scope="col" colspan="2"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($buffets as $buffet)
                                <tr>
                                    <td scope="row">
                                        {{ $buffet->service }}
                                    </td>
                                    <td class="text-center align-middle" width="10px">
                                        {{ $buffet->adults }}$
                                    </td>
                                    <td class="text-center align-middle" width="10px">
                                        {{ $buffet->children }}$
                                    </td>
                                    @can('buffet.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $buffet->id }}" wire:click='edit({{ $buffet }})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{ $buffet->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $buffet->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $buffet->service }}</h5>
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
                                                                    <label for="service" class="col-form-label text-body">Nombre:</label>
                                                                    <input class="form-control" name="name" type="text" wire:model="buffet.service" autocomplete="off">
                                                                    @error('buffet.service')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="adults" class="col-form-label text-body">Precio para Adultos:</label>
                                                                    <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="1" wire:model.defer="buffet.adults" autocomplete="off" step=".01">
                                                                    @error('buffet.adults')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, añada un numero
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="children" class="col-form-label text-body">Precio para Niños:</label>
                                                                    <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="1" wire:model.defer="buffet.children" autocomplete="off" step=".01">
                                                                    @error('buffet.children')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, añada un numero
                                                                        </span>
                                                                    @enderror
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
                                            <button class="btn btn-outline-danger" wire:click="$emit('deleteBuffet', {{ $buffet->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($buffets->hasPages())
                    <div class="card-footer bg-info father">
                        <div class="child">
                            {{ $buffets->onEachSide(0)->links() }}
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
