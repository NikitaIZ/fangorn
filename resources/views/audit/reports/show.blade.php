@extends('adminlte::page')

@section('title', $xml)

@section('content_header')
    <h1 class="text-center">Reporte Nro {{ $xml }} del día {{ $date }}</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        @livewire('audit.reports.x-m-l-show', ['xml' => $xml])
    </div>
@stop