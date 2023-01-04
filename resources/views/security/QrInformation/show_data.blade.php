<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion</title>
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/stateIcon.css')}}">


</head>



<body>
    

    <div class="container-fluid p-3">
        <div class="mb-1">
            <a href="{{$qrScannerUrl}}" type="button" class="btn btn-primary">Volver</a>
        </div> 
        <div class="btn-group pl-3 pt-3">
            <a href="{{route('create_io_log.get',$encrypted)}}" type="button" class="btn btn-primary">Generar Registro</a>
        </div>
        
        <div class="container-fluid pl-3 pr-3">
            <div class="card">
                <h5 class="card-header p-4 bg-info">{{$personal->name}} {{$personal->last_name}}</h5>
                <div class="card-body">
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
                    <div class="container-fluid mb-4">
                        <img width="300" height="200"  src="{{asset('storage/personal_photos/photo')}}-{{$personal->identification}}.png" class="" alt="...">
                    </div>
                    <div class="container-fluid mb-4">
                        <img width="170" height="130"  src="{{asset('storage/qr-code/qrcode')}}-{{$personal->identification}}.svg" class="" alt="...">
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Cedula: {{$personal->identification}}</li>
                        <li class="list-group-item d-flex">
                            Estado:
                            @if($personal->state == 1)
                                    Positivo <div class="stateCircle bg-green ml-2"></div>
                            @elseif($personal->state == 2)
                                    Regular <div class="stateCircle bg-warning ml-2"></div>
                            @elseif($personal->state == 3)
                                    Negativo <div class="stateCircle bg-danger ml-2"></div>
                            @endif
                        </li>
                    </ul>
                    <hr>
                    <div class="container-fluid">
                        <h4 class="m-1">{{$personal->area_name}}</h4>
                        <p class="m-1">{{$personal->area_description}}</p>
                        <hr>
                        <h4 class="m-1">{{$personal->position_name}}</h4>
                        <p class="m-1">{{$personal->position_description}}</p>
                    </div>
                    <hr>
                    <h4 class="m-2">Ultimos 5 registros</h4>
                    <table class="table border">
                        <thead>
                            <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($io_logs as $log)
                                <tr>
                                    <td>{{$log->type}}</td>
                                    <td>{{$log->description}}</td>
                                    <td>{{$log->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
</html>