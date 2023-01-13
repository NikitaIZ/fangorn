@extends('adminlte::page')
@section('title', 'Personal')

@section('css')

   <link rel="stylesheet" href="{{asset('css/stateIcon.css')}}">

   <style>
    .show-container,.show-container-header{
        box-shadow:0px 1px 2px rgba(0,0,0,0.5),0px 1px 4px rgba(0,0,0,0.5)
        ,0px 1px 8px rgba(0,0,0,0.5);
    }
   </style>
@stop

@section('content_header')
   

    @if(isset($response))

        @if($response["status"] === "Successfull")   
            <div class="alert alert-success" role="alert">
                {{$response["message"]}}
            </div>
            
        @else
            <div class="alert alert-danger" role="alert">
                {{$response["message"]}}
            </div>
        @endif

    @endif
@stop


@section('content')

@can('personal.qr')
    <div class="modal fade" id="qrcode{{$personal->identification}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Codigo QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="qr-code d-flex justify-content-center align-items-center flex-column gap-3">
                    <?php 
                        $json = json_encode(\Crypt::encryptString(json_encode(["personal_id"=>$personal->personal_id])));
                    ?>
                    <div id="qr-{{$personal->personal_id}}">
                        {{\QrCode::format("svg")->size(250)->generate($json);}}
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{route('security.qrScanner.download',$json)}}">Descargar QR</a>
                        <button id="btn-{{$personal->personal_id}}" class="btn btn-info btn-print">Imprimir QR</button>
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endcan

<div class="pt-3 p-1 pb-3">
    <div class="my-2">
        @can('personal.create_io_log')
        <a href="{{route('security.personal_io_log.register.get',$personal->personal_id)}}" class="btn btn-primary">Registrar E/S</a>
        @endcan
        @can('personal.create_warn')
        <a href="{{route('security.personal_warn.register.get',$personal->personal_id)}}" class="btn btn-danger">Registrar Advertencia</a>
        @endcan
    </div>
    <div class="container-fluid d-flex flex-column show-container rounded-bottom p-0">
        <div class="rounded-top container-fluid d-flex gap-2 bg-dark p-0 pt-3 pl-2 m-0 flex-column show-container-header">
            <h5 class="p-0 m-0">
                <i class="fa-solid fa-shield fa-xl"></i>
                Seguridad
            </h5>
            <div class="top-container container-fluid bg-dark d-flex flex-column align-items-center pt-3 pb-2 gap-2">
                <img style="box-shadow:0px 0px 3px black,box-shadow:0px 0px 6px #aaaa;" class="rounded-circle" src="{{asset('storage/personal_photos/photo')}}-{{$personal->identification}}.png" width="128" height="128" alt="">
                <div class="text-center">
                    <h5 class="m-0 p-0" >{{$personal->name}} {{$personal->last_name}}</h5>
                    <p class="m-0 p-0" >{{$personal->identification}}</p>
                </div>
                @if($personal->state > 5)
                    <div class="rounded-circle status-circle status-circle-5"></div>
                @else
                    <div class="rounded-circle status-circle status-circle-{{$personal->state}}"></div>
                @endif
            </div>
            <h5 class="p-0 pb-3 m-0">Detalles de Personal</h5>
        </div>
        <div class="container-fluid d-flex flex-column p-0 pb-3 bg-white rounded-bottom">
            
            @can('personal.qr')
                <div class="container-fluid pt-2 pl-2 ">
                    <button data-bs-toggle="modal" data-bs-target="#qrcode{{$personal->identification}}" class="btn btn-primary">Mostrar QR</button>
                </div>
            @endcan
            <hr>
            <div  class="container-fluid m-0">
                <h4 class="">{{$personal->position_name}}</h4>
                <p>{{$personal->position_description}}</p>
            </div>
            <hr>
            <div class="container-fluid m-0">
                <h4 class="">{{$personal->area_name}}</h4>
                <p>{{$personal->area_description}}</p>
            </div>
            <hr>
            <div class="container-fluid">
                <h5>Historico de E/S</h5>
                @livewire("security.personal-i-o-logs-render")
                
            </div>
            
            <hr>
            <div class="container-fluid">
                <h5>Historico de Advertencias</h5>
                @livewire("security.personal-warn-render")
            </div>
        </div>
    </div>
</div>


        
@stop

@section('js')
    @can('personal.qr')
        <script>
            function setPrint(e){
                const id = e.target.id.split("-")[1]
                const qr = document.querySelector(`#qr-${id}`)
                const div_to_print = window.open('', '', 'height=500, width=500');
                div_to_print.document.write('<html>');
                div_to_print.document.write('<body');
                div_to_print.document.write(qr.innerHTML);
                div_to_print.document.write('</body></html>');
                div_to_print.document.close();
                div_to_print.print()
            }
            function addEvents(){

                const button = document.querySelector(".btn-print")

                button.addEventListener("click",setPrint)
            }

            window.onload = addEvents
        </script>
    @endcan


@stop