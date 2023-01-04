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
    .main-content{
        box-shadow:0px 2px 3px rgba(0,0,0,0.1),0px 4px 3px rgba(0,0,0,0.5);
    }
    input[type=text],input[type=number]{
        background-color:transparent !important;
        border:none !important;
        border-bottom:4px solid #aaaa !important;
        color:white !important;

    }
    select{
        background-color:transparent !important;
        color:white !important;
        border:none  !important;
        
        box-shadow:0px 2px 2px rgba(255,255,255,0.2) !important;
        background-color:rgba(0,0,0,0.1) !important;
    }
    select option{
        color:black !important;
    }


    input,select{
        transition:0.2s ease-in !important;
    }
    
    label{
        display: block;
        color:white;
        font-weight: 100 !important;
    }
    select:focus{
        border-color:none !important;
        box-shadow:0px 2px 2px rgba(255,255,255,0.6) !important;
        transform:translateY(-3px);
    }

    input[type=text]:focus{
       background-color:transparent !important;
    }
</style>
@stop

@section('content_header')

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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

<div class="pt-3 pb-3">
    <div class="p-0 d-flex flex-column main-content ">
        <div class="container-fluid bg-dark d-flex flex-column container-head">
            
            <div class="d-flex flex-column pt-3 p-2">
                <h5>
                    <span>Seguridad</span>
                </h5>
            </div>
            <div class=" d-flex justify-content-center pt-5 pb-5">
                <h1>
                    <i  class="fa-solid fa-shield fa-xl"></i>
                </h1>
            </div>
            <div>
                <div class="d-flex flex-column pb-0 p-2">
                    <h5>Registro de Personal</h5>
                </div>
            </div> 
        </div>
        <div class=" rounded-bottom container-fluid form-body bg-dark ">
            <form action="{{route('security.personal.register.post')}}" method="post" class="row g-3 pl-2 pr-2 pb-4 pt-2" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <input maxlength="64" type="text" name="Nombre" id="name" class="form-control" placeholder="Nombre">
                </div>
                <div class="col-md-6">
                    <input maxlength="64" type="text" name="Apellido" id="last_name" class="form-control" placeholder="Apellido">
                </div>
                <div class="col-md-12">
                    <input  type="number" name="Identificacion" id="identification" class="form-control" placeholder="Identificacion">
                </div>
                <div class="col-md-12">
                    <label for="area" class="form-label p-0 m-0 ml-1">Area</label>
                    <select id="area" name="Area" class="form-select">
                        @foreach($areas as $area)
                            <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="position" class="form-label p-0 m-0 ml-1">Cargo</label>
                    <select id="position" name="Cargo" class="form-select">
                        @foreach($positions as $position)
                            <option value="{{$position->id}}">{{$position->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="photo" class="form-label p-0 m-0">Foto</label>
                    <input  type="file" name="Foto" id="photo" class="form-control" >
                </div>
                <div class="col-md-12 pt-3">
                    <button type="submit" class="btn btn-primary  p-2">Registrar</button>
                </div>
            </form>
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