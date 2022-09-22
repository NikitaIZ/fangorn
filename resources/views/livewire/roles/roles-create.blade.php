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
            <p class="h6">Nombre:</p>
            {!! Form::model($roles, ['route' => ['roles.store'], 'method' => 'post']) !!}
                    <div>
                        <label>
                            {!! Form::text('name', '',['class' => 'form-control mr-1']) !!}
                        </label>
                    </div>
                {!! Form::submit('Crear nuevo nivel', ['class' => 'btn btn-primary mt-2']) !!}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control" placeholder="Ingrese Nombre o Correo de Usuario" value='ashai'>
        </div>
        @if ($roles->count())
            <div class="card-body p-0">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                @can('roles.show')
                                    <th></th>
                                @endcan
                                @can('roles.destroy')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    @can('roles.show')
                                        <td width="10px">
                                            <a class="btn btn-info" href="{{route('roles.show', $role->id)}}">Permisos</a>
                                        </td>
                                    @endcan
                                    @can('roles.destroy')
                                        <td width="10px">
                                            {!! Form::model($roles, ['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
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
                {{ $roles->links() }}
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
