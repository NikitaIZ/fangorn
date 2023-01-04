@laravelPWA

@extends('adminlte::page')
@section('title', 'Dashboard')

@section('css')
    <style>
        .nav-pills .nav-link.wyndham.active, .nav-pills .show>.nav-link {
            color: #0c437d;
            background-color: #ffffff;
        }
        .nav-pills .nav-link.wyndham:not(.active):hover {
            color: #ffffff;
        }

        .nav-pills .nav-link.wyndham {
            color: #ffffff;
        }

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
    </style>
@stop

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div>
    <div class="row">
        <div id="date1" class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 style="font-size: 1.5rem;">{{ $number }}</h3>
                    <p style="font-size: 1.5rem;">Fecha</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <a onclick="show_form()" class="small-box-footer">
                    Actualizar <i class="fas fa-fw fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div id="date2" class="invisible d-none">
            <div class="small-box bg-info">
                <div class="inner">
                    {{ Form::open(['route' => 'dashboard.store', 'class' => 'mb-0']) }}
                        {{ Form::token(); }}
                        {{ Form::date('date', $start, array_merge(['class' => 'form-control mb-2', 'min' => $end, 'max' => $start])); }}
                        <div class="d-grid gap-2">
                            {{ Form::submit('Enviar', array_merge(['class' => 'btn btn-light'])); }}
                        </div>
                    {{ Form::close() }}
                </div>
                <a onclick="hidden_form()" class="small-box-footer">
                    cancelar <i class="fas fa-fw fa-times"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ number_format($data["today"]["TDD"], 2) }} Bs</h3>
                    <p style="font-size: 1.25rem;">Tasa del Día</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                @can('dolar.index')
                    <a href="{{ route('audit.dolars.index') }}" class="small-box-footer">
                        Actualizar <i class="fas fa-fw fa-arrow-circle-right"></i>
                    </a>
                @endcan
            </div>
        </div>
        <div id="rooms" class="col-lg-3 col-6">
            <div class="{{ $data["box"]['color'][0] }}">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ $data["today"]['HAB'] }}</h3>
                    <p style="font-size: 1.2rem;">Habs Ocupadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                </div>
                <a onclick="show_HAR()" class="small-box-footer">
                    OCC Real <i class="fas fa-fw fa-circle-info"></i>
                </a>
            </div>
        </div>
        <div id="real" class="invisible d-none">
            <div class="{{ $data["box"]['color'][0] }}">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ $data["today"]['HAR'] }}</h3>
                    <p style="font-size: 1.2rem;">Habs Ingresos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                </div>
                <a onclick="hidden_HAR()" class="small-box-footer">
                    OCC Total <i class="fas fa-bed"></i>
                </a>
            </div>
        </div>
        <div id="pers" class="col-lg-3 col-6">
            <div class="{{ $data["box"]['color'][1] }}">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ $data["today"]['PAX'] }}</h3>
                    <p style="font-size: 1.25rem;">Huespedes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a onclick="show_RAT()" class="small-box-footer">
                    R.A.T <i class="fas fa-fw fa-circle-info"></i>
                </a>
            </div>
        </div>
        <div id="rat" class="invisible d-none">
            <div class="{{ $data["box"]['color'][1] }}">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ number_format($data["today"]['PAX'] / $data["today"]['HAB'] , 2) }}</h3>
                    <p style="font-size: 1.25rem;">R.A.T</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a onclick="hidden_RAT()" class="small-box-footer">
                    Huespedes <i class="fas fa-fw fa-user"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <section class="col-lg-8">
            <div class="card">
                <div class="card-header" style="background-color: #0c437d!important; color: white;">
                    <i class="fas fa-fw fa-calendar-week mr-2"></i>Semana
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link wyndham active" href="#week-graf-2" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham" href="#week-graf-3" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham" href="#week-graf-4" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham" href="#week-graf-5" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2" href="#week-graf-6" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">5</a>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn bg-white btn-sm p-2" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="chart tab-pane active" id="week-graf-2">
                            <div style="position: relative; height:450px; width:auto">
                                <canvas id="week-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="week-graf-3">
                            <h5 class="text-center">Tipos de Habitaciones</h5>
                            <div style="position: relative; height:450px; width:auto">
                                <canvas id="week-4-rooms-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="week-graf-4">
                            <div class="card-tools pb-3">
                                <ul class="nav nav-pills justify-content-center">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#persons-graf-1" data-bs-toggle="tab">Total</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#persons-graf-2" data-bs-toggle="tab">Adultos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#persons-graf-3" data-bs-toggle="tab">Niños</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="chart tab-pane active" id="persons-graf-1">
                                    <div style="position: relative; height:450px; width:auto">
                                        <canvas id="week-4-people-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                                <div class="chart tab-pane" id="persons-graf-2">
                                    <div style="position: relative; height:450px; width:auto">
                                        <canvas id="week-4-adults-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                                <div class="chart tab-pane" id="persons-graf-3">
                                    <div style="position: relative; height:450px; width:auto">
                                        <canvas id="week-4-childrem-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="week-graf-5">
                            <h5 class="text-center">R.A.T</h5>
                            <div style="position: relative; height:450px; width:auto">
                                <canvas id="week-4-rat-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="week-graf-6">
                            <div style="position: relative; height:450px; width:auto">
                                <canvas id="week-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #0c437d!important; color: white;">
                    <i class="fa-solid fa-fw fa-calendar-days mr-2"></i>Mes
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2 active" href="#forecast-graf-2" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2" href="#forecast-graf-3" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2" href="#forecast-graf-4" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">3</a>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn bg-white btn-sm p-2" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="tab-pane active" id="forecast-graf-2">
                            <div class="row">
                                <div class="card-tools pb-3">
                                    <ul class="nav nav-pills justify-content-center">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#month-occ-1" data-bs-toggle="tab">{{ $data["month"][0]["name"] }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#month-occ-2" data-bs-toggle="tab">{{ $data["month"][1]["name"] }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#month-occ-3" data-bs-toggle="tab">{{ $data["month"][2]["name"] }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="chart tab-pane active" id="month-occ-1">
                                        <div class="mb-2" style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-occ-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Habitaciones</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Huespedes</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Ocupación</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][0]["history"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["history"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger m-0">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["history"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-primary m-0">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][0]["history"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][0]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning-off m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["forecast"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger-off m-0" style="color: white;">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["forecast"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][0]["history"]["DYS"] > 0 && $data["month"][0]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["total"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger m-0">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["total"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-primary m-0">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][0]["total"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="chart tab-pane" id="month-occ-2">
                                        <div class="mb-2" style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-occ-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Habitaciones</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Huespedes</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Ocupación</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][1]["history"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["history"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger m-0">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["history"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-primary m-0">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][1]["history"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][1]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning-off m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["forecast"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger-off m-0" style="color: white;">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["forecast"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][1]["history"]["DYS"] > 0 && $data["month"][1]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["total"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger m-0">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["total"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-primary m-0">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][1]["total"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="chart tab-pane" id="month-occ-3">
                                        <div class="mb-2" style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-occ-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Habitaciones</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Huespedes</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Ocupación</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][2]["history"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["history"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger m-0">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["history"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-primary m-0">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][2]["history"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][2]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning-off m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["forecast"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger-off m-0" style="color: white;">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["forecast"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][2]["history"]["DYS"] > 0 && $data["month"][2]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box bg-warning m-0">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["total"]["NRS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-danger m-0">
                                                                <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["total"]["NPS"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box bg-primary m-0">
                                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ number_format($data["month"][2]["total"]["OCC"] , 2, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="forecast-graf-3">
                            <div class="row">
                                <div class="card-tools pb-3">
                                    <ul class="nav nav-pills justify-content-center">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#month-tor-1" data-bs-toggle="tab">{{ $data["month"][0]["name"] }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#month-tor-2" data-bs-toggle="tab">{{ $data["month"][1]["name"] }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#month-tor-3" data-bs-toggle="tab">{{ $data["month"][2]["name"] }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="chart tab-pane active" id="month-tor-1">
                                        <div style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-rooms-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    @foreach ($data["month"][0]["TOR"] as $names)
                                                        <th scope="col" class="text-center" style="width: 30rem;">{{ $names["descrip"] }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][0]["history"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][0]["history"]["TOR"] as $history)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $history["color"] }}, 1)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Historico</span>
                                                                        <span class="info-box-number">{{ $history["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                                @if ($data["month"][0]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][0]["forecast"]["TOR"] as $forecast)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $forecast["color"] }}, 0.5)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Pronostico</span>
                                                                        <span class="info-box-number">{{ $forecast["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                                @if ($data["month"][0]["history"]["DYS"] > 0 && $data["month"][0]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][0]["total"]["TOR"] as $total)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $total["color"] }}, 1)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Total</span>
                                                                        <span class="info-box-number">{{ $total["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="chart tab-pane" id="month-tor-2">
                                        <div style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-rooms-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    @foreach ($data["month"][1]["TOR"] as $names)
                                                        <th scope="col" class="text-center" style="width: 30rem;">{{ $names["descrip"] }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][1]["history"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][1]["history"]["TOR"] as $history)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $history["color"] }}, 1)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Historico</span>
                                                                        <span class="info-box-number">{{ $history["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                                @if ($data["month"][1]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][1]["forecast"]["TOR"] as $forecast)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $forecast["color"] }}, 0.5)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Pronostico</span>
                                                                        <span class="info-box-number">{{ $forecast["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                                @if ($data["month"][1]["history"]["DYS"] > 0 && $data["month"][1]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][1]["total"]["TOR"] as $total)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $total["color"] }}, 1)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Total</span>
                                                                        <span class="info-box-number">{{ $total["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="chart tab-pane" id="month-tor-3">
                                        <div style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-rooms-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    @foreach ($data["month"][2]["TOR"] as $names)
                                                        <th scope="col" class="text-center" style="width: 30rem;">{{ $names["descrip"] }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][2]["history"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][2]["history"]["TOR"] as $history)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $history["color"] }}, 1)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Historico</span>
                                                                        <span class="info-box-number">{{ $history["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                                @if ($data["month"][2]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][2]["forecast"]["TOR"] as $forecast)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $forecast["color"] }}, 0.5)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Pronostico</span>
                                                                        <span class="info-box-number">{{ $forecast["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                                @if ($data["month"][2]["history"]["DYS"] > 0 && $data["month"][2]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        @foreach ($data["month"][2]["total"]["TOR"] as $total)
                                                            <td scope="row">
                                                                <div class="info-box m-0" style="{{ $total["color"] }}, 1)">
                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Total</span>
                                                                        <span class="info-box-number">{{ $total["rooms"] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="forecast-graf-4">
                            <div class="row">
                                <div class="card-tools pb-3">
                                    <ul class="nav nav-pills justify-content-center">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#month-arr-1" data-bs-toggle="tab">{{ $data["month"][0]["name"] }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#month-arr-2" data-bs-toggle="tab">{{ $data["month"][1]["name"] }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#month-arr-3" data-bs-toggle="tab">{{ $data["month"][2]["name"] }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="chart tab-pane active" id="month-arr-1">
                                        <div class="mb-2" style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-arrival-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Arrival</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Departure</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][0]["history"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["history"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["history"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][0]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["forecast"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["forecast"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][0]["history"]["DYS"] > 0 && $data["month"][0]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["total"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][0]["total"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="chart tab-pane" id="month-arr-2">
                                        <div class="mb-2" style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-arrival-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Arrival</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Departure</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][1]["history"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["history"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["history"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][1]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["forecast"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["forecast"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][1]["history"]["DYS"] > 0 && $data["month"][1]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["total"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][1]["total"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="chart tab-pane" id="month-arr-3">
                                        <div class="mb-2" style="position: relative; height:450px; width:auto">
                                            <canvas id="forecast-arrival-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <table class="table table-borderless table-responsive m-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Arrival</th>
                                                    <th scope="col" class="text-center" style="width: 50vw;">Departure</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data["month"][2]["history"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["history"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Historico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["history"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][2]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["forecast"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80, 0.75); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Pronostico</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["forecast"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($data["month"][2]["history"]["DYS"] > 0 && $data["month"][2]["forecast"]["DYS"] > 0)
                                                    <tr>
                                                        <td scope="row">
                                                            <div class="info-box m-0" style="background-color: rgb(27, 188, 155); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-plane-arrival"></i></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["total"]["ARR"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-box m-0" style="background-color: rgb(45, 62, 80); color:white">
                                                                <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Total</span>
                                                                    <span class="info-box-number">{{ $data["month"][2]["total"]["DEP"] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #0c437d!important; color: white;">
                    <i class="fa-solid fa-fw fa-calendar-day mr-2"></i>Cada año
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2 active" href="#year-graf-2" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2" href="#year-graf-3" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link wyndham mr-2" href="#year-graf-4" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">3</a>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn bg-white btn-sm p-2" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="chart tab-pane active" id="year-graf-2" >
                            <h6 class="text-center">
                                <strong>Porcentaje de Ocupacion %</strong>
                            </h6>
                            <div>
                                <div style="position: relative; height:400px; width:auto">
                                    <canvas id="year-day-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="year-graf-3">
                            <div style="position: relative; height:400px; width:auto">
                                <canvas id="year-day-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="chart tab-pane" id="year-graf-4">
                            <div style="position: relative; height:400px; width:auto">
                                <canvas id="year-day-4-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-lg-4">
            <div class="card" style="background: #ffffff linear-gradient(180deg,#0d4279,#1b5fa7) repeat-x!important; color: #fff;">
                <div class="card-header border-0">
                    <i class="fas fa-fw fa-percentage mr-1"></i>Porcentaje de ocupación
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button type="button" class="btn btn-sm p-2" style="color: #0b4785!important; background-color: #ffffff!important" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <!--<button type="button" class="btn bg-primary btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>-->
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="gauge-container">
                        <div id="date-{{ $date }}" data-percentage={{ $data["today"]["PDS"] }} class="gauge"></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="gauge-mini-container">
                                <div id="date-{{ $date }}-mini-1" data-percentage={{ $data["yesterday"]["PDS"] }} class="gauge-mini text-white">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="gauge-mini-container">
                                <div id="date-{{ $date }}-mini-2" data-percentage={{ $data["today"]["PMS"] }} class="gauge-mini">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="gauge-mini-container">
                                <div id="date-{{ $date }}-mini-3" data-percentage={{ $data["today"]["PYS"] }} class="gauge-mini">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #0c437d!important; color: white;">
                    <i class="fa-solid fa-fw fa-percent mr-2"></i>Detalles de Ocupación
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button type="button" class="btn bg-light btn-sm p-2" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body px-0 pt-2">
                    @foreach ($data["types"] as $value)
                        <h5 class="text-center pt-2"> {{ $value["descrip"] }}: {{ $value["rooms"][0] }} ({{ number_format($value["per"][0], 2) }}%)</h5>
                        <div class="px-4">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ $value["per"][0] }}%; {{ $value["color"] }}, 1)" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #0c437d!important; color: white;">
                    <i class="fas fa-fw fa-clipboard-list mr-2"></i>Reporte del Día
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a href="{{ route('audit.reports.index') }}" class="btn btn-light btn-sm mr-2" style="padding: 0.25rem 0.75em">
                                    Ver Todos
                                </a>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn bg-light btn-sm p-2" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive"> 
                        <table class="table table-striped m-0">
                            <tbody class="table-light">
                                <tr>
                                    <td scope="row">Rooms Occupied (Hab):</td>
                                    <td colspan="2" class="text-center align-middle">{{ $data["today"]['HAB'] }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Total In-House Persons (Pax):</td>
                                    <td colspan="2" class="text-center align-middle">{{ $data["today"]['PAX'] }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Percentage of Occupied Rooms (%):</td>
                                    <td colspan="2" class="text-center align-middle">{{ number_format($data["today"]["PDS"], 2) }}%</td>
                                </tr>
                                <tr>
                                    <td scope="row">Average Daily Rate (ADR):</td>
                                    <td class="text-center align-middle">{{ number_format($data["today"]['ADR'], 2) }}$</td>
                                    <td class="text-center align-middle">{{ number_format($data["today"]['ADB'], 2) }}Bs</td>
                                </tr>
                                <tr>
                                    <td scope="row">Revenue Per Available Room Day (RevPAR):</td>
                                    <td class="text-center align-middle">{{ number_format($data["today"]['RVP'], 2)  }}$</td>
                                    <td class="text-center align-middle">{{ number_format($data["today"]['RVB'], 2)  }}Bs</td>
                                </tr>
                                <tr>
                                    <td scope="row">Arrival Rooms (ARR):</td>
                                    <td colspan="2" class="text-center align-middle">{{ $data["today"]['ARR'] }}</td>
                                </tr>
                                <tr>
                                    <td scope="row">Departure Rooms (DEP):</td>
                                    <td colspan="2" class="text-center align-middle">{{ $data["today"]['DEP'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('audit.reports.show', $data["today"]["IDR"]) }}" class="btn btn-sm btn-wyndham">
                        Detalles
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background-color: #0c437d!important; color: white;">
                    <i class="fa-solid fa-fw fa-utensils mr-2"></i>Buffet
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button type="button" class="btn bg-light btn-sm p-2" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive"> 
                        <table class="table table-striped m-0">
                            <thead class="table-primary" style="color: #0c437d;">
                                <tr>
                                    <th scope="col">Services</th>
                                    <th scope="col" class="text-center">Adults</th>
                                    <th scope="col" class="text-center">Children</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">
                                @foreach ($data["buffet"] as $service)
                                    <tr>
                                        <td scope="row">{{ $service->service }}</td>
                                        <td class="text-center align-middle">{{ $service->adults }}$</td>
                                        <td class="text-center align-middle">{{ $service->children }}$</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @can('buffet.index')
                    <div class="card-footer text-center">
                        <a href="{{ route('audit.buffets.index') }}" class="btn btn-sm btn-wyndham">
                            Actualizar
                        </a>
                    </div>
                @endcan
            </div>
        </section>
    </div>
    <svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="gradientGauge">
                <stop class="color-red" offset="0%"/>
                <stop class="color-orange" offset="25%"/>
                <stop class="color-yellow" offset="50%"/>
                <stop class="color-green-light" offset="75%"/>
                <stop class="color-green" offset="100%"/>
            </linearGradient>
        </defs>  
    </svg>
</div>
@stop

@section('js')
    <script type="text/javascript" src="//d3js.org/d3.v4.min.js"></script>
    <script type="text/javascript" src="js/dashboard_charts.babel.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <script type="text/javascript" src="js/guage.babel.js"></script>

    <script>
        function financial(x){
            return Number.parseFloat(x).toFixed(2);
        };
        function show_form(){
            date1.className = "invisible d-none";
            date2.className = "col-lg-3 col-6";
        };
        function hidden_form(){
            date1.className = "col-lg-3 col-6";
            date2.className = "invisible d-none";
        };
        function show_HAR(){
            rooms.className = "invisible d-none";
            real.className   = "col-lg-3 col-6";
        };
        function hidden_HAR(){
            rooms.className = "col-lg-3 col-6";
            real.className   = "invisible d-none";
        };
        function show_RAT(){
            pers.className = "invisible d-none";
            rat.className   = "col-lg-3 col-6";
        };
        function hidden_RAT(){
            pers.className = "col-lg-3 col-6";
            rat.className   = "invisible d-none";
        };

        var report = {!! json_encode($data) !!};
        var date   = {!! json_encode($date) !!};

        var charts   = charts_array_minus(report);
        var types    = types_array(report);
        var forecast = forecast_array_three(report);
        var foretype = forecast_types_array_three(report);
        var array    = gauges_array(date);

        charts_show(charts);
        charts_types_show(types);
        charts_forecast_show(forecast);
        charts_forecast_types_show(foretype);
        gauges_show(array);
    </script>
@stop