<div>
    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control" placeholder="Ingrese Nombre o Correo de Usuario">
        </div>
        @if ($users->count())
            <div class="card-body">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>EMAIL</th>
                                <th>ROLE</th>
                                @can('roles.edit')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->ID }}</td>
                                    <td>{{ $user->Nombre }}</td>
                                    <td>{{ $user->Correo_Electronico }}</td>
                                    <td>{{ $user->Nivel }}</td>
                                    @can('roles.edit')
                                        <td width="10px">
                                            <a class="btn btn-primary" href="{{route('roles.edit', $user->ID)}}">Editar</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
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
