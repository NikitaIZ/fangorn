<div class="flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#createPermission"><i class="fa-solid fa-plus mt-1"></i></button>
    <div wire:ignore.self class="modal fade" id="createPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createPermissionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Crear Nuevo Permiso</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-12">
                            <label for="name" class="col-form-label text-body">Nombre:</label>
                            <input class="form-control" autocomplete="off" name="name" type="text" value="" wire:model.defer="name">
                            @error('name')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, rellene el campo Nombre
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="col-form-label text-body">Descripción</label>
                            <textarea class="form-control" name="description" rows="2" wire:model.defer="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-warning">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" wire:click='save' wire:loading.remove wire:target='save'>Añadir</button>
                    <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>
