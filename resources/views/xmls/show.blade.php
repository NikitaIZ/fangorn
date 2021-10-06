@extends('adminlte::page')

@section('title', $xml)

@section('content_header')
    <h1>Reporte Nro: {{$xml}}</h1>
@stop

@section('content')
    @livewire('audit.reports.x-m-l-show', ['xml' => $xml])
@stop