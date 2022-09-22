@extends('adminlte::page')

@section('title', 'Reportes')

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

        .pagination > .active > a,
        .pagination > .active > a:focus,
        .pagination > .active > a:hover,
        .pagination > .active > span,
        .pagination > .active > span:focus,
        .pagination > .active > span:hover {
            background-color: #326ba7 !important;
            border-color: white !important;
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
                    <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown"  href="#" role="button" aria-expanded="false">Reportes</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('audit.dolars.index') }}">Tasas de Cambio</a></li>
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
        @livewire('audit.reports.x-m-l-index')
    </div>
@stop