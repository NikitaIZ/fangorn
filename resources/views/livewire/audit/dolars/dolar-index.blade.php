<div class="col-lg-10 col-12">
    <div class="card" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
        <div class="card-header bg-success p-2">
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
                @can('dolar.edit')
                    @livewire('audit.dolars.dolar-create', [], key('create_dolar'))
                @endcan
            </div>
        </div>
        <div class="card-body p-0" wire:init='loadDolars'>
            @if (count($dolars))
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-success" style="color: #28a745">
                            <tr>
                                <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('user')" style="min-width: 10rem;">
                                    Usuario
                                    @if ($sort == 'user')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" role="button" tabindex="0" wire:click="order('date')" style="min-width: 7rem;">
                                    Fecha
                                    @if ($sort == 'date')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-calendar fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-regular fa-calendar fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" role="button" tabindex="0" wire:click="order('daily_rate')" style="min-width: 10rem;">
                                    Cambio
                                    @if ($sort == 'daily_rate')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" role="button" tabindex="0" wire:click="order('updated_at')" style="min-width: 11rem;">
                                    Añadido
                                    @if ($sort == 'updated_at')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-calendar-plus fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-regular fa-calendar-plus fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                @can('dolar.edit')
                                    <th scope="col" colspan="2"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($dolars as $dolar)
                                <tr>
                                    <td scope="row">{{ $dolar->user }}</td>
                                    <td class="text-center align-middle">{{ $dolar->date }}</td>
                                    <td class="text-center align-middle">{{ number_format($dolar->daily_rate, 2, ',')}} Bs</td>
                                    <td class="text-center align-middle">{{ $dolar->time }}</td>
                                    @can('dolar.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{$dolar->id}}" wire:click='edit({{$dolar}})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{$dolar->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{$dolar->id}}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $dolar->name }}</h5>
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
                                                                <div class="col-6">
                                                                    <label for="daily_rate" class="col-form-label text-body">Cambio (Bs):</label>
                                                                    <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="1" wire:model.defer="dolar.daily_rate" autocomplete="off" step=".01">
                                                                    @error('dolar.daily_rate')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, añada un numero
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="date" class="col-form-label text-body">Fecha:</label>
                                                                    <input class="form-control" autocomplete="off" name="price" type="date" wire:model.defer="dolar.date" autocomplete="off">
                                                                    @error('dolar.date')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, añada una fecha
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
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-danger" wire:click="$emit('deleteDolar', {{ $dolar->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-success father">
                <div class="child">
                    {{ $dolars->onEachSide(0)->links() }}
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
                        <div class="spinner-grow text-success" style="width: 5rem; height: 5rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>