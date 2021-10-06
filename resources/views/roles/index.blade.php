@extends('adminlte::page')

@section('title', 'Asignar Role')

@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop

@section('content')
    @livewire('roles.roles-index')
@stop