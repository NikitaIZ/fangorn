<div class="flex-shrink-1">
    @if ($this->list)
        <button class="btn btn-success fw-bold" type="button" data-bs-toggle="modal" data-bs-target="#create{{ $this->choice_id . $this->country_id }}"><i class="fa-fw fa-solid fa-plus mt-1"></i>Añadir</button>
    @else
        <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#create{{ $this->choice_id . $this->country_id }}"><i class="fa-solid fa-plus mt-1"></i></button>
    @endif
    <div wire:ignore.self class="modal fade" id="create{{ $this->choice_id . $this->country_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="create{{ $this->choice_id . $this->country_id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Añadir elemento al Menú</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        @if ($this->lang == 'es')
                            <button class="accordion-button bg-light px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseSpanish{{ $this->create . $this->choice_id . $this->country_id }}" role="button" aria-expanded="false" aria-controls="collapseSpanish{{ $this->create . $this->choice_id . $this->country_id }}">
                                Español
                            </button>
                            <div class="col-12 collapse show" id="collapseSpanish{{ $this->create . $this->choice_id . $this->country_id }}">
                        @else
                            <button class="accordion-button bg-light collapsed px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseSpanish{{ $this->create . $this->choice_id . $this->country_id }}" role="button" aria-expanded="false" aria-controls="collapseSpanish{{ $this->create . $this->choice_id . $this->country_id }}">
                                Español
                            </button>
                            <div class="col-12 collapse" id="collapseSpanish{{ $this->create . $this->choice_id . $this->country_id }}">
                        @endif
                            <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->menu->name_es }}" disabled>
                            <label for="name_es" class="col-form-label text-body">Nombre:</label>
                            <input class="form-control" name="name_es" type="text" wire:model.defer="name_es" autocomplete="off">
                            @error('name_es')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                            @if ($this->menu->description)
                                <label for="description_es" class="col-form-label text-body">Descripción</label>
                                <textarea class="form-control" name="description_es" rows="2" wire:model.defer="description_es"></textarea>
                            @endif
                        </div>
                        @if ($this->lang == 'en')
                            <button class="accordion-button bg-light px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseEnglish{{ $this->create . $this->choice_id . $this->country_id }}" role="button" aria-expanded="false" aria-controls="collapseEnglish{{ $this->create . $this->choice_id . $this->country_id }}">
                                Ingles
                            </button>
                            <div class="col-12 collapse show" id="collapseEnglish{{ $this->create . $this->choice_id . $this->country_id }}">
                        @else
                            <button class="accordion-button bg-light collapsed px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseEnglish{{ $this->create . $this->choice_id . $this->country_id }}" role="button" aria-expanded="false" aria-controls="collapseEnglish{{ $this->create . $this->choice_id . $this->country_id }}">
                                Ingles
                            </button>
                            <div class="col-12 collapse" id="collapseEnglish{{ $this->create . $this->choice_id . $this->country_id }}">
                        @endif
                            <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->menu->name_en }}" disabled>
                            <label for="name_en" class="col-form-label text-body">Nombre:</label>
                            <input class="form-control" name="name_en" type="text" wire:model.defer="name_en" autocomplete="off">
                            @error('name_en')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                            @if ($this->menu->description)
                                <label for="description_en" class="col-form-label text-body">Descripción</label>
                                <textarea class="form-control" name="description_en" rows="2" wire:model.defer="description_en"></textarea>
                            @endif
                        </div>
                        @if ($this->lang == 'ru')
                            <button class="accordion-button bg-light px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseRussian{{ $this->create . $this->choice_id . $this->country_id }}" role="button" aria-expanded="false" aria-controls="collapseRussian{{ $this->create . $this->choice_id . $this->country_id }}">
                                Ruso
                            </button>
                            <div class="col-12 collapse show" id="collapseRussian{{ $this->create . $this->choice_id . $this->country_id }}">
                        @else
                            <button class="accordion-button bg-light collapsed px-3 py-2" type="button" data-bs-toggle="collapse" href="#collapseRussian{{ $this->create . $this->choice_id . $this->country_id }}" role="button" aria-expanded="false" aria-controls="collapseRussian{{ $this->create . $this->choice_id . $this->country_id }}">
                                Ruso
                            </button>
                            <div class="col-12 collapse" id="collapseRussian{{ $this->create . $this->choice_id . $this->country_id }}">
                        @endif
                            <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->menu->name_ru }}" disabled>
                            <label for="name_ru" class="col-form-label text-body">Nombre:</label>
                            <input class="form-control" name="name_ru" type="text" wire:model.defer="name_ru" autocomplete="off">
                            @error('name_ru')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                            @if ($this->menu->description)
                                <label for="description_ru" class="col-form-label text-body">Descripción</label>
                                <textarea class="form-control" name="description_ru" rows="2" wire:model.defer="description_ru"></textarea>
                            @endif
                        </div>
                        
                        <div class="col-6">
                            <label for="price" class="col-form-label text-body">Precio:</label>
                            <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="0" wire:model.defer="price" autocomplete="off" step=".01">
                            @error('price')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Precio
                                </span>
                            @enderror
                        </div>
                        @if ($this->menu->service)
                            <div class="col-6">
                                <label for="service" class="col-form-label text-body">Servicio:</label>
                                <input class="form-control" name="service" type="number" value="" min="1" wire:model.defer="service" autocomplete="off" step=".01">
                            </div>
                        @endif
                        @if ($this->choices)
                            <div class="col">
                                <label for="choice_id" class="col-form-label text-body">Opción:</label>
                                <select class="form-select" wire:model.defer="choice_id" aria-label="Default select example">
                                    <option value="">Seleccione</option>
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
                            @error('choice_id')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, Elije una Opción
                                </span>
                            @enderror
                        @elseif ($this->choice_id)
                            <div class="col">
                                <label for="choice_id" class="col-form-label text-body">Opción:</label>
                                <input class="form-control" type="text" placeholder="{{ $choice }}" disabled>
                                <input class="invisible d-none" name="choice_id" type="number" wire:model.defer="choice_id">
                            </div>
                        @endif
                        @if ($this->countries)
                            <div class="col-6">
                                <label for="country_id" class="col-form-label text-body">País:</label>
                                <select class="form-select" wire:model.defer="country_id" aria-label="Default select example">
                                    <option value="">Seleccione</option>
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
                            @error('country_id')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, Elije un País
                                </span>
                            @enderror
                        @elseif ($this->country_id)
                            <div class="col-6">
                                <label for="country_id" class="col-form-label text-body">País:</label>
                                <input class="form-control" type="text" placeholder="{{ $country }}" disabled>
                                <input class="invisible d-none" name="country_id" type="number" wire:model.defer="country_id">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click='save' wire:loading.remove wire:target='save'>Añadir</button>
                    <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>