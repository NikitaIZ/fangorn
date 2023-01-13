@extends('adminlte::page')
@section('title', 'Personal')

@section('css')


<style>
    .wyndham-bg{
        background-color: #0c437d !important;
        color:white !important;
    }
    .accordion-button:after{
        background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;
    }
</style>

@stop

@section('content_header')


<div class="row mb-2">
    <div class="col-12">
        <ul class="nav nav-tabs justify-content-end">
            
            <li class="nav-item">
                <a class="nav-link" href="#">Graficas</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" href="#">Hoteles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Reportes</a>
            </li>            
        </ul>
    </div>
</div>




@stop


@section('content')

    @livewire("marketing.reports.reports-index")
    

@stop

@section('js')


@stop