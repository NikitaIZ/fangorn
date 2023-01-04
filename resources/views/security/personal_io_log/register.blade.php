@extends('adminlte::page')
@section('title', 'Personal')

@section('css')
    
<link rel="stylesheet" href="{{asset('css/stateIcon.css')}}">

<style>
.show-container,.show-container-header{
    box-shadow:0px 1px 2px rgba(0,0,0,0.5),0px 1px 4px rgba(0,0,0,0.5)
    ,0px 1px 8px rgba(0,0,0,0.5);
}
label{
    font-weight:500 !important;
}
textarea{
        background-color:transparent !important;
        border:none !important;
        color:white !important;
        border: 3px solid #aaaa !important;

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

    <div class="pt-3 pb-3">
        <div class="btn-group pl-2">
            <a href="{{route('security.personal.get',$personal->personal_id)}}" class="btn btn-primary">Volver</a>
        </div>
        <div class="container-fluid">
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
                <h5 class="p-0 pb-3 m-0">Registro E/S</h5>
            </div>
            <div class=" rounded-bottom container-fluid form-body bg-dark ">
                <form action="{{route('security.personal_io_log.register.post',$personal->personal_id)}}" method="post" class="row g-3 pl-2 pr-2 pb-4 pt-2" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <label for="type" class="form-label p-0 m-0 ml-1">Tipo</label>
                        <select id="type" name="type" class="form-select">
                            <option value="Entrada">Entrada</option>
                            <option value="Salida">Salida</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">Descripcion</label>
                        <textarea maxlength="256" style="resize:none;" class="form-control" id="description" name="description" rows="4">Registro regular con el cargo {{$personal->position_name}}</textarea>
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