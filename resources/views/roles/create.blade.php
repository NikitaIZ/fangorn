@extends('adminlte::page')

@section('title', 'Crear Roles')

@section('content_header')
    @can('roles.store')
        <button id="button1" onclick="show_form()" class="btn btn-success float-right">
            Actualizar
        </button>
        <button id="button2" onclick="hidden_form()" class="invisible d-none">
            Cancelar
        </button>
    @endcan
    <h1>Lista de Roles</h1>
@stop

@section('content')
    @livewire('roles.role-create')
@stop