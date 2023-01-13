@extends('adminlte::page')

@section('title', 'Hoteles')

@section('css')
    <style>
        .pagination > .active > a,
        .pagination > .active > a:focus,
        .pagination > .active > a:hover,
        .pagination > .active > span,
        .pagination > .active > span:focus,
        .pagination > .active > span:hover {
            background-color: #101010 !important;
            border-color: white !important;
        } 

        dl, ol, ul {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .form-check-input:checked {
            background-color: #101010;
            border-color: #101010;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #000000;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .page-link:hover {
            z-index: 2;
            color: #ffffff;
            text-decoration: none;
            background-color: #282828;
            border-color: #dee2e6;
        }

        input[type="radio"] {
            display: none;
        }

        label {
            color: grey;
        }

        .order {
            direction: rtl;
            unicode-bidi: bidi-override;
            font-size: 1.75rem;
        }

        label:hover,
        label:hover ~ label {
            color: orange;
        }

        input[type="radio"]:checked ~ label {
            color: orange;
        }
    </style>
@stop

@section('content_header')
    <div class="row mb-2">
        <div class="col-12">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('marketing.index') }}">Graficas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('marketing.reports.index') }}">Reportes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Hoteles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('marketing.data.index') }}">Datos</a>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        @livewire('marketing.hotels.hotel-index')
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

        this.livewire.on('deleteHotel', hotelId => {
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
                    livewire.emitTo('marketing.hotels.hotel-index', 'delete', hotelId);
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

        this.livewire.on('deleteType', typeId => {
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
                    livewire.emitTo('marketing.hotels.type-create', 'delete', typeId);
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