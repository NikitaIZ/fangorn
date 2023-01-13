@extends('adminlte::page')

@section('title', 'Usuarios')

@section('css')
    <style>
        .father {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .child {
            width: auto;
        }

        .box-shadow {
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        }

        .box-country {
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px
        }

        .box-coll {
            background-color: #1010100a;
            box-shadow: rgb(17 12 46 / 15%) 0px 48px 100px 0px;
        }

        .pagination > .active > a,
        .pagination > .active > a:focus,
        .pagination > .active > a:hover,
        .pagination > .active > span,
        .pagination > .active > span:focus,
        .pagination > .active > span:hover {
            background-color: #17a2b8 !important;
            border-color: white !important;
        } 

        dl, ol, ul {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .form-check-input:checked {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
    </style>
@stop

@section('content_header')
    <div class="row mb-2">
        <div class="col-12">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissions.index') }}">Permisos</a>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        @livewire('users.user-index')
    </div>
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        this.livewire.on('alert', function(message){
            Swal.fire(
                'Buen trabajo!',
                message,
                'success'
            )
        });

        this.livewire.on('error', function(message){
            Swal.fire(
                'Oh no!',
                message,
                'error'
            )
        });

        this.livewire.on('deleteRole', restaurantId => {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-2'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: '¿Está seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, bórralo.',
                cancelButtonText: '¡No, cancela!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    livewire.emitTo('roles.role-index', 'delete', restaurantId);
                    swalWithBootstrapButtons.fire(
                        'Eliminado!',
                        'Su archivo ha sido eliminado.',
                        'success'
                    )
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'Su archivo está a salvo :)',
                        'error'
                    )
                }
            })
        });
    </script>
@stop