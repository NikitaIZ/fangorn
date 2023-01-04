@extends('adminlte::page')
@section('title', 'Personal')

@section('css')
    


    
@stop

@section('content_header')
    <h1 class="display">Actualizacion de Area</h1>
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
    <form action="{{route('security.area.delete.post',$area->id)}}" method="post" class="row g-3">
        
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
        <div class="col-md-12">
            <label for="name" class="form-label">Nombre del Area</label>
            <input disabled value="{{$area->name}}" maxlength="64" type="text" name="name" id="name" class="form-control" placeholder="Nombre">
        </div>
        <div class="col-md-12">
            <label for="description" class="form-label">Descripcion</label>
            <textarea disabled maxlength="256" style="resize:none;" class="form-control" id="description" name="description" rows="4">{{$area->description}}</textarea>
        </div>
        <div class="col-12">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar</button>
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