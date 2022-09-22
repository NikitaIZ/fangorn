<div class="flex-shrink-1">
    <button class="btn btn-purple fw-bold" type="button" data-bs-toggle="modal" data-bs-target="#createChoice"><i class="fa-fw fa-regular fa-rectangle-list"></i> Opción</button>
    <div wire:ignore.self class="modal fade" id="createChoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createChoiceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-purple">
                    @if ($this->create)
                        <h5 class="modal-title"><i class="fa-regular fa-rectangle-list fa-fw"></i> Añadir Opción</h5>
                        <button class="btn btn-danger btn-sm fw-bold float-right" type="button" wire:click='change'><i class="fa-solid fa-trash-can"></i></button>
                    @else
                        <h5 class="modal-title"><i class="fa-regular fa-rectangle-list fa-fw"></i> Añadir Opción</h5>
                        <button class="btn btn-light btn-sm fw-bold float-right" type="button" wire:click='change'><i class="fa-solid fa-plus"></i></button>
                    @endif
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        @if ($this->create)
                            <div class="col-6">
                                <label for="menu_id" class="col-form-label text-body">Español:</label>
                                <input class="form-control" name="menu_id" type="text" value="" placeholder="{{ $this->menu->name_es }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="name_es" class="col-form-label text-body">Nombre:</label>
                                <input class="form-control" autocomplete="off" name="name_es" type="text" value="" wire:model="name_es">
                                @error('name_es')
                                    <span class="fs-6 text-danger fst-italic">
                                        Por favor, rellene el campo Nombre
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="menu_id" class="col-form-label text-body">Ingles:</label>
                                <input class="form-control" name="menu_id" type="text" value="" placeholder="{{ $this->menu->name_en }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="name_en" class="col-form-label text-body">Nombre:</label>
                                <input class="form-control" autocomplete="off" name="name_en" type="text" value="" wire:model="name_en">
                                @error('name_en')
                                    <span class="fs-6 text-danger fst-italic">
                                        Por favor, rellene el campo Nombre
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="menu_id" class="col-form-label text-body">Ruso:</label>
                                <input class="form-control" name="menu_id" type="text" value="" placeholder="{{ $this->menu->name_ru }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="name_ru" class="col-form-label text-body">Nombre:</label>
                                <input class="form-control" autocomplete="off" name="name_ru" type="text" value="" wire:model="name_ru">
                                @error('name_ru')
                                    <span class="fs-6 text-danger fst-italic">
                                        Por favor, rellene el campo Nombre
                                    </span>
                                @enderror
                            </div>
                        @else
                            <div class="col-12">
                                <label for="choice" class="col-form-label text-body">Opción:</label>
                                <select class="form-select" wire:model="choice" aria-label="Default select example">
                                    <option value="">Seleccione</option>
                                    @foreach ($choices_list as $choice_option)
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
                <div class="modal-footer bg-purple">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    @if ($this->create)
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" wire:click='save' wire:loading.remove wire:target='save'>Añadir</button>
                        <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                    @else
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" wire:click='delete' wire:loading.remove wire:target='save'>Eliminar</button>
                        <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>