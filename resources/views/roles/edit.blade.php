@extends('adminlte::page')

@section('title', 'Editar Role')

@section('content_header')
    <h1>Asignar un Rol</h1>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p class="h5">Nombre:</p>
            <p class="form-control">{{ $user->name }}</p>
            @can('roles.update')
                {!! Form::model($user, ['route' => ['roles.update', $user], 'method' => 'put']) !!}
                    @foreach ($roles as $role)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                    {!! Form::submit('Asignar Rol', ['class' => 'btn btn-primary mt-2']) !!}
                {!! Form::close() !!}
            @endcan
        </div>
    </div>
@stop
