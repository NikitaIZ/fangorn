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