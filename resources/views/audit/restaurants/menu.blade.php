@extends('adminlte::page')

@section('title', $restaurant->name)

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
    </style>
@stop

@section('content_header')
    <div class="row mb-2">
        <div class="col-12">
            <ul class="nav nav-tabs justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('audit.restaurants.index') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown"  href="#" role="button" aria-expanded="false">{{ $restaurant->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($restaurant_list as $restaurant_option)
                            <li><a class="dropdown-item" href="{{ route('audit.menus.index', ['lang' => $lang, 'id' => $restaurant_option->id]) }}">{{ $restaurant_option->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center pb-4">
        @if ($restaurant->food == true)
            <div class="col-lg-6 col-12 pb-2">
                @livewire('audit.restaurants.menus.menu-index', ['lang' => $lang, 'rest' => $restaurant->id, 'type' => 'comida'], key('menu_comida'))
            </div>
        @endif
        @if ($restaurant->drink == true)
            <div class="col-lg-6 col-12 pb-2">
                @livewire('audit.restaurants.menus.menu-index', ['lang' => $lang, 'rest' => $restaurant->id, 'type' => 'bebida'], key('menu_bebida'))
            </div>
        @endif
        @if ($restaurant->coctel == true)
            <div class="col pb-2">
                @livewire('audit.restaurants.menus.menu-index', ['lang' => $lang, 'rest' => $restaurant->id, 'type' => 'coctel'], key('menu_coctel'))
            </div>
        @endif
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

        this.livewire.on('deleteMenu', plateId => {
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
                    livewire.emitTo('audit.restaurants.menus.menu-index', 'delete', plateId);
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