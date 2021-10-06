<div>
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    @if (session('delete'))
        <div class="alert alert-danger">
            <strong>{{ session('delete') }}</strong>
        </div>
    @endif

    <div id="form" class="invisible d-none">
        <div class="card-body">
            <p class="h6">Tasa de cambio:</p>
            {!! Form::model($dolars, ['route' => ['dolar.create'], 'method' => 'put']) !!}
                    <div>
                        <label>
                            {!! Form::number('daily_rate', '', ['class' => 'form-control', 'step' => 'any']) !!}
                        </label>
                        <label>
                            {!! Form::date('date', '', ['class' => 'form-control']) !!}
                        </label>
                    </div>
                {!! Form::submit('Crear nueva tasa', ['class' => 'btn btn-primary mt-2']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control" placeholder="Ingrese Nombre o Numero">
        </div>
        @if ($dolars->count())
            <div class="card-body">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Tasa del Día</th>
                                <th>Subido</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dolars as $dolar)
                                <tr>
                                    <td>{{ $dolar->Usuario }}</td>
                                    <td>{{ $dolar->Fecha }}</td>
                                    <td>{{ number_format($dolar->Tasa_del_día, 2)}}</td>
                                    <td>{{ $dolar->Subido }}</td>
                                    <td>{{ $dolar->Actualizado }}</td>
                                    @can('roles.destroy')
                                    <td width="10px">
                                        {!! Form::model($dolars, ['route' => ['dolar.destroy', $dolar->ID], 'method' => 'delete']) !!}
                                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $dolars->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>
                    No hay coincidencias
                </strong>
            </div>
        @endif
    </div>
</div>

@section('js')
    <script>
        function show_form(){
            form.className     = "card";
            button1.className  = "invisible d-none"
            button2.className  = "btn btn-danger float-right"
        };
    
        function hidden_form(){     
            form.className    = "invisible d-none";
            button1.className = "btn btn-success float-right"
            button2.className = "invisible d-none"
        };
    </script>
@stop