@extends('adminlte::page')
@section('title', 'Escaner QR')

@section('css')
    

<style>
    #qrScanner{
        width:100%;
        height:50vh;
    }
</style>
    
@stop

@section('content_header')
    <div class="row mb-2">
        <div class="col-12">
            <ul class="nav nav-tabs justify-content-end">
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.index') }}">Personal</a>
                </li>  
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.position.index') }}">Cargos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.area.index') }}">Areas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('security.qrScanner.index') }}">Escanear QR</a>
                </li>            
            </ul>
        </div>
    </div>
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
    
@stop


@section('content')

<div class="container-fluid pt-2">
    <video src="" id="qrScanner"></video>
    <div id="container"></div>
</div>
@stop

@section('js')

    <script type="module" src="../js/qr-scanner/getQr.js"></script>

@stop