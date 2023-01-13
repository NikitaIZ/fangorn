<div class="col-lg-10 col-12">
    <div class="d-flex bd-highlight pb-2">
        <div class="d-flex pr-2">
            @can('hotels.edit')
                @livewire('marketing.hotels.type-create', key('new_hotel_type'))
            @endcan
        </div>
    </div>
    <div class="card" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
        <div class="card-header bg-info">
            <div class="d-flex bd-highlight">
                <div class="flex-grow-1 bd-highlight pr-2">
                    <input wire:model="search" class="form-control" placeholder="Ingrese Nombre" aria-label="Ingrese Nombre">
                </div>
                
            </div>
        </div>
        <div class="card-body p-0" wire:init='loadHotels'>
            @if (count($hotels))
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
                                @can('hotels.edit')
                                    <th scope="col" colspan="2"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($hotels as $hotel)
                                <tr>
                                    <td scope="row">{{ $hotel->name }}</td>
                                    @can('hotels.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $hotel->id }}" wire:click='edit({{ $hotel }})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{ $hotel->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $hotel->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $hotel->name }}</h5>
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
                                                                    <input class="form-control" name="name" type="text" wire:model="hotel.name" autocomplete="off">
                                                                    @error('hotel.name')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="color" class="col-form-label text-body">Color:</label>
                                                                    <input class="form-control" name="color" type="color" wire:model.defer="hotel.color">
                                                                    @error('color')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, elija un color
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="type_id" class="col-form-label text-body">Tipo:</label>
                                                                    <select class="form-select" wire:model.defer="hotel.type_id" aria-label="Default select example">
                                                                        <option value="">Seleccione</option>
                                                                        @foreach ($types_list as $type_option)
                                                                            <option value="{{ $type_option->id }}">{{ $type_option->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('hotel.type_id')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, Elija un tipo de servicio
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12 text-center">
                                                                    <h5 class="text-body">Estrellas: {{ $this->stars }}
                                                                        @if ($this->stars == 0)
                                                                            <input id="{{ $this->input_id }}_6" type="radio" name="stars" value="0" wire:click='stars(0)' checked>
                                                                            <label for="{{ $this->input_id }}_6">0</label>
                                                                        @else
                                                                            <input id="{{ $this->input_id }}_6" type="radio" name="stars" value="0" wire:click='stars(0)'>
                                                                            <label for="{{ $this->input_id }}_6">0</label>
                                                                        @endif
                                                                    </h5>
                                                                    <dot:RadioButton id="{{ $this->input_id }}_5" CheckedItem="{value: Rating}" CheckedValue="5" />
                                                                    <label for="{{ $this->input_id }}_5" title="5 Stars">5</label>

                                                                    <dot:RadioButton id="{{ $this->input_id }}_4" CheckedItem="{value: Rating}" CheckedValue="4" />
                                                                    <label for="{{ $this->input_id }}_4" title="4 Stars">4</label>

                                                                    <dot:RadioButton id="{{ $this->input_id }}_3" CheckedItem="{value: Rating}" CheckedValue="3" />
                                                                    <label for="{{ $this->input_id }}_3" title="3 Stars">3</label>

                                                                    <dot:RadioButton id="{{ $this->input_id }}_2" CheckedItem="{value: Rating}" CheckedValue="2" />
                                                                    <label for="{{ $this->input_id }}_2" title="2 Stars">2</label>

                                                                    <dot:RadioButton id="{{ $this->input_id }}_1" CheckedItem="{value: Rating}" CheckedValue="1" />
                                                                    <label for="{{ $this->input_id }}_1" title="1 Stars">1</label>
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
                                            <button class="btn btn-outline-danger" wire:click="$emit('deleteHotel', {{ $hotel->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($hotels->hasPages())
                    <div class="card-footer bg-info father">
                        <div class="child">
                            {{ $hotels->onEachSide(0)->links() }}
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
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
