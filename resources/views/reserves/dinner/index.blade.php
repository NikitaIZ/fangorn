<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fin de Año</title>
    <link rel="stylesheet" href="{{asset('sass/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/dinner.css')}}">
    
    @livewireStyles
</head>

<style>
    .box{
        padding:1.4rem;
        background-color: white;
        box-shadow:0px 0px 8px rgba(0,0,0,0.3);
        border-radius:0.3rem;
        margin-bottom:1rem;
    }
    .box-seat{
        display:grid;
        align-items:start;
        justify-content:start;
        grid-template-columns:repeat(auto-fit,minmax(30px,auto));
        gap:15px;
    }
    .seat{
        text-align:center;
        color:#ffff;
        border-top-left-radius:0.8rem;
        border-top-right-radius:0.8rem;
        width:30px;
        height:30px;
        box-shadow:0px 0px 2px #209cee; 
        display:flex;
        justify-content:center;
        align-items:center;

    }
    .wyndham-bg{
        background-color: #0c437d;
    }
    .nav-tabs .nav-link {
        margin-bottom: -1px;
        background: none;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        color:white;
    }
    
</style>
<body>
<ul class="nav nav-tabs wyndham-bg" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button   id="toggleHome"  class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">
            Busqueda Inteligente
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button  class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true" >
            Escanear QR
        </button>
    </li>
</ul>

<div class="container-fluid">
@livewire("reserves.dinner-search")
</div>





</body>
@livewireScripts
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.js')}}"></script>
</html>