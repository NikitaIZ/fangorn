<div>
    <button data-bs-toggle="modal" data-bs-target="#addPosition" class="btn btn-info  btn-large add-button-box rounded-0">
        <i class="fa-solid fa-plus fa-sm"></i>
    </button>
    <div wire:ignore.self class="modal fade" id="addPosition" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class=" modal-dialog">
            <div class="modal-content">
                <div class="bg-dark modal-header">
                    <h5 class="modal-title" >
                        <i  class="fa-solid fa-shield fa-xl"></i>
                        Crear Cargo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-dark">
                    @error('cargo') <div class="alert alert-danger" role="alert"> {{ $message }} </div> @enderror
                    @error('descripcion') <div class="alert alert-danger" role="alert"> {{ $message }} </div> @enderror
                    @if(\Session::get("message"))
                        <div class="alert alert-success" role="alert">
                            {{Session::get("message")}}
                        </div>
                    @endif
                    <div wire:loading class="container-fluid  d-flex justify-content-center">
                        <div wire:loading  class="spinner-grow text-white" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <form wire:submit.prevent="save"> 
                        <div class="mb-3">
                            <label for="area_name" class="form-label m-0">Cargo</label>
                            <input wire:loading.attr="disabled" style="color:white;" wire:model.defer="cargo" type="text" name="cargo" class="form-control" id="area_name" placeholder="Nombre del cargo">
                        </div>
                        <div class="mb-3">
                            <label for="area_description" class="form-label m-0">Descripcion</label>
                            <textarea wire:loading.attr="disabled" name="Descripcion" style="color:white;"  wire:model.defer="descripcion" class="form-control" id="area_description" rows="3"></textarea>
                        </div>
                        <button wire:loading.attr="disabled" type="submit" class="btn btn-primary px-5">Crear</button>
                    </form>
                </div>
                <div class="bg-dark modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
