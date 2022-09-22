<div class="flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#createBuffet"><i class="fa-solid fa-plus mt-1"></i></button>
    <div wire:ignore.self class="modal fade" id="createBuffet" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createBuffetLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Crear Nuevo Servicio para el Buffet</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-12">
                            <label for="service" class="col-form-label text-body">Nombre del Servicio:</label>
                            <input class="form-control" autocomplete="off" name="price" type="text" wire:model.defer="service" autocomplete="off">
                            @error('service')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, añada nombre valido
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="adults" class="col-form-label text-body">Precio para Adultos:</label>
                            <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="1" wire:model.defer="adults" autocomplete="off" step=".01">
                            @error('adults')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, añada un numero
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="children" class="col-form-label text-body">Precio para Niños:</label>
                            <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="1" wire:model.defer="children" autocomplete="off" step=".01">
                            @error('children')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, añada un numero
                                </span>
                            @enderror
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
