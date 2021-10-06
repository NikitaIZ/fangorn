@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    @can('permissions.store')
        <button id="button1" onclick="show_form()" class="btn btn-success float-right">
            Actualizar
        </button>
        <button id="button2" onclick="hidden_form()" class="invisible d-none">
            Cancelar
        </button>
    @endcan
    <h1>Lista de Permisos</h1>
@stop

@section('content')
    @livewire('permissions.permissions-index')
@stop