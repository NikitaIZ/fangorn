<div>
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            <strong>{{ session('warning') }}</strong>
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-danger">
            <strong>{{ session('danger') }}</strong>
        </div>
    @endif
    <div id="form" class="invisible d-none">
        <div class="card-body">
            <p class="h6">Seleciona:</p>
            {!! Form::model($newPermission, ['route' => ['roles.permissions.update', $role_id], 'method' => 'put']) !!}
                    <div>
                        <label>
                            {!! Form::select('id', $newPermission, '', ['class' => 'form-control mr-1']) !!}
                        </label>
                    </div>
                {!! Form::submit('Agregar', ['class' => 'btn btn-primary mt-2']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control" placeholder="Ingrese Nombre o Correo de Usuario">
        </div>
        @if ($permissions->count())
            <div class="card-body p-0">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                @can('roles.permissions.destroy')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->ID_Permiso }}</td>
                                    <td>{{ $permission->Permiso }}</td>
                                    @can('roles.permissions.destroy')
                                        <td width="10px">
                                            {!! Form::model($permission, ['route' => ['roles.permissions.destroy', $role_id], 'method' => 'delete']) !!}
                                                {!! Form::hidden('permiso', $permission->ID_Permiso) !!}
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
                {{ $permissions->links() }}
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
            form.className    = "card";
            button1.className = "invisible d-none"
            button2.className = "btn btn-danger float-right"
        };
    
        function hidden_form(){     
            form.className    = "invisible d-none";
            button1.className = "btn btn-success float-right"
            button2.className = "invisible d-none"
        };
    </script>
@stop