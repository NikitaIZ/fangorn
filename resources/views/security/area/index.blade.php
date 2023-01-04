@extends('adminlte::page')
@section('title', 'Personal')

@section('css')

<link rel="stylesheet" href="{{asset('css/security_index.css')}}">

@stop

@section('content_header')
   
<div class="row mb-2 p-3">
    <div class="col-12">
        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('security.qrScanner.index') }}">Escanear QR</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('security.position.index') }}">Cargos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('security.index') }}">Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('security.area.index') }}">Areas</a>
            </li>            
        </ul>
    </div>
</div>
@if(\Session::has("response"))


    @if(\Session::get("response")['status'] == "Successfull")
        <div class="alert alert-success" role="alert">
            {{Session::get("response")['message']}}
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            {{Session::get("response")['message']}}
        </div>
    @endif
@endif




@livewireStyles

@stop


@section('content')
    @livewire("security.area-render")

    
@stop

@section('js')
    @livewireScripts
    <script type="text/javascript" src="../js/qr-scanner/getQr.js"></script>
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