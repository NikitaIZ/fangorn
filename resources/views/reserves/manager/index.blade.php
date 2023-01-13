@extends('adminlte::page')
@section('title', 'Revenue Manager')

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
    <div class="row">
        <section class="col-12">
            <ul class="nav justify-content-end nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="one-tab" data-bs-toggle="tab" data-bs-target="#one" type="button" role="tab" aria-controls="one" aria-selected="true">{{ $data["month"][0]["name"] }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="two-tab" data-bs-toggle="tab" data-bs-target="#two" type="button" role="tab" aria-controls="two" aria-selected="false">{{ $data["month"][1]["name"] }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="three-tab" data-bs-toggle="tab" data-bs-target="#three" type="button" role="tab" aria-controls="three" aria-selected="false">{{ $data["month"][2]["name"] }}</button>
                </li>
            </ul>
        </section>
    </div>
@stop

@section('content')
    <div class="row">
        <section class="col-lg-4">
            <div class="row">
                <div id="date1" class="col-6">
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
                            {{ Form::open(['route' => 'reserves.manager.store', 'class' => 'mb-0']) }}
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
                <div class="col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 style="font-size: 1.75rem;">{{ number_format($data["today"]["TDD"], 2) }} Bs</h3>
                            <p style="font-size: 1.25rem;">Tasa del Día</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        @can('dolar.show')
                            <a href="{{ route('audit.dolars.index') }}" class="small-box-footer">
                                Actualizar <i class="fas fa-fw fa-arrow-circle-right"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div id="rooms" class="col-6">
                    <div class="{{ $data["box"]['color'][0] }}">
                        <div class="inner">
                            <h3 style="font-size: 1.75rem;">{{ $data["today"]['HAB'] }}</h3>
                            <p style="font-size: 1.2rem;">Habs Ocupadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bed"></i>
                        </div>
                    </div>
                </div>
                <div id="pers" class="col-6">
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
            <div class="card" style="background: #ffffff linear-gradient(180deg,#0d4279,#1b5fa7) repeat-x!important; color: #fff;">
                <div class="card-header border-0">
                    <i class="fas fa-fw fa-percentage mr-1"></i>Porcentaje de ocupación
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button type="button" class="btn btn-sm" style="color: #0b4785!important; background-color: #ffffff!important" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="gauge-container">
                        <div id="date-{{ $date }}" data-percentage={{ number_format($data["today"]["PDS"], 2) }} class="gauge"></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="gauge-mini-container">
                                <div id="date-{{ $date }}-mini-1" data-percentage={{ number_format($data["yesterday"]["PDS"], 2) }} class="gauge-mini text-white">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="gauge-mini-container">
                                <div id="date-{{ $date }}-mini-2" data-percentage={{ number_format($data["today"]["PMS"], 2) }} class="gauge-mini">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="gauge-mini-container">
                                <div id="date-{{ $date }}-mini-3" data-percentage={{ number_format($data["today"]["PYS"], 2) }} class="gauge-mini">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-lg-8">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-circle-dollar-to-slot mr-2"></i>ADR y RevPAR
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-money-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">ADR</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">RevPAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][0]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["history"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["history"]["RVP"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][0]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["RVP"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][0]["history"]["DYS"] > 0 && $data["month"][0]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["total"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["total"]["RVP"], 2, ',', '.') }}$</span>
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
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-hotel mr-2"></i>Ocupación
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-meta-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">Habitaciones</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Ocupacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][0]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box bg-warning m-0">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ $data["month"][0]["history"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary m-0">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["history"]["OCC"], 2, ',', '.') }}</span>
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
                                                                <span class="info-box-number">{{ $data["month"][0]["forecast"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary-off m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["OCC"], 2, ',', '.') }}</span>
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
                                                                <span class="info-box-number">{{ $data["month"][0]["total"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary m-0">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["total"]["OCC"], 2, ',', '.') }}</span>
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
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-bell-concierge mr-2"></i>Ganancias por Habitaciones
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-revroom-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">Room Revenue</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Food and Beverage Revenue</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Other Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][0]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["history"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["history"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["history"]["OVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][0]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104, 0.75); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98, 0.75); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][0]["forecast"]["OVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][0]["history"]["DYS"] > 0 && $data["month"][0]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][0]["total"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][0]["total"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][0]["total"]["OVN"], 2, ",", ".") }}$</span>
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
                <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-circle-dollar-to-slot mr-2"></i>ADR y RevPAR
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-money-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">ADR</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">RevPAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][1]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["history"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["history"]["RVP"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][1]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["RVP"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][1]["history"]["DYS"] > 0 && $data["month"][1]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["total"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["total"]["RVP"], 2, ',', '.') }}$</span>
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
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-hotel mr-2"></i>Ocupación
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-meta-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">Habitaciones</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Ocupacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][1]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box bg-warning m-0">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ $data["month"][1]["history"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary m-0">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["history"]["OCC"], 2, ',', '.') }}</span>
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
                                                                <span class="info-box-number">{{ $data["month"][1]["forecast"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary-off m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["OCC"], 2, ',', '.') }}</span>
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
                                                                <span class="info-box-number">{{ $data["month"][1]["total"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary m-0">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["total"]["OCC"], 2, ',', '.') }}</span>
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
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-bell-concierge mr-2"></i>Ganancias por Habitaciones
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-revroom-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">Room Revenue</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Food and Beverage Revenue</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Other Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][1]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["history"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["history"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["history"]["OVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][1]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104, 0.75); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98, 0.75); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][1]["forecast"]["OVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][1]["history"]["DYS"] > 0 && $data["month"][1]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][1]["total"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][1]["total"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][1]["total"]["OVN"], 2, ",", ".") }}$</span>
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
                <div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-circle-dollar-to-slot mr-2"></i>ADR y RevPAR
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-money-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">ADR</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">RevPAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][2]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["history"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["history"]["RVP"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][2]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["RVP"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][2]["history"]["DYS"] > 0 && $data["month"][2]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["total"]["ADR"], 2, ',', '.') }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["total"]["RVP"], 2, ',', '.') }}$</span>
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
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-hotel mr-2"></i>Ocupación
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-meta-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">Habitaciones</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Ocupacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][2]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box bg-warning m-0">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ $data["month"][2]["history"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary m-0">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["history"]["OCC"], 2, ',', '.') }}</span>
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
                                                                <span class="info-box-number">{{ $data["month"][2]["forecast"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary-off m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["OCC"], 2, ',', '.') }}</span>
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
                                                                <span class="info-box-number">{{ $data["month"][2]["total"]["NRS"] }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box bg-primary m-0">
                                                            <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["total"]["OCC"], 2, ',', '.') }}</span>
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
                    <div class="card">
                        <div class="card-header" style="background-color: #0c437d!important; color: white;">
                            <i class="fa-solid fa-fw fa-bell-concierge mr-2"></i>Ganancias
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <button type="button" class="btn bg-light btn-sm" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="chart">
                                    <div style="position: relative; height:400px; width:auto">
                                        <canvas id="forecast-revroom-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                    </div>
                                    <table class="table table-borderless table-responsive m-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center" style="width: 50vw;">Room Revenue</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Food and Beverage Revenue</th>
                                                <th scope="col" class="text-center" style="width: 50vw;">Other Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data["month"][2]["history"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["history"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["history"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["history"]["OVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][2]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131, 0.75); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104, 0.75); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98, 0.75); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{ number_format($data["month"][2]["forecast"]["OVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($data["month"][2]["history"]["DYS"] > 0 && $data["month"][2]["forecast"]["DYS"] > 0)
                                                <tr>
                                                    <td scope="row">
                                                        <div class="info-box m-0" style="background-color: rgb(47, 159, 131); color:white">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][2]["total"]["RVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(97, 217, 104); color: #343434;">
                                                            <span class="info-box-icon"><i class="fas fa-solid fa-burger"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][2]["total"]["FVN"], 2, ",", ".") }}$</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info-box m-0" style="background-color: rgb(195, 225, 98); color: #525050;">
                                                            <span class="info-box-icon"><i class="fa-solid fa-piggy-bank"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-number">{{number_format($data["month"][2]["total"]["OVN"], 2, ",", ".") }}$</span>
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
@stop

@section('js')
    <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <script type="text/javascript" src="//d3js.org/d3.v4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <script type="text/javascript" src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>
    <script type="text/javascript" src="../js/guage.babel.js"></script>
    <script type="text/javascript" src="../js/revenue_manager_charts.babel.js" defer></script>

    <script>
        const report = {!! json_encode($data) !!};
        const date   = {!! json_encode($date) !!};
    </script>
@stop