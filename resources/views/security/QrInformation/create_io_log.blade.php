<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Log</title>
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
</head>

<style>


    .form-container{
        display:flex;
        flex-direction:column;
        margin:1rem 0;
    }
    .form-container select,textarea{
        padding:0.5rem;
    }
</style>
<body>
    
    <div class="container-fluid p-3">
        <div class="mb-1">
            <a href="{{route('qr.request.get',$encrypted)}}" type="button" class="btn btn-primary">Volver</a>
        </div> 
        
        <div class="container-fluid pl-3 pr-3">
            <div class="card">
                <h5 class="card-header p-4 bg-info">{{$personal->name}} {{$personal->last_name}}</h5>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-warning">
                            No puedes dejar campos vacios!
                        </div>
                    @endif
                    <form action="{{route('create_io_log.post',$encrypted)}}" method="post" class="form">
                        @csrf

                        <div class="form-container">
                            <label for="type">Tipo de registro</label>
                            <select name="type" id="type">
                                <option value="Entrada">Entrada</option>
                                <option value="Salida">Salida</option>
                            </select>
                        </div>
                        <div class="form-container">
                            <label for="description">Descripcion</label>
                            <textarea name="description" id="description" cols="30" rows="3"></textarea>
                        </div>
                       
                        <div class="form-container">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>               
                </div>
            </div>
        </div>

    </div>

</body>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.js')}}"></script>
</html>