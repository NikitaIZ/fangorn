<div class="flex-shrink-1">
    <button class="btn btn-info fw-bold" type="button" data-bs-toggle="modal" data-bs-target="#createType"><i class="fa-fw fa-regular fa-rectangle-list"></i> Opción</button>
    <div wire:ignore.self class="modal fade" id="createType" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    @if ($this->create)
                        <h5 class="modal-title"><i class="fa-regular fa-rectangle-list fa-fw"></i> Añadir Tipo</h5>
                        <button class="btn btn-danger btn-sm fw-bold float-right" type="button" wire:click='change'><i class="fa-solid fa-trash-can"></i></button>
                    @else
                        <h5 class="modal-title"><i class="fa-regular fa-rectangle-list fa-fw"></i> Eliminar Tipo</h5>
                        <button class="btn btn-light btn-sm fw-bold float-right" type="button" wire:click='change'><i class="fa-solid fa-plus"></i></button>
                    @endif
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        @if ($this->create)
                            <div class="col-12">
                                <label for="name" class="col-form-label text-body">Nombre:</label>
                                <input class="form-control" autocomplete="off" name="name" type="text" value="" wire:model="name">
                                @error('name')
                                    <span class="fs-6 text-danger fst-italic">
                                        Por favor, rellene el campo Nombre
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="description" class="col-form-label text-body">Descripción:</label>
                                <textarea class="form-control" name="description" rows="2" wire:model="description"></textarea>
                                @error('description')
                                    <span class="fs-6 text-danger fst-italic">
                                        Por favor, rellene el campo Descripción
                                    </span>
                                @enderror
                            </div>
                        @else
                            <div class="col-12">
                                <label for="type" class="col-form-label text-body">Tipo:</label>
                                <select class="form-select" wire:model="type" aria-label="Default select example">
                                    <option value="">Seleccione</option>
                                    @foreach ($types_list as $type_option)
                                        <option value="{{ $type_option->id }}">{{ $type_option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    @if ($this->create)
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" wire:click='save' wire:loading.remove wire:target='save'>Añadir</button>
                        <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                    @else
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" wire:click="$emit('deleteType', {{ $this->type }})" wire:loading.remove wire:target='save'>Eliminar</button>
                        <span class="text-body" wire:loading wire:target='save'>Cargando...</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>