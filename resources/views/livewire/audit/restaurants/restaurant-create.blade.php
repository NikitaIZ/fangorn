<div class="flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#createRestaurant"><i class="fa-solid fa-plus mt-1"></i></button>
    <div wire:ignore.self class="modal fade" id="createRestaurant" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createRestaurantLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Crear Nuevo Restaurante</h5>
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
                            <div class="d-flex bd-highlight align-items-center">
                                <div class="d-flex align-items-center">
                                    <label class="col-form-label text-body mr-4 pr-1">Comida:</label>
                                    <div class="ml-2 form-check form-switch align-items-center">
                                        @if ($this->food)
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('food')" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('food')">
                                        @endif
                                        <label class="form-check-label text-secondary fs-6 fst-italic">Ofrece diferentes platillos.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex bd-highlight align-items-center">
                                <div class="d-flex align-items-center">
                                    <label class="col-form-label text-body mr-4 pr-1">Bebidas:</label>
                                    <div class="ml-2 form-check form-switch">
                                        @if ($this->drink)
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('drink')" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('drink')">
                                        @endif
                                        <label class="form-check-label text-secondary fs-6 fst-italic">Ofrece bebidas de muchos tipos.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex bd-highlight align-items-center">
                                <div class="d-flex align-items-center">
                                    <label class="col-form-label text-body mr-4">Cócteles:</label>
                                    <div class="ml-2 form-check form-switch">
                                        @if ($this->coctel)
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('coctel')" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" role="switch" wire:click="enabled('coctel')">
                                        @endif
                                        <label class="form-check-label text-secondary fs-6 fst-italic">Ofrece Cocteles variados.</label>
                                    </div>
                                </div>
                            </div>
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
