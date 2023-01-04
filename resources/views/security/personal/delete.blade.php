@extends('adminlte::page')
@section('title', 'Personal')

@section('css')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    input[type=number] {
    -moz-appearance: textfield;
    }
</style>
    
@stop

@section('content_header')
    <h1 class="display">Eliminacion de Personal</h1>
    <hr>
@stop


@section('content')
    <form action="" method="post" class="row g-3">



        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Advertencia</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Esta seguro que desea eliminar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
                </div>
            </div>
        </div>


        @csrf
        <div class="col-md-6">
            <label for="name" class="form-label">Nombre</label>
            <input disabled value="{{$personal->name}}" type="text" name="name" id="name" class="form-control" placeholder="Nombre">
        </div>
        <div class="col-md-6">
            <label for="last_name" class="form-label">Apellido</label>
            <input disabled value="{{$personal->last_name}}" type="text" name="last_name" id="last_name" class="form-control" placeholder="Apellido">
        </div>
        <div class="col-md-12">
            <label for="identification" class="form-label">Cedula</label>
            <input disabled value="{{$personal->identification}}" type="number" name="identification" id="identification" class="form-control" placeholder="Cedula">
        </div>
        <div class="col-md-6">
            <label for="position" class="form-label">Cargo</label>
            <select disabled id="position" name="position" class="form-select">
                <option value="{{$personal->position_id}}" selected>{{$personal->position_name}}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="area" class="form-label">Area</label>
            <select disabled id="area" name="area" class="form-select">
                <option value="{{$personal->area_id}}" selected>{{$personal->area_name}}</option>
            </select>
        </div>
        <div class="col-12">
            <button type="button"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar</button>
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