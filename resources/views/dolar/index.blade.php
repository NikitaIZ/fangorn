@extends('adminlte::page')

@section('title', 'Tasa de Cambio')

@section('content_header')
    @can('dolar.create')
        <button id="button1" onclick="show_form()" class="btn btn-success float-right">
            Actualizar
        </button>
        <button id="button2" onclick="hidden_form()" class="invisible d-none">
            Cancelar
        </button>
    @endcan
    <h1>Lista de Tasa de Cambio</h1>
@stop

@section('content')
    @livewire('audit.dolar.dolar-index')
@stop