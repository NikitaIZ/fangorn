@extends('adminlte::page')
@section('title', 'Cenas')

@section('css')
    <style>
    .main {
        width: 100%;
        overflow: auto;
        cursor: grab;
        cursor: -o-grab;
        cursor: -moz-grab;
        cursor: -webkit-grab;
    }

    .main img {
        height: auto;
        width: 100%;
    }

    .table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    background-color: transparent;
}

    </style>
@stop

@section('content')
    <div class="row py-2">
        <div class="col-lg-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ number_format($data["christmas"]["2022"]["total"] + $data["new_year"]["2022"]["total"], 0, ',', '.') }}$</h3>
                    <p style="font-size: 1.25rem;">Total de Ventas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ number_format($data["christmas"]["2022"]["total"], 0, ',', '.') }}$</h3>
                    <p style="font-size: 1.25rem;">Navidad</p>
                </div>
                <div class="icon">
                    <i class="fas fa-gifts"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ number_format($data["new_year"]["2022"]["total"], 0, ',', '.') }}$</h3>
                    <p style="font-size: 1.25rem;">Año Nuevo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wine-bottle"></i>
                </div>
            </div>
        </div>
        <section class="col-12">
            <ul class="nav justify-content-end nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="one-tab" data-bs-toggle="tab" data-bs-target="#one" type="button" role="tab" aria-controls="one" aria-selected="true">Navidad</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="two-tab" data-bs-toggle="tab" data-bs-target="#two" type="button" role="tab" aria-controls="two" aria-selected="false">Año Nuevo</button>
                </li>
            </ul>
        </section>
    </div>

    <div class="row">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show" id="one" role="tabpanel" aria-labelledby="one-tab">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-chart-area mr-1"></i>
                                    Comparación
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-center">
                                            <strong>Cenas de Navidad</strong>
                                        </p>
                                        <div class="chart" style="height: 300px">
                                            <canvas id="christmas-years-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-center">
                                            <strong>2022</strong>
                                        </h5>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fa-solid fa-sack-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["christmas"]["2022"]["total"], 0, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        <h5 class="text-center">
                                            <strong>2021</strong>
                                        </h5>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fa-solid fa-sack-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["christmas"]["2021"]["total"], 0, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Actividad
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto" role="tablist">
                                        <li class="nav-item">
                                            <a href="{{ route('reserves.dinners.christmas') }}" class="btn bg-primary  btn-sm mr-2">
                                                Ver Detalles
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 pb-4">
                                        <p class="text-center">
                                            <strong>Cena Navideña 2022</strong>
                                        </p>
                                        <div class="chart" style="height: 300px;">
                                            <canvas id="christmas-2022-sales-chart-canvas" height="200" style="height: 200px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong>Ocupación</strong>
                                        </p>
                                        @foreach ($data["christmas"]["2022"]["groups"] as $dato)
                                        <div class="progress-group">
                                            <span class="progress-text">Zona {{ $dato["name"] }} ({{ $dato['per'] }}%)</span>
                                            <span class="float-right"><b>{{ $dato["count"] }}</b>/{{ $dato["volume"] }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar {{ $dato["color"] }}"" style="width: {{ $dato['per'] }}%"></div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="text-center pt-2">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#christmastModal">
                                                Ver Plano
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-8 pb-4">
                                        <p class="text-center">
                                            <strong>Cena Navideña 2021</strong>
                                        </p>
                                        <div class="chart" style="height: 300px;">
                                            <canvas id="christmas-2021-sales-chart-canvas" height="200" style="height: 200px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong>Ocupación</strong>
                                        </p>
                                        @foreach ($data["christmas"]["2021"]["groups"] as $dato)
                                        <div class="progress-group">
                                            <span class="progress-text">Zona {{ $dato["name"] }} ({{ $dato['per'] }}%)</span>
                                            <span class="float-right"><b>{{ $dato["count"] }}</b>/{{ $dato["volume"] }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar {{ $dato["color"] }}"" style="width: {{ $dato['per'] }}%"></div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="text-center pt-2">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#christmast2021Modal">
                                                Ver Plano
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="christmastModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="christmastModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="christmastModalLabel">Plano Cena Navideña 2022</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="main dragscroll text-center">
                                                    <img id="christmastImg" src="/img/planes/plano2.png" alt="Cena Navideña">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="zoomin('christmastImg')">
                                                    <i class="fas fa-search-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="zoomout('christmastImg')">
                                                    <i class="fas fa-search-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="christmast2021Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="christmastModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="christmastModalLabel">Plano Cena Navideña 2021</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="main dragscroll text-center">
                                                    <img id="christmastImg" src="/img/planes/plano_navidad.png" alt="Cena Navideña">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="zoomin('christmastImg')">
                                                    <i class="fas fa-search-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="zoomout('christmastImg')">
                                                    <i class="fas fa-search-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-divide mr-1"></i>
                                    Promedio
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="col-auto"></th>
                                                <th scope="col" class="col-3">Ventas</th>
                                                <th scope="col" class="col-3">Pax</th>
                                                <th scope="col" class="col-4">Entradas</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th scope="row">2022</th>
                                                <td>{{ number_format($data["christmas"]["2022"]["total"], 0, ',', '.') }}$</td>
                                                <td>{{ $data["christmas"]["2022"]["tickets"] }}</td>
                                                <td>0 $</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2021</th>
                                                <td>{{ number_format($data["christmas"]["2021"]["total"], 0, ',', '.') }}$</td>
                                                <td>{{ $data["christmas"]["2021"]["tickets"] }}</td>
                                                <td>{{ round($data["christmas"]["2021"]["total"] / $data["christmas"]["2021"]["tickets"]) }} $</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Ganancias
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10 pb-4">
                                        <p class="text-center">
                                            <strong>Cena Navideña 2022</strong>
                                        </p>
                                        <div class="chart" style="height: 300px;">
                                            <canvas id="christmas-2022-earnings-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="text-center">
                                            <strong>Información</strong>
                                        </p>
                                        <div class="info-box mb-3 bg-primary">
                                            <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Costo F + V</span>
                                                <span class="info-box-number">{{ number_format($point["christmas"]["2022"]["initial"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        @if (end($point["christmas"]["2022"]["meta"]) <= 0)
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-level-down-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Perdidas</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2022"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2022"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-level-up-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Ganancias</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2022"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2022"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-10 pb-4">
                                        <p class="text-center">
                                            <strong>Cena Navideña 2021</strong>
                                        </p>
                                        <div class="chart" style="height: 300px;">
                                            <canvas id="christmas-2021-earnings-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="text-center">
                                            <strong>Información</strong>
                                        </p>
                                        <div class="info-box mb-3 bg-primary">
                                            <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Costo F + V</span>
                                                <span class="info-box-number">{{ number_format($point["christmas"]["2021"]["initial"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        @if (end($point["christmas"]["2021"]["meta"]) <= 0)
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-level-down-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Perdidas</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2021"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2021"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-level-up-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Ganancias</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2021"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["christmas"]["2021"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-tag mr-1"></i>
                                    Precios
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="prices-christmas-chart-canvas" width="300" height="300" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Numero de Ventas
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="quantity-christmas-chart-canvas" width="250" height="250" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-male mr-1"></i>
                                    Personas
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="people-christmas-chart-canvas" width="300" height="300"  class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="tab-pane fade show active" id="two" role="tabpanel" aria-labelledby="two-tab">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-chart-area mr-1"></i>
                                    Comparación
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-center">
                                            <strong>Cenas de Año Nuevo</strong>
                                        </p>
                                        <div class="chart" style="height: 300px">
                                            <canvas id="new-year-years-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-center">
                                            <strong>2022</strong>
                                        </h5>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fa-solid fa-sack-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["new_year"]["2022"]["total"], 0, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        <h5 class="text-center">
                                            <strong>2021</strong>
                                        </h5>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fa-solid fa-sack-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["new_year"]["2021"]["total"], 0, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Actividad
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto" role="tablist">
                                        <li class="nav-item">
                                            <a href="{{ route('reserves.dinners.newYear') }}" class="btn bg-primary btn-sm mr-2">
                                                Ver Detalles
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <p class="text-center">
                                            <strong>Cena de Año Nuevo 2022</strong>
                                        </p>
                                        <div class="chart" style="height: 300px;">
                                            <canvas id="new-year-2022-sales-chart-canvas" height="200" style="height: 200px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong>Ocupación</strong>
                                        </p>
                                        @foreach ($data["new_year"]["2022"]["groups"] as $dato)
                                            <div class="progress-group">
                                                <span class="progress-text">Zona {{ $dato["name"] }} ({{ $dato['per'] }}%)</span>
                                                <span class="float-right"><b>{{ $dato["count"] }}</b>/{{ $dato["volume"] }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar {{ $dato["color"] }}" style="width: {{ $dato['per'] }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="text-center pt-2">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#NewYearModal">
                                                Ver Plano
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="text-center">
                                            <strong>Cena de Año Nuevo 2021</strong>
                                        </p>
                                        <div class="chart" style="height: 300px;">
                                            <canvas id="new-year-2021-sales-chart-canvas" height="200" style="height: 200px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong>Ocupación</strong>
                                        </p>
                                        @foreach ($data["new_year"]["2021"]["groups"] as $dato)
                                            <div class="progress-group">
                                                <span class="progress-text">Zona {{ $dato["name"] }} ({{ $dato['per'] }}%)</span>
                                                <span class="float-right"><b>{{ $dato["count"] }}</b>/{{ $dato["volume"] }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar {{ $dato["color"] }}" style="width: {{ $dato['per'] }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="text-center pt-2">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#NewYearModal2021">
                                                Ver Plano
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="NewYearModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="NewYearModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="NewYearModalLabel">Plano Cena de Año Nuevo 2022</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="main dragscroll text-center">
                                                    <img id="NewYearImg" src="/img/planes/plano_año_nuevo_2022.png" alt="Cena Año Nuevo">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="zoomin('NewYearImg')">
                                                    <i class="fas fa-search-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="zoomout('NewYearImg')">
                                                    <i class="fas fa-search-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="NewYearModal2021" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="NewYearModal2021Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="NewYearModal2021Label">Plano Cena de Año Nuevo 2021</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="main dragscroll text-center">
                                                    <img id="NewYearImg" src="/img/planes/plano_año_nuevo.png" alt="Cena Año Nuevo">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="zoomin('NewYearImg')">
                                                    <i class="fas fa-search-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="zoomout('NewYearImg')">
                                                    <i class="fas fa-search-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-divide mr-1"></i>
                                    Promedio Ventas Pagas
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="col-auto"></th>
                                                <th scope="col" class="col-3">Ventas</th>
                                                <th scope="col" class="col-3">Pax</th>
                                                <th scope="col" class="col-4">Entradas</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th scope="row">2022</th>
                                                <td>{{ number_format($data["new_year"]["2022"]["total"], 0, ',', '.') }}$</td>
                                                <td>{{ $data["new_year"]["2022"]["coupons"] }}</td>
                                                <td>{{ round($data["new_year"]["2022"]["total"] / $data["new_year"]["2022"]["coupons"]) }} $</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2021</th>
                                                <td>{{ number_format($data["new_year"]["2021"]["total"], 0, ',', '.') }}$</td>
                                                <td>{{ $data["new_year"]["2021"]["tickets"] }}</td>
                                                <td>{{ round($data["new_year"]["2021"]["total"] / $data["new_year"]["2021"]["tickets"]) }} $</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-solid fa-tag"></i>
                                    Cupones
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="col-auto"></th>
                                                <th scope="col" class="col-auto">Total</th>
                                                <th scope="col" class="col-auto">PAX</th>
                                                <th scope="col" class="col-auto">Entradas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Cortesía</th>
                                                <td>{{ $data["new_year"]["2022"]["courtesy"] }}</td>
                                                <td>{{ $data["new_year"]["2022"]["tickets"] - $data["new_year"]["2022"]["courtesy"] }}</td>
                                                <td>{{ round($data["new_year"]["2022"]["total"] / ($data["new_year"]["2022"]["tickets"] - $data["new_year"]["2022"]["courtesy"])) }} $</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Funcionarios</th>
                                                <td>{{ $data["new_year"]["2022"]["officers"] }}</td>
                                                <td>{{ $data["new_year"]["2022"]["tickets"] - $data["new_year"]["2022"]["courtesy"] - $data["new_year"]["2022"]["officers"]}}</td>
                                                <td>{{ round($data["new_year"]["2022"]["total"] / ($data["new_year"]["2022"]["tickets"] - $data["new_year"]["2022"]["courtesy"] - $data["new_year"]["2022"]["officers"])) }} $</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Intercambio</th>
                                                <td>{{ $data["new_year"]["2022"]["exchange"] }}</td>
                                                <td>{{ $data["new_year"]["2022"]["tickets"] - $data["new_year"]["2022"]["courtesy"] - $data["new_year"]["2022"]["officers"] - $data["new_year"]["2022"]["exchange"]}}</td>
                                                <td>{{ round($data["new_year"]["2022"]["total"] / ($data["new_year"]["2022"]["tickets"] - $data["new_year"]["2022"]["courtesy"] - $data["new_year"]["2022"]["officers"] - $data["new_year"]["2022"]["exchange"])) }} $</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <i class="fas fa-chart-line mr-1"></i>
                                    Ganancias
                                </h5>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10 pb-4">
                                        <p class="text-center">
                                            <strong>Cena de Año Nuevo 2022</strong>
                                        </p>
                                        <div class="chart">
                                            <canvas id="new-year-2022-earnings-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="text-center">
                                            <strong>Información</strong>
                                        </p>
                                        <div class="info-box mb-3 bg-primary">
                                            <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Costo F + V</span>
                                                <span class="info-box-number">{{ number_format($point["new_year"]["2022"]["initial"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        @if (end($point["new_year"]["2022"]["meta"]) <= 0)
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-level-down-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Perdidas</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2022"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2022"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-level-up-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Ganancias</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2022"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2022"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-10 pb-4">
                                        <p class="text-center">
                                            <strong>Cena de Año Nuevo 2021</strong>
                                        </p>
                                        <div class="chart">
                                            <canvas id="new-year-2021-earnings-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="text-center">
                                            <strong>Información</strong>
                                        </p>
                                        <div class="info-box mb-3 bg-primary">
                                            <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Costo F + V</span>
                                                <span class="info-box-number">{{ number_format($point["new_year"]["2021"]["initial"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        @if (end($point["new_year"]["2021"]["meta"]) <= 0)
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-level-down-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Perdidas</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2021"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-danger">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2021"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-level-up-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Ganancias</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2021"]["meta"]), 2, ',', '.') }}$</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-success">
                                                <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Porcentaje</span>
                                                    <span class="info-box-number">{{ number_format(end($point["new_year"]["2021"]["perc"]), 2, ',', '.') }}%</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-tag mr-1"></i>
                                    Precios
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    <canvas id="prices-new-year-chart-canvas" width="300" height="300" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable ">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Numero de Ventas
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="quantity-new-year-chart-canvas" width="250" height="250" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable ">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-male mr-1"></i>
                                    Personas
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button type="button" class="btn bg-primary btn-sm" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="people-new-year-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script type="text/javascript" src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>

    <script>
        const sales = {!! json_encode($data) !!};
        const point = {!! json_encode($point) !!};
        const years = {!! json_encode($years) !!};

        const grill = {
            x: {
                grid: {
                    color: "rgba(0, 0, 0, 0)",
                    borderColor: "rgb(12, 67, 125)",
                },
                ticks: {
                    color: 'black',
                    font: {
                        weight: 'bold',
                    }
                }
            },
            y: {
                grid: {
                    color: "rgba(0, 0, 0, 0)",
                    borderColor: "rgb(12, 67, 125)",
                },
                ticks: {
                    color: 'black',
                    font: {
                        weight: 'bold',
                    }
                }
            }
        };

        function financial(x) {
            return Number.parseFloat(x).toFixed(2);
        }

        function colorize(opaque) {
            if (opaque === true){
                return (ctx) => {
                    const v = ctx.parsed.y;
                    const c = v < -50 ? 'rgba(214, 0, 0, 0.5)'
                    : v < 0 ? 'rgba(214, 0, 0, 0.5)'
                    : v < 50 ? 'rgba(68, 222, 40, 0.5)'
                    : 'rgba(68, 222, 40, 0.5)';
                    return c;
                };
            }else{
                return (ctx) => {
                    const v = ctx.parsed.y;
                    const c = v < -50 ? 'rgba(214, 0, 0, 1)'
                    : v < 0 ? 'rgba(214, 0, 0, 1)'
                    : v < 50 ? 'rgba(68, 222, 40, 1)'
                    : 'rgba(68, 222, 40, 1)';
                    return c;
                };
            }
        }

        function zoomin(id) {
            var myImg = document.getElementById(id);
            var currWidth = myImg.clientWidth;
            if (currWidth == 2500) return false;
            else {
                myImg.style.width = (currWidth + 100) + "px";
            }
        }

        function zoomout(id) {
            var myImg = document.getElementById(id);
            var currWidth = myImg.clientWidth;
            if (currWidth == 100) return false;
            else {
                myImg.style.width = (currWidth - 100) + "px";
            }
        }

        new Chart(document.getElementById('christmas-years-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: years["christmas"]["dates"],
                datasets: [{
                    label: '2022',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    data: years["christmas"]["2022"],
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                },{
                    label: '2021',
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    data: years["christmas"]["2021"],
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    label = context.dataset.label;
                                    label += ': ';
                                    label += context.parsed.y;
                                    label += '$';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('new-year-years-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: years["new_year"]["dates"],
                datasets: [{
                    label: '2022',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    data: years["new_year"]["2022"],
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                },{
                    label: '2021',
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    data: years["new_year"]["2021"],
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    label = context.dataset.label;
                                    label += ': ';
                                    label += context.parsed.y;
                                    label += '$';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('christmas-2022-sales-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["christmas"]["2022"]["sales"]["labels"],
                datasets: [{
                    label: 'Adultos',
                    data: sales["christmas"]["2022"]["sales"]["adults"],
                    backgroundColor: 'rgba(200, 21, 21, 0.5)',
                    borderColor: 'rgba(200, 21, 21, 1)',
                    order: 1
                    },{
                    label: 'Niños',
                    data: sales["christmas"]["2022"]["sales"]["childrem"],
                    backgroundColor: 'rgba(27, 177, 15, 0.5)',
                    borderColor: 'rgba(27, 177, 15, 1)',
                    order: 1
                    },{
                    label: 'Venta',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    data: sales["christmas"]["2022"]["sales"]["data"],
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    if (context.dataset.label === 'Venta') {
                                        label = context.dataset.label;
                                        label += ': ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        label = context.dataset.label;
                                        label += ': ';
                                        if (context.parsed.y === null) {
                                            label += 0;
                                        }else{
                                            label += context.parsed.y;
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('christmas-2021-sales-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["christmas"]["2021"]["sales"]["labels"],
                datasets: [{
                    label: 'Adultos',
                    data: sales["christmas"]["2021"]["sales"]["adults"],
                    backgroundColor: 'rgba(200, 21, 21, 0.5)',
                    borderColor: 'rgba(200, 21, 21, 1)',
                    order: 1
                    },{
                    label: 'Niños',
                    data: sales["christmas"]["2021"]["sales"]["childrem"],
                    backgroundColor: 'rgba(27, 177, 15, 0.5)',
                    borderColor: 'rgba(27, 177, 15, 1)',
                    order: 1
                    },{
                    label: 'Venta',
                    backgroundColor: 'rgba(52, 58, 64, 0.5)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    data: sales["christmas"]["2021"]["sales"]["data"],
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    if (context.dataset.label === 'Venta') {
                                        label = context.dataset.label;
                                        label += ': ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        label = context.dataset.label;
                                        label += ': ';
                                        if (context.parsed.y === null) {
                                            label += 0;
                                        }else{
                                            label += context.parsed.y;
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('new-year-2022-sales-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["new_year"]["2022"]["sales"]["labels"],
                datasets: [{
                    label: 'Adultos',
                    data: sales["new_year"]["2022"]["sales"]["adults"],
                    backgroundColor: 'rgba(52, 58, 64, 0.5)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    order: 1
                    },{
                    label: 'Niños',
                    data: sales["new_year"]["2022"]["sales"]["childrem"],
                    backgroundColor: 'rgba(202, 158, 22, 0.5)',
                    borderColor: 'rgba(202, 158, 22, 1)',
                    order: 1
                    },{
                    label: 'Venta',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    data: sales["new_year"]["2022"]["sales"]["data"],
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    if (context.dataset.label === 'Venta') {
                                        label = context.dataset.label;
                                        label += ': ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        label = context.dataset.label;
                                        label += ': ';
                                        if (context.parsed.y === null) {
                                            label += 0;
                                        }else{
                                            label += context.parsed.y;
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('new-year-2021-sales-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["new_year"]["2021"]["sales"]["labels"],
                datasets: [{
                    label: 'Adultos',
                    data: sales["new_year"]["2021"]["sales"]["adults"],
                    backgroundColor: 'rgba(52, 58, 64, 0.5)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    order: 1
                    },{
                    label: 'Niños',
                    data: sales["new_year"]["2021"]["sales"]["childrem"],
                    backgroundColor: 'rgba(202, 158, 22, 0.5)',
                    borderColor: 'rgba(202, 158, 22, 1)',
                    order: 1
                    },{
                    label: 'Venta',
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    data: sales["new_year"]["2021"]["sales"]["data"],
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    if (context.dataset.label === 'Venta') {
                                        label = context.dataset.label;
                                        label += ': ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        label = context.dataset.label;
                                        label += ': ';
                                        if (context.parsed.y === null) {
                                            label += 0;
                                        }else{
                                            label += context.parsed.y;
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('christmas-2022-earnings-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: point["christmas"]["2022"]["date"],
                datasets: [{
                    label: 'Ventas',
                    data: point["christmas"]["2022"]["data"],
                    backgroundColor: 'rgba(17, 182, 212, 0.5)',
                    borderColor : 'rgba(17, 182, 212, 1)',
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                },{
                    label: 'Punto',
                    data: point["christmas"]["2022"]["meta"],
                    order: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    console.log(context.dataset.label);
                                    if (context.dataset.label === 'Ventas'){
                                        label = 'Ventas: ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        if (context.parsed.y < 0 ) {
                                            label = 'Perdidas: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }else{
                                            label = 'Ganancias: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                elements: {
                    bar: {
                        backgroundColor: colorize(true),
                        borderColor: colorize(false),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('christmas-2021-earnings-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: point["christmas"]["2021"]["date"],
                datasets: [{
                    label: 'Ventas',
                    data: point["christmas"]["2021"]["data"],
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor : 'rgba(0, 123, 255, 1)',
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                },{
                    label: 'Punto',
                    data: point["christmas"]["2021"]["meta"],
                    order: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    console.log(context.dataset.label);
                                    if (context.dataset.label === 'Ventas'){
                                        label = 'Ventas: ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        if (context.parsed.y < 0 ) {
                                            label = 'Perdidas: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }else{
                                            label = 'Ganancias: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                elements: {
                    bar: {
                        backgroundColor: colorize(true),
                        borderColor: colorize(false),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('new-year-2022-earnings-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: point["new_year"]["2022"]["date"],
                datasets: [{
                    label: 'Ventas',
                    data: point["new_year"]["2022"]["data"],
                    backgroundColor: 'rgba(17, 182, 212, 0.5)',
                    borderColor : 'rgba(17, 182, 212, 1)',
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                },{
                    label: 'Punto',
                    data: point["new_year"]["2022"]["meta"],
                    order: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    console.log(context.dataset.label);
                                    if (context.dataset.label === 'Ventas'){
                                        label = 'Ventas: ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        if (context.parsed.y < 0 ) {
                                            label = 'Perdidas: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }else{
                                            label = 'Ganancias: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                elements: {
                    bar: {
                        backgroundColor: colorize(true),
                        borderColor: colorize(false),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('new-year-2021-earnings-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: point["new_year"]["2021"]["date"],
                datasets: [{
                    label: 'Ventas',
                    data: point["new_year"]["2021"]["data"],
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor : 'rgba(0, 123, 255, 1)',
                    type: 'line',
                    order: 0,
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true
                },
                {
                    label: 'Punto',
                    data: point["new_year"]["2021"]["meta"],
                    order: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    console.log(context.dataset.label);
                                    if (context.dataset.label === 'Ventas'){
                                        label = 'Ventas: ';
                                        label += context.parsed.y;
                                        label += '$';
                                    }else{
                                        if (context.parsed.y < 0 ) {
                                            label = 'Perdidas: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }else{
                                            label = 'Ganancias: ';
                                            label += financial(context.parsed.y);
                                            label += '$';
                                        }
                                    }
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                elements: {
                    bar: {
                        backgroundColor: colorize(true),
                        borderColor: colorize(false),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('prices-christmas-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["christmas"]["2022"]["prices"]["price"],
                datasets: [{
                    label: '',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.75)',
                        'rgba(54, 162, 235, 0.75)',
                        'rgba(255, 206, 86, 0.75)',
                        'rgba(75, 192, 192, 0.75)',
                        'rgba(153, 102, 255, 0.75)',
                        'rgba(255, 159, 64, 0.75)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: sales["christmas"]["2022"]["prices"]["count"],
                }]
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        display: false
                    },
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('prices-new-year-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["new_year"]["2022"]["prices"]["price"],
                datasets: [{
                    label: '',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.75)',
                        'rgba(54, 162, 235, 0.75)',
                        'rgba(255, 206, 86, 0.75)',
                        'rgba(75, 192, 192, 0.75)',
                        'rgba(153, 102, 255, 0.75)',
                        'rgba(255, 159, 64, 0.75)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: sales["new_year"]["2022"]["prices"]["count"],
                }]
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        display: false
                    },
                },
                scales: grill,
            }
        })

        new Chart(document.getElementById('quantity-christmas-chart-canvas').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['2022', '2021'],
                datasets: [{
                    label: 'Vendidas',
                    backgroundColor: ['rgba(200, 21, 21, 0.75)', 'rgba(27, 177, 15, 0.75)'],
                    borderColor: ['rgba(200, 21, 21, 1)', 'rgba(27, 177, 15, 1)'],
                    data: [sales["christmas"]["2022"]["quantity"], sales["christmas"]["2021"]["quantity"]],
                }]
            },
            options: {
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                }
            }
        });

        new Chart(document.getElementById('quantity-new-year-chart-canvas').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['2022', '2021'],
                datasets: [{
                    label: 'Vendidas',
                    backgroundColor: ['rgba(52, 58, 64, 0.75)', 'rgba(202, 158, 22, 0.75)'],
                    borderColor: ['rgba(52, 58, 64, 1)', 'rgba(202, 158, 22, 1)'],
                    data: [sales["new_year"]["2022"]["quantity"], sales["new_year"]["2021"]["quantity"]],
                }]
            },
            options: {
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                }
            }
        });

        var peopleChristmasChart = new Chart(document.getElementById('people-christmas-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['2022', '2021'],
                datasets: [{
                    label: 'Adultos',
                    backgroundColor: 'rgba(200, 21, 21, 0.75)',
                    borderColor: 'rgba(200, 21, 21, 1)',
                    data: [sales["christmas"]["2022"]["adults"], sales["christmas"]["2021"]["adults"]]
                },{
                    label: 'Niños',
                    backgroundColor: 'rgba(27, 177, 15, 0.75)',
                    borderColor: 'rgba(27, 177, 15, 1)',
                    data: [sales["christmas"]["2022"]["childrem"], sales["christmas"]["2021"]["childrem"]]
                }]
            },
            options: {
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                scales: grill,
            }
        })

        var peopleNewYearChart = new Chart(document.getElementById('people-new-year-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['2022', '2021'],
                datasets: [{
                    label: 'Adultos',
                    backgroundColor: 'rgba(52, 58, 64, 0.75)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    data: [sales["new_year"]["2022"]["adults"], sales["new_year"]["2021"]["adults"]]
                },{
                    label: 'Niños',
                    backgroundColor: 'rgba(202, 158, 22, 0.75)',
                    borderColor: 'rgba(202, 158, 22, 1)',
                    data: [sales["new_year"]["2022"]["childrem"], sales["new_year"]["2021"]["childrem"]]
                }]
            },
            options: {
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                scales: grill,
            }
        })

    </script>
@stop