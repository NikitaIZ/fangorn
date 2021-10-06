@extends('adminlte::page')

@section('title', $role_name)

@section('content_header')
    @can('roles.permissions.update')
        <button id="button1" onclick="show_form()" class="btn btn-success float-right">
            Agregar Permiso
        </button>
        <button id="button2" onclick="hidden_form()" class="invisible d-none">
            Cancelar
        </button>
    @endcan
    <h1>Role: {{$role_name}}</h1>
@stop

@section('content')
    @livewire('roles.roles-show', ['permision' => $id])
@stop