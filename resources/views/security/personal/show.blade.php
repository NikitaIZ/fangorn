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

<div class="pt-3 p-1 pb-3">
    <div class="btn-group">
        <a href="{{route('security.personal_io_log.register.get',$personal->personal_id)}}" class="btn btn-primary">Registrar E/S</a>
        <a href="{{route('security.personal_warn.register.get',$personal->personal_id)}}" class="btn btn-danger">Registrar Advertencia</a>
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
            <div class="container-fluid pt-2 pl-2 ">
                <h4>Codigo QR</h4>
                <img class="m-1" width="128" height="128"  src="{{asset('storage/qr-code/qrcode')}}-{{$personal->identification}}.svg" class="" alt="...">
            </div>
            <hr>
            <div class="container-fluid m-0">
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
    <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <script type="text/javascript" src="//d3js.org/d3.v4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <script type="text/javascript" src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>
    <script type="text/javascript" src="../js/guage.babel.js"></script>
    <script type="text/javascript" src="../js/revenue_manager_charts.babel.js" defer></script>

@stop