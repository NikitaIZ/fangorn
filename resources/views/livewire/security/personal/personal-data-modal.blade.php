
@can('personal.show')
<div>
    <div wire:ignore.self class="modal fade" id="data-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="data-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-0 m-0">
                <div class="modal-header d-flex gap-2 align-items-center ">
                    <i class="fa-solid fa-shield fa-xl"></i>
                    <h5 class="modal-title" id="staticBackdropLabel">Detalles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    
                    @if($readyToLoad)
                        <div class="modal-body d-flex flex-column gap-3 p-0 m-0">
                            <div class="top-container container-fluid bg-dark d-flex flex-column align-items-center pt-3 pb-2 gap-2">
                                <img src="{{asset('storage/personal_photos/photo')}}-{{$personal['identification']}}.png" style="box-shadow:0px 0px 3px black,box-shadow:0px 0px 6px #aaaa;" class="rounded-circle" width="128" height="128" alt="">
                                <div class="text-center">
                                    @if($readyToLoad)
                                        <h5 class="m-0 p-0" >{{$personal['name']}}</h5>
                                        <p class="m-0 p-0" >{{$personal['identification']}}</p>
                                    @endif
                                </div>
                                @if($personal['state'] > 5)
                                    <div class="rounded-circle status-circle status-circle-5"></div>
                                @else
                                    <div class="rounded-circle status-circle status-circle-{{$personal['state']}}"></div>
                                @endif
                            </div>
                            <div class="container-fluid m-0">
                                <h4 class="">{{$personal['position_name']}}</h4>
                                <p>{{$personal['position_description']}}</p>
                            </div>
                            <hr class="p-0 m-0">
                            <div class="container-fluid m-0">
                                <h4 class="">{{$personal['area_name']}}</h4>
                                <p>{{$personal['area_description']}}</p>
                            </div>
                            <div class="container-fluid">
                                <a href="{{route('security.personal.get',$personal['personal_id'])}}" class="btn btn-primary btn-large w-50">Detalles</a>
                            </div>
                        </div>
                    @else
                    <div wire:loading  class="container-fluid  d-flex justify-content-center">
                        <div wire:loading     class="spinner-grow text-info" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @endif
                    
                <div class="modal-footer">
                    <button wire:click="cleanPropertys" type="button" class="btn btn-secondary btn-large" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan