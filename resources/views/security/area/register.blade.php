@extends('adminlte::page')
@section('title', 'Personal')

@section('css')
    


    
@stop

@section('content_header')
    <h1 class="display">Registro de Area</h1>
    <hr>

    @if ($errors->any())
        <div class="alert alert-warning">
            No puedes dejar campos vacios!
        </div>
    @endif

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
    <form action="{{route('security.area.register.post')}}" method="post" class="row g-3">
        @csrf
        <div class="col-md-12">
            <label for="name" class="form-label">Nombre del Area</label>
            <input maxlength="64" type="text" name="name" id="name" class="form-control" placeholder="Nombre">
        </div>
        <div class="col-md-12">
            <label for="description" class="form-label">Descripcion</label>
            <textarea maxlength="256" style="resize:none;" class="form-control" id="description" name="description" rows="4"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>
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