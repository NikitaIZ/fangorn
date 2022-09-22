<div class="card box-shadow m-0">
    <div class="card-header bg-info p-2">
        <div class="d-flex bd-highlight">
            <div class="flex-shrink-1 pr-2">
                <select class="form-select" wire:model='cant' aria-label="Default select example">
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="flex-grow-1 bd-highlight pr-2">
                <input class="form-control" aria-label="Ingrese Nombre" placeholder="Ingrese Nombre" wire:model="search">
            </div>
            @can('plate.edit')
                @livewire('audit.restaurants.plates.plate-create', ['lang' => $this->lang, 'rest' => $this->rest, 'menu' => $this->menu, 'country_id' => $this->country, 'choice_id' => $this->choice, 'create' => 'create'], key($this->menu->id))
            @endcan
        </div>
    </div>
    <div class="card-body p-0" wire:init='loadPlates'>
        @if (count($plates_list))
            <div class="table-responsive">
                <table class="table table-striped m-0">
                    <thead class="table-info" style="color: #17a2b8">
                        <tr>
                            <th scope="col" class="text-left col-auto" role="button" tabindex="0" style="width: 1rem;">
                                Estado
                            </th>
                            <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('{{ $this->name }}')" style="min-width: 20rem;">
                                Nombre
                                @if ($sort == '{{ $this->name }}')
                                    @if ($direction == 'asc')
                                        <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                    @else
                                        <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                @endif
                            </th>
                            @if ($this->menu->description)
                                <th scope="col" class="text-left col-7" role="button" tabindex="0" wire:click="order('{{ $this->description }}')" style="min-width: 20rem;">
                                    Descripción
                                    @if ($sort == '{{ $this->description }}')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                            @endif
                            <th scope="col" class="text-left col-1" role="button" tabindex="0" wire:click="order('price')" style="min-width: 6rem;">
                                Precio
                                @if ($sort == 'price')
                                    @if ($direction == 'asc')
                                        <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                    @else
                                        <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                    @endif
                                @else
                                    <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                @endif
                            </th>
                            @if ($this->menu->service)
                                <th scope="col" class="text-left col-1" role="button" tabindex="0" wire:click="order('service')" style="min-width: 8rem;">
                                    Servicio
                                    @if ($sort == 'service')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                            @endif
                            @can('plate.edit')
                                <th scope="col" colspan="2"></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($plates_list as $plate_option)
                            <tr>
                                <td scope="row" class="align-middle">
                                    @if ($plate_option->status)
                                        <div class="form-check form-switch float-right">
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click='enabled({{ $plate_option->id }})' checked>
                                        </div>
                                    @else
                                        <div class="form-check form-switch float-right">
                                            <input class="form-check-input" type="checkbox" wire:click='enabled({{ $plate_option->id }})' role="switch">
                                        </div>
                                    @endif
                                </td>
                                @switch($this->lang)
                                    @case('es')
                                        <td class="align-middle">{{ $plate_option->name_es }}</td>
                                    @break
                                    @case('en')
                                        <td class="align-middle">{{ $plate_option->name_en }}</td>
                                    @break
                                    @case('ru')
                                        <td class="align-middle">{{ $plate_option->name_ru }}</td>
                                    @break
                                @endswitch
                                @if ($this->menu->description)
                                @switch($this->lang)
                                    @case('es')
                                        <td class="align-middle">{{ $plate_option->description_es }}</td>
                                    @break
                                    @case('en')
                                        <td class="align-middle">{{ $plate_option->description_en }}</td>
                                    @break
                                    @case('ru')
                                        <td class="align-middle">{{ $plate_option->description_ru }}</td>
                                    @break
                                @endswitch
                                @endif
                                @if ($plate_option->price == null || $plate_option->price == 0)
                                    <td class="text-center align-middle"></td>
                                @else
                                    <td class="text-center align-middle">{{ round($plate_option->price, 2) }}$</td>
                                @endif
                                @if ($this->menu->service)
                                    @if ($plate_option->service == null || $plate_option->service == 0)
                                        <td class="text-center align-middle"></td>
                                    @else
                                        <td class="text-center align-middle">{{ round($plate_option->service, 2) }}$</td>
                                    @endif
                                @endif
                                @can('plate.edit')
                                    <td width="10px" class="align-middle">
                                        <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $plate_option->id }}" wire:click='edit({{ $plate_option }})'><i class="fa-solid fa-pen-to-square"></i></button>
                                        <div wire:ignore.self class="modal fade" id="Modal{{ $plate_option->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $plate_option->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $plate_option->name_es }}</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid" wire:loading wire:target='edit'>
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border text-info" role="status">
                                                                    <span class="visually-hidden">Cargando...</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 align-items-center" wire:loading.remove wire:target='edit'>
                                                            @if ($this->lang == 'es')
                                                                <button class="accordion-button bg-light px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseSpanish" role="button" aria-expanded="false" aria-controls="collapseSpanish">
                                                                    Español
                                                                </button>
                                                                <div class="col-12 collapse show" id="collapseSpanish">
                                                            @else
                                                                <button class="accordion-button bg-light collapsed px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseSpanish" role="button" aria-expanded="false" aria-controls="collapseSpanish">
                                                                    Español
                                                                </button>
                                                                <div class="col-12 collapse" id="collapseSpanish">
                                                            @endif
                                                                <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->menu->name_es }}" disabled>
                                                                <label for="name_es" class="col-form-label text-body">Nombre:</label>
                                                                <input class="form-control" name="name_es" type="text" wire:model.defer="plate.name_es" autocomplete="off">
                                                                @error('plate.name_es')
                                                                    <span class="fs-6 text-danger fst-italic">
                                                                        Por favor, rellene el campo Nombre
                                                                    </span>
                                                                @enderror
                                                                @if ($this->menu->description)
                                                                    <label for="description_es" class="col-form-label text-body">Descripción</label>
                                                                    <textarea class="form-control" name="description_es" rows="2" wire:model.defer="plate.description_es"></textarea>
                                                                @endif
                                                            </div>
                                                            @if ($this->lang == 'en')
                                                                <button class="accordion-button bg-light px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseEnglish" role="button" aria-expanded="false" aria-controls="collapseEnglish">
                                                                    Ingles
                                                                </button>
                                                                <div class="col-12 collapse show" id="collapseEnglish">
                                                            @else
                                                                <button class="accordion-button bg-light collapsed px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseEnglish" role="button" aria-expanded="false" aria-controls="collapseEnglish">
                                                                    Ingles
                                                                </button>
                                                                <div class="col-12 collapse" id="collapseEnglish">
                                                            @endif
                                                                <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->menu->name_en }}" disabled>
                                                                <label for="name_en" class="col-form-label text-body">Nombre:</label>
                                                                <input class="form-control" name="name_en" type="text" wire:model.defer="plate.name_en" autocomplete="off">
                                                                @error('plate.name_en')
                                                                    <span class="fs-6 text-danger fst-italic">
                                                                        Por favor, rellene el campo Nombre
                                                                    </span>
                                                                @enderror
                                                                @if ($this->menu->description)
                                                                    <label for="description_en" class="col-form-label text-body">Descripción</label>
                                                                    <textarea class="form-control" name="description_en" rows="2" wire:model.defer="plate.description_en"></textarea>
                                                                @endif
                                                            </div>
                                                            @if ($this->lang == 'ru')
                                                                <button class="accordion-button bg-light px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseRussian" role="button" aria-expanded="false" aria-controls="collapseRussian">
                                                                    Ruso
                                                                </button>
                                                                <div class="col-12 collapse show" id="collapseRussian">
                                                            @else
                                                                <button class="accordion-button bg-light collapsed px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseRussian" role="button" aria-expanded="false" aria-controls="collapseRussian">
                                                                    Ruso
                                                                </button>
                                                                <div class="col-12 collapse" id="collapseRussian">
                                                            @endif
                                                                <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->menu->name_ru }}" disabled>
                                                                <label for="name_ru" class="col-form-label text-body">Nombre:</label>
                                                                <input class="form-control" name="name_ru" type="text" wire:model.defer="plate.name_ru" autocomplete="off">
                                                                @error('plate.name_ru')
                                                                    <span class="fs-6 text-danger fst-italic">
                                                                        Por favor, rellene el campo Nombre
                                                                    </span>
                                                                @enderror
                                                                @if ($this->menu->description)
                                                                    <label for="description_ru" class="col-form-label text-body">Descripción</label>
                                                                    <textarea class="form-control" name="description_ru" rows="2" wire:model.defer="plate.description_ru"></textarea>
                                                                @endif
                                                            </div>
                                                            <div class="col-6">
                                                                <label for="price" class="col-form-label text-body">Precio:</label>
                                                                <input class="form-control" name="price" type="number" value="0.00" min="1" wire:model.defer="plate.price" autocomplete="off" step=".01">
                                                                @error('plate.price')
                                                                    <span class="fs-6 text-danger fst-italic">
                                                                        Por favor, rellene el campo Precio
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            @if ($this->menu->service)
                                                                <div class="col-6">
                                                                    <label for="service" class="col-form-label text-body">Servicio:</label>
                                                                    <input class="form-control" name="service" type="number" min="0" wire:model.defer="plate.service" autocomplete="off">
                                                                </div>
                                                            @endif
                                                            @if ($this->menu->country)
                                                                <div class="col-6">
                                                                    <label for="country_id" class="col-form-label text-body">Pais:</label>
                                                                    <select class="form-select" wire:model.defer="plate.country_id" aria-label="Default select example">
                                                                        <option value=plate.country_id selected>Selecione un Pais</option>
                                                                        @foreach ($country_list as $country_option)
                                                                            @switch($this->lang)
                                                                                @case('es')
                                                                                    <option value="{{ $country_option->id }}">{{ $country_option->name_es }}</option>
                                                                                @break
                                                                                @case('en')
                                                                                    <option value="{{ $country_option->id }}">{{ $country_option->name_en }}</option>
                                                                                @break
                                                                                @case('ru')
                                                                                    <option value="{{ $country_option->id }}">{{ $country_option->name_ru }}</option>
                                                                                @break
                                                                            @endswitch
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                            @if ($this->menu->choice)
                                                                <div class="col-6">
                                                                    <label for="choice_id" class="col-form-label text-body">Opcion:</label>
                                                                    <select class="form-select" wire:model.defer="plate.choice_id" aria-label="Default select example">
                                                                        <option value=plate.choice_id selected>Selecione una Opcion</option>
                                                                        @foreach ($choice_list as $choice_option)
                                                                            @switch($this->lang)
                                                                                @case('es')
                                                                                    <option value="{{ $choice_option->id }}">{{ $choice_option->name_es }}</option>
                                                                                @break
                                                                                @case('en')
                                                                                    <option value="{{ $choice_option->id }}">{{ $choice_option->name_en }}</option>
                                                                                @break
                                                                                @case('ru')
                                                                                    <option value="{{ $choice_option->id }}">{{ $choice_option->name_ru }}</option>
                                                                                @break
                                                                            @endswitch
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
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
                                        <button class="btn btn-outline-danger" wire:click="$emit('deletePlate', {{ $plate_option->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($plates_list->hasPages())
                <div class="card-footer bg-info father">
                    <div class="child">
                        {{ $plates_list->onEachSide(0)->links() }}
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