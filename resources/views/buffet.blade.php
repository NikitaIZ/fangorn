@extends('adminlte::page')

@section('title', 'Buffet')

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
            {!! Form::model($buffet, ['route' => ['buffet.create'], 'method' => 'put']) !!}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Adults </th>
                            <th>Children</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buffet as $service)
                            <tr>
                                <td>
                                    {{ $service->service }} ($)
                                </td>
                                <td>
                                    {!! Form::number($service->service."_adults", $service->adults, ['class' => 'form-control mr-1']) !!}
                                </td>
                                <td>
                                    {!! Form::number($service->service."_children", $service->children, ['class' => 'form-control mr-1']) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop