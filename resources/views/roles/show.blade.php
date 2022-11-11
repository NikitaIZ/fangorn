@extends('adminlte::page')

@section('title', $role_name)

@section('content_header')
    <h1>Role: {{$role_name}}</h1>
@stop

@section('content')
    @livewire('roles.role-show', ['role' => $id])
@stop