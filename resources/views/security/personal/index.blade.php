@extends('adminlte::page')
@section('title', 'Personal')

@section('css')

    <link rel="stylesheet" href="{{asset('css/security_index.css')}}">
    <link rel="stylesheet" href="{{asset('css/stateIcon.css')}}">

@stop

@section('content_header')


<div class="row mb-2">
    <div class="col-12">
        <ul class="nav nav-tabs justify-content-end">
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('security.qrScanner.index') }}">Escanear QR</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" href="{{ route('security.position.index') }}">Cargos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('security.area.index') }}">Areas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('security.index') }}">Personal</a>
            </li>            
        </ul>
    </div>
</div>

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



@livewireStyles

@stop


@section('content')

    
    @livewire("security.personal.personal-render")

@stop

@section('js')


@stop