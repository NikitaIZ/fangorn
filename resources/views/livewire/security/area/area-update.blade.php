<div>
    <div wire:ignore.self class="modal fade" id="updateArea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class=" modal-dialog">
            <div class="modal-content">
                <div class="bg-dark modal-header">
                    <h5 class="modal-title" >
                        <i  class="fa-solid fa-shield fa-xl"></i>
                        @if($readyToLoad)
                            Modificar {{$area_object->name}}
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-dark">
                    <div wire:loading  class="container-fluid  d-flex justify-content-center">
                        <div wire:loading   class="spinner-grow text-white" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @error('area') <div class="alert alert-danger" role="alert"> {{ $message }} </div> @enderror
                    @error('descripcion') <div class="alert alert-danger" role="alert"> {{ $message }} </div> @enderror
                    @if(\Session::get("message"))
                        <div class="alert alert-success" role="alert">
                            {{Session::get("message")}}
                        </div>
                    @endif
                    <div wire:loading.remove >
                        @if($readyToLoad)
                            <form wire:submit.prevent="update"> 
                                <div class="mb-3">
                                    <label for="area_name" class="form-label m-0">Area</label>
                                    <input value="{{$area}}" wire:loading.attr="disabled" style="color:white;" wire:model.defer="area" type="text" name="area" class="form-control" id="area_name" placeholder="Nombre del area">
                                </div>
                                <div class="mb-3">
                                    <label for="area_description" class="form-label m-0">Descripcion</label>
                                    <textarea wire:loading.attr="disabled" name="Descripcion" style="color:white;"  wire:model.defer="descripcion" class="form-control" id="area_description" rows="3">{{$descripcion}}</textarea>
                                </div>
                                <button  wire:loading.attr="disabled" type="submit" class="btn btn-primary px-5">Modificar</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="bg-dark modal-footer">
                    <button wire:click="cleanPropertys" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
