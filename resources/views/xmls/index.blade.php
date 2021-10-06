@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Lista de Reportes</h1>
@stop

@section('content')
    @livewire('audit.reports.x-m-l-index')
@stop