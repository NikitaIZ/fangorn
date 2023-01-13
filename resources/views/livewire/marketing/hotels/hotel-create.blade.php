<div class="flex-shrink-1">
    <button class="btn btn-light text-success" type="button" data-bs-toggle="modal" data-bs-target="#createRestaurant"><i class="fa-solid fa-plus mt-1"></i></button>
    <div wire:ignore.self class="modal fade" id="createRestaurant" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createRestaurantLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class="fa-solid fa-bars fa-fw"></i> Registrar Hotel</h5>
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
                        <div class="col-6">
                            <label for="color" class="col-form-label text-body">Color:</label>
                            <input class="form-control" name="color" type="color" value="" wire:model.defer="color">
                            @error('color')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, elija un color
                                </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="type_id" class="col-form-label text-body">Tipo:</label>
                            <select class="form-select" wire:model.defer="type_id" aria-label="Default select example">
                                <option value="">Seleccione</option>
                                @foreach ($types_list as $type_option)
                                    <option value="{{ $type_option->id }}">{{ $type_option->name }}</option>
                                @endforeach
                            </select>
                            @error('type_id')
                                <span class="fs-6 text-danger fst-italic">
                                    Por favor, elija un tipo
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 text-center">
                            <h5 class="text-body">Estrellas: 
                                <input id="radio6" type="radio" name="stars" value="0" wire:click='stars(0)' checked>
                                <label for="radio6">0</label>
                            </h5>
                            <p class="order">
                                <input id="radio1" type="radio" name="stars" value="5" wire:click='stars(5)'>
                                <label for="radio1">★</label>
                                <input id="radio2" type="radio" name="stars" value="4" wire:click='stars(4)'>
                                <label for="radio2">★</label>
                                <input id="radio3" type="radio" name="stars" value="3" wire:click='stars(3)'>
                                <label for="radio3">★</label>
                                <input id="radio4" type="radio" name="stars" value="2" wire:click='stars(2)'>
                                <label for="radio4">★</label>
                                <input id="radio5" type="radio" name="stars" value="1" wire:click='stars(1)'>
                                <label for="radio5">★</label>
                            </p>
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