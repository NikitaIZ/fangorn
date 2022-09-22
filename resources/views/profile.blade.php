@laravelPWA

@extends('adminlte::page')
@section('title', 'Dashboard')
@section('css')
    <style>

        .upper img {
            width: 100%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px
        }

        .user {
            position: relative
        }

        .profile img {
            height: 124px;
            width: 124px;
            object-fit: cover;
            object-position: center;
        }

        .profile {
            position: relative;
            left: 30%;
            height: 130px;
            width: 130px;
            border: 3px solid #707070bd;
            border-radius: 50%;
        }
    </style>
@stop
@section('content')
    <div class="row py-2">
        <div class="col-md-3">
            <div class="card p-2">
                <div class="upper">
                    <img src="http://190.205.33.228:8088/img/logo-wyndham.svg" class="img-fluid">
                </div>
                <div class="user text-center py-4">
                    <div class="profile"> 
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="rounded-circle" width="120">
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="profile-username">{{ $user->name }}</h3>
                    <p class="text-muted">{{ $role }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title">
                        <i class="fas fa-user mr-1"></i>
                        Información de Perfil
                    </h4>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button type="button" class="btn bg-primary" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" >
                    <p>Actualice la información del perfil de su cuenta y su dirección de correo electrónico.</p>
                    <div class="col-12 col-sm-8">
                        <label for="photo">Foto de Perfil</label>
                        <div class="d-grid gap-2 d-md-block">
                            <button class="btn btn-outline-primary btn-sm mr-2" onclick="openDialog()">NUEVA FOTO</button>
                            @if ($user->profile_photo_path)
                            <button class="btn btn-outline-danger btn-sm" onclick="openDelete()">ELIMINAR FOTO</button>
                            @endif
                        </div>
                        {!! Form::model('foto', ['route' => ['profile-photo.delete'], 'method' => 'delete']) !!}
                            {!! Form::submit('ELIMINAR FOTO', ['class' => 'd-none', 'id' => 'delete']) !!}
                        {!! Form::close() !!}
                        {!! Form::model($user, ['route' => ['profile.update'], 'method' => 'post', 'files'=>'true']) !!}
                            {!! Form::label('username', 'Nombre'); !!}
                            {!! Form::text('username', $user->name, ['class' => 'form-control mb-3']) !!}
                            {!! Form::label('email', 'Correo Electronico'); !!}
                            {!! Form::text('email', $user->email, ['class' => 'form-control mb-3']) !!}
                            {!! Form::file('photo', ['class' => 'd-none', 'id' => 'photo']);!!}
                            {!! Form::submit('Actualizar', ['class' => 'form-control btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title">
                        <i class="fas fa-key mr-1"></i>
                        Actualizar Contraseña
                    </h4>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button type="button" class="btn bg-primary" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body" >
                    <p>Asegúrese de que su cuenta utiliza una contraseña larga y aleatoria para estar seguro.</p>
                    <div class="col-12 col-sm-8">
                        {!! Form::model($user, ['route' => ['password.update'], 'method' => 'post', 'files'=>'true']) !!}
                            {!! Form::label('current_password', 'Contraseña actual'); !!}
                            {!! Form::password('current_password', ['class' => 'form-control mb-3']) !!}
                            {!! Form::label('new_password', 'Nueva contraseña'); !!}
                            {!! Form::password('new_password', ['class' => 'form-control mb-3']) !!}
                            {!! Form::label('confirm_password', 'Confirmar contraseña'); !!}
                            {!! Form::password('confirm_password', ['class' => 'form-control mb-3']) !!}
                            {!! Form::submit('Actualizar', ['class' => 'form-control btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@stop
@section('js')
    <script>
        function openDialog() {
            document.getElementById('photo').click();
        }
        function openDelete() {
            document.getElementById('delete').click();
        }
    </script> 
@stop
