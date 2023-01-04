<div class="pl-2 flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#percentageRestaurant"><i class="fa-solid fa-percent"></i></button>
    <div wire:ignore.self class="modal fade" id="percentageRestaurant" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="percentageRestaurantLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class="fa-solid fa-tags"></i> Aumentar precios</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-12">
                            <div class="d-flex bd-highlight align-items-center">
                                <label class="col-form-label text-body mr-4 pr-1">Restaurantes:</label>
                                <select class="form-select" wire:model.defer="list" aria-label="Default select example">
                                    <option value="">Selecionar</option>
                                    <option value="all">Todos</option>
                                    @foreach ($restaurants as $restaurant)
                                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex bd-highlight align-items-center">
                                <label class="col-form-label text-body mr-4 pr-1">Porcentaje:</label>
                                <input class="form-control" name="percentage" type="number" value="" wire:model.defer="percentage" autocomplete="off" step=".01">
                                @error('percentage')
                                    <span class="fs-6 text-danger fst-italic">
                                        Por favor, rellene el campo Porcentaje
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click='save' wire:loading.remove wire:target='save'>Actualizar</button>
                    <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>