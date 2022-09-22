<div class="flex-shrink-1">
    <button class="btn btn-secondary fw-bold float-right" type="button" data-bs-toggle="modal" data-bs-target="#updateMenu"><i class="fa-solid fa-gear"></i></button>
    <div wire:ignore.self class="modal fade" id="updateMenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateMenuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title"><i class="fa-solid fa-gear fa-fw"></i>Ajustes de Menú</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-8">
                            <label for="menu_id" class="col-form-label text-body">Para:</label>
                            <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->rest }}" disabled>
                        </div>
                        <div class="col-4">
                            <label for="type" class="col-form-label text-body">Tipo:</label>
                                <select class="form-select" wire:model="menu.type" aria-label="Default select example">
                                    <option value="">Seleccione</option>
                                    <option value="comida">Comida</option>
                                    <option value="bebida">Bebida</option>
                                    <option value="coctel">Cóctel</option>
                                </select>
                            @error('menu.type')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, Elija un tipo de servicio
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="language" class="col-form-label text-body">Idioma:</label>
                            <input class="form-control" name="language" type="text" value="" placeholder="Español" disabled>
                        </div>
                        <div class="col-8">
                            <label for="name_es" class="col-form-label text-body">Nombre:</label>
                            <input class="form-control" name="name_es" type="text" wire:model="menu.name_es" autocomplete="off">
                            @error('menu.name_es')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre en Español
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input class="form-control" name="language" type="text" value="" placeholder="Ingles" disabled>
                        </div>
                        <div class="col-8">
                            <input class="form-control" name="name_en" type="text" wire:model="menu.name_en" autocomplete="off">
                            @error('menu.name_en')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre en Español
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input class="form-control" name="language" type="text" value="" placeholder="Ruso" disabled>
                        </div>
                        <div class="col-8">
                            <input class="form-control" name="name_ru" type="text" wire:model="menu.name_ru" autocomplete="off">
                            @error('menu.name_ru')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre en Español
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <table class="table table-borderless m-0">
                                <tbody>
                                    <tr class="table-light">
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Descripciones:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.description'>
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Servicios:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.service'>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Opciones:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.choice'>
                                            </div>
                                        </td>
                                        <td class="col-4">
                                            <label class="col-form-label text-body">Países:</label>
                                        </td>
                                        <td class="col-2 align-middle">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.country'>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-info" wire:click='update' wire:loading.remove wire:target='update'><i class="fa-solid fa-paper-plane fa-fw"></i>Enviar</button>
                    <span class="text-body" wire:loading wire:target='update'>Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>