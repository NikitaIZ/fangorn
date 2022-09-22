<div class="flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#create{{ $this->type }}"><i class="fa-solid fa-plus mt-1"></i></button>
    <div wire:ignore.self class="modal fade" id="create{{ $this->type }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="create{{ $this->type }}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Añadir Servicio al Menú</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-8">
                            <label for="restaurant_id" class="col-form-label text-body">Restaurante o Bar</label>
                            <input class="form-control" name="restaurant_id" type="text" value="" placeholder="{{ $this->rest->name }}" disabled>
                        </div>
                        <div class="col-4">
                            <label for="type" class="col-form-label text-body">Tipo:</label>
                            <input class="form-control" name="type" type="text" value="" placeholder="{{ $this->type }}" disabled>
                        </div>
                        <div class="col-4">
                            <label for="language" class="col-form-label text-body">Idioma:</label>
                            <input class="form-control" name="language" type="text" value="" placeholder="Español" disabled>
                        </div>
                        <div class="col-8">
                            <label for="name_es" class="col-form-label text-body">Nombre:</label>
                            <input class="form-control" autocomplete="off" name="name_es" type="text" value="" wire:model.defer="name_es">
                            @error('name_es')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input class="form-control" name="language" type="text" value="" placeholder="Ingles" disabled>
                        </div>
                        <div class="col-8">
                            <input class="form-control" autocomplete="off" name="name_en" type="text" value="" wire:model.defer="name_en">
                            @error('name_en')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input class="form-control" name="language" type="text" value="" placeholder="Ruso" disabled>
                        </div>
                        <div class="col-8">
                            <input class="form-control" autocomplete="off" name="name_ru" type="text" value="" wire:model.defer="name_ru">
                            @error('name_ru')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <table class="table table-borderless m-0">
                                <tbody>
                                    <tr>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Descripciones:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch align-items-center">
                                                @if ($this->description)
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('description')" checked>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('description')">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Servicios:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch">
                                                @if ($this->service)
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('service')" checked>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('service')">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-6" colspan="2">
                                            <label class="text-secondary fs-6 fst-italic">Muestra detalles del platillo.</label>
                                        </td>
                                        <td class="col-6" colspan="2">
                                            <label class="text-secondary fs-6 fst-italic">Ofrece precios por servicios.</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Opciones:</label>
                                        </td>
                                        <td class="col-2 align-middle col">
                                            <div class="form-check form-switch">
                                                @if ($this->choice)
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('choice')" checked>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('choice')">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Paises:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch">
                                                @if ($this->country)
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('country')" checked>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('country')">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-6" colspan="2">
                                            <label class="text-secondary fs-6 fst-italic">Ej: Vino Blanco, Vino Tinto.</label>
                                        </td>
                                        <td class="col-6" colspan="2">
                                            <label class="text-secondary fs-6 fst-italic">Ej: Argentina, Chile, España.</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
