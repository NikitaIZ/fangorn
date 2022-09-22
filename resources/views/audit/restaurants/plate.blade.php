@extends('adminlte::page')

@switch($allData['lang'])
    @case('es')
        @section('title', $allData['restaurant']->name . '|' . $allData['menu']->name_es)
    @break
    @case('en')
        @section('title', $allData['restaurant']->name . '|' . $allData['menu']->name_en)
    @break
    @case('ru')
        @section('title', $allData['restaurant']->name . '|' . $allData['menu']->name_ru)
    @break
@endswitch

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

        .bg-purple {
            background-color: #30008A!important;
        }

        .btn-purple {
            color: #fff;
            background-color: rgb(77, 36, 212);
            border-color: rgb(77, 36, 212);
            box-shadow: none;
        }

        .btn-purple:hover {
            color: #fff;
            background-color: rgb(57, 23, 169);
            border-color: rgb(57, 23, 169);
            box-shadow: none;
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

        .box-country {
            box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px
        }

        .box-coll {
            background-color: #17a2b80a;
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
                    <a class="nav-link" href="{{ route('audit.restaurants.index') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <div class="btn-group">
                        <a type="button" class="nav-link " href="{{ route('audit.menus.index', ['lang' => $allData['lang'], 'id' => $allData['restaurant']->id]) }}">{{ $allData['restaurant']->name }}</a>
                        <button type="button" class="nav-link  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach ($allData['restaurants'] as $option)
                                <li><a class="dropdown-item" href="{{ route('audit.menus.index', ['lang' => $allData['lang'], 'id' => $option->id]) }}">{{ $option->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        @switch($allData['lang'])
                            @case('es')
                                {{ $allData['menu']->name_es }}
                            @break
                            @case('en')
                                {{ $allData['menu']->name_en }}
                            @break
                            @case('ru')
                                {{ $allData['menu']->name_ru }}
                            @break
                        @endswitch
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($allData['menus'] as $option)
                            @if ($option->type == 'comida')
                                <li>
                                    <a class="dropdown-item" href="{{ route('audit.plates.index', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'id' => $option->id]) }}">
                                        @switch($allData['lang'])
                                            @case('es')
                                                {{ $option->name_es }}
                                            @break
                                            @case('en')
                                                {{ $option->name_en }}
                                            @break
                                            @case('ru')
                                                {{ $option->name_ru }}
                                            @break
                                        @endswitch
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @if ($allData['restaurant']->food && $allData['restaurant']->drink)
                            <li><hr class="dropdown-divider"></li>
                        @elseif ($allData['restaurant']->food && $allData['restaurant']->coctel)
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        @foreach ($allData['menus'] as $option)
                            @if ($option->type == 'bebida')
                                <li>
                                    <a class="dropdown-item" href="{{ route('audit.plates.index', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'id' => $option->id]) }}">
                                        @switch($allData['lang'])
                                            @case('es')
                                                {{ $option->name_es }}
                                            @break
                                            @case('en')
                                                {{ $option->name_en }}
                                            @break
                                            @case('ru')
                                                {{ $option->name_ru }}
                                            @break
                                        @endswitch
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @if ($allData['restaurant']->drink && $allData['restaurant']->coctel)
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        @foreach ($allData['menus'] as $option)
                            @if ($option->type == 'coctel')
                                <li>
                                    <a class="dropdown-item" href="{{ route('audit.plates.index', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'id' => $option->id]) }}">
                                        @switch($allData['lang'])
                                            @case('es')
                                                <td class="align-middle">{{ $option->name_es }}</td>
                                            @break
                                            @case('en')
                                                <td class="align-middle">{{ $option->name_en }}</td>
                                            @break
                                            @case('ru')
                                                <td class="align-middle">{{ $option->name_ru }}</td>
                                            @break
                                        @endswitch
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 pb-4">
            @if ($allData['menu']->choice and $allData['menu']->country)
                @livewire('audit.restaurants.plates.plate-all', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'menu' => $allData['menu']->id])
            @elseif ($allData['menu']->choice)
                @livewire('audit.restaurants.plates.plate-choice', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'menu' => $allData['menu']->id])
            @elseif ($allData['menu']->country)
                @livewire('audit.restaurants.plates.plate-country', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'menu' => $allData['menu']->id])
            @else
                @can('menu.edit')
                    <div class="d-flex bd-highlight pb-2">
                        <div class="flex-grow-1 bd-highlight">
                            @livewire('audit.restaurants.menus.menu-update', ['menu' => $allData['menu']->id], key('update_menu'))
                        </div>
                    </div>
                @endcan
                @livewire('audit.restaurants.plates.plate-index', ['lang' => $allData['lang'], 'rest' => $allData['rest'], 'menu' => $allData['menu']->id])
            @endif
        </div>
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

        this.livewire.on('deletePlate', plateId => {
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
                    livewire.emitTo('audit.restaurants.plates.plate-index', 'delete', plateId);
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