@extends('adminlte::page')
@section('title', 'Personal')

@section('css')


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

    @livewire("marketing.data.data-render")
    

@stop

@section('js')


@stop