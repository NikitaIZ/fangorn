@extends('adminlte::page')

@section('title', 'Tasa de Cambio')

@section('css')
    <style>
        .btn-wyndham {
            color: rgb(255, 255, 255);
            background-color: rgb(12, 67, 125);
            border-color: rgb(51, 111, 175);
            box-shadow: none;
        }

        .btn-wyndham:hover {
            color: rgb(255, 255, 255);
            background-color: rgb(51, 111, 175);
            border-color: rgb(131, 179, 230);
        }

        .box-1{
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .father {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .child {
            width: auto;
        }

        .pagination > .active > a,
        .pagination > .active > a:focus,
        .pagination > .active > a:hover,
        .pagination > .active > span,
        .pagination > .active > span:focus,
        .pagination > .active > span:hover {
            background-color: #c3e6cb !important;
            border-color: white !important;
            color: #28a745 !important;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #28a745;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        dl, ol, ul {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
@stop

@section('content_header')
    <div class="row mb-2">
        <div class="col-12">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Auditoria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown"  href="#" role="button" aria-expanded="false">Tasas de Cambio</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('audit.reports.index') }}">Reportes</a></li>
                        <li><a class="dropdown-item" href="{{ route('audit.restaurants.index') }}">Restaurantes</a></li>
                        <li><a class="dropdown-item" href="{{ route('audit.buffets.index') }}">Buffet</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        @livewire('audit.dolars.dolar-index')
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

        this.livewire.on('deleteDolar', DolarId => {
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
                    livewire.emitTo('audit.dolars.dolar-index', 'delete', DolarId);
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