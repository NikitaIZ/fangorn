<div class="flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#createDolar"><i class="fa-solid fa-plus mt-1"></i></button>
    <div wire:ignore.self class="modal fade" id="createDolar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDolarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Crear Nueva Tasa de Cambio</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-6">
                            <label for="daily_rate" class="col-form-label text-body">Cambio (Bs):</label>
                            <input class="form-control" autocomplete="off" name="price" type="number" value="0" min="1" wire:model.defer="daily_rate" autocomplete="off" step=".01">
                            @error('daily_rate')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, añada un numero
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="date" class="col-form-label text-body">Fecha:</label>
                            <input class="form-control" autocomplete="off" name="price" type="date" wire:model.defer="date" autocomplete="off">
                            @error('date')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, añada una fecha
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click='save' wire:loading.remove wire:target='save'>Añadir</button>
                    <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>
