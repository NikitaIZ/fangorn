<div>
    <div class="card">
        {!! Form::model($role_id, ['route' => ['roles.permissions.update', $role_id], 'method' => 'put']) !!}
            <div class="card-header">
                Permisos
            </div>
            <div class="card-body">
                    @foreach ( $permissions as $permission)
                        <div class="form-check form-check-inline col-12 col-sm-3">
                            {!! Form::checkbox($permission['name'], $permission['id'], $permission['bool'], ['class' => 'form-check-input']) !!}
                            <label class="form-check-label" for="inlineCheckbox1">{{ $permission['name'] }}</label>
                        </div>
                    @endforeach
            </div>
            <div class="card-footer">
                {!! Form::submit('Actualizar', ['class' => 'btn btn-primary mt-2']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>