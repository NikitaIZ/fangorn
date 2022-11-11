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

    </style>
@stop

@section('content')

    <div class="row py-2">
        <div class="col-lg-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 style="font-size: 1.75rem;">{{ number_format($total[0], 0, ',', '.') }}$</h3>
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
                    <h3 style="font-size: 1.75rem;">{{ number_format($total[1], 0, ',', '.') }}$</h3>
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
                    <h3 style="font-size: 1.75rem;">{{ number_format($total[2], 0, ',', '.') }}$</h3>
                    <p style="font-size: 1.25rem;">Año Nuevo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wine-bottle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Actividad
                    </h5>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link mr-2" style="padding: 0.25rem 0.75em" id="christmas-sales-tab" data-bs-toggle="tab" data-bs-target="#christmas-sales" type="button" role="tab" aria-controls="christmas-sales" aria-selected="true">Navidad</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link mr-2 active" style="padding: 0.25rem 0.75em" id="new-year-sales-tab" data-bs-toggle="tab" data-bs-target="#new-year-sales" type="button" role="tab" aria-controls="new-year-sales" aria-selected="true">Año Nuevo</button>
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
                    <div class="tab-content p-0">
                        <div class="chart tab-pane" id="christmas-sales">
                            <div class="row">
                                <div class="col-md-8 pb-4">
                                    <p class="text-center">
                                        <strong>Cena Navideña</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="christmas-sales-chart-canvas" height="200" style="height: 200px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Ocupación</strong>
                                    </p>
                                    @foreach ($data["christmas"]["groups"] as $dato)
                                    <div class="progress-group">
                                        <span class="progress-text">Zona {{ $dato["area"] }} ({{ number_format($dato["count"]/$dato["volume"]*100, 0) }}%)</span>
                                        <span class="float-right"><b>{{ $dato["count"] }}</b>/{{ $dato["volume"] }}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" style="width: {{ number_format($dato["count"]/$dato["volume"]*100, 0) }}%"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="text-center pt-2">
                                        <a href="{{ route('reserves.dinners.christmas') }}" class="btn btn-sm btn-info">
                                            Ver Detalles
                                        </a>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#christmastModal">
                                            Ver Plano
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="christmastModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="christmastModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="christmastModalLabel">Plano Cena Navideña</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <div class="chart tab-pane active" id="new-year-sales">
                            <div class="row">
                                <div class="col-md-8 pb-4">
                                    <p class="text-center">
                                        <strong>Cena de Año Nuevo</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="new-year-sales-chart-canvas" height="200" style="height: 200px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Ocupación</strong>
                                    </p>
                                    @foreach ($data["new_year"]["groups"] as $dato)
                                        <div class="progress-group">
                                            <span class="progress-text">Zona {{ $dato["area"] }} ({{ number_format($dato["count"]/$dato["volume"]*100, 0) }}%)</span>
                                            <span class="float-right"><b>{{ $dato["count"] }}</b>/{{ $dato["volume"] }}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-primary" style="width: {{ number_format($dato["count"]/$dato["volume"]*100, 0) }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-center pt-2">
                                        <a href="{{ route('reserves.dinners.newYear') }}" class="btn btn-sm btn-info">
                                            Ver Detalles
                                        </a>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#NewYearModal">
                                            Ver Plano
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="NewYearModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="NewYearModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="NewYearModalLabel">Plano Cena de Año Nuevo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="main dragscroll text-center">
                                            <img id="NewYearImg" src="/img/planes/plano_año_nuevo_ocupacion.png" alt="Cena Año Nuevo">
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
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Ganancias
                    </h5>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <button class="nav-link nav-sm" style="padding: 0.25rem 0.75em" id="#christmas-earnings" data-bs-toggle="tab" data-bs-target="#christmas-earnings" type="button" role="tab">Navidad</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link mr-2 active" style="padding: 0.25rem 0.75em" id="#new-year-earnings" data-bs-toggle="tab" data-bs-target="#new-year-earnings" type="button" role="tab">Año Nuevo</button>
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
                    <div class="tab-content p-0">
                        <div class="chart tab-pane" id="christmas-earnings">
                            <div class="row">
                                <div class="col-md-10 pb-4">
                                    <p class="text-center">
                                        <strong>Cena Navideña</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="christmas-earnings-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="text-center">
                                        <strong>Información</strong>
                                    </p>
                                    <div class="info-box mb-3 bg-primary">
                                        <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Costo Fijo</span>
                                            <span class="info-box-number">{{ number_format($point["christmas"]["initial"], 2, ',', '.') }}$</span>
                                        </div>
                                    </div>
                                    @if (end($point["christmas"]["meta"]) <= 0)
                                        <div class="info-box mb-3 bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-level-down-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Perdidas</span>
                                                <span class="info-box-number">{{ number_format(end($point["christmas"]["meta"]), 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Porcentaje</span>
                                                <span class="info-box-number">{{ number_format(end($point["christmas"]["perc"]), 2, ',', '.') }}%</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fas fa-level-up-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Ganancias</span>
                                                <span class="info-box-number">{{ number_format(end($point["christmas"]["meta"]), 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Porcentaje</span>
                                                <span class="info-box-number">{{ number_format(end($point["christmas"]["perc"]), 2, ',', '.') }}%</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="chart tab-pane active" id="new-year-earnings">
                            <div class="row">
                                <div class="col-md-10 pb-4">
                                    <p class="text-center">
                                        <strong>Cena de Año Nuevo</strong>
                                    </p>
                                    <div class="chart">
                                        <canvas id="new-year-earnings-chart-canvas" height="300" style="height: 300px; display: block; width: 837px;" width="837" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="text-center">
                                        <strong>Información</strong>
                                    </p>
                                    <div class="info-box mb-3 bg-primary">
                                        <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Costo Fijo</span>
                                            <span class="info-box-number">{{ number_format($point["new_year"]["initial"], 2, ',', '.') }}$</span>
                                        </div>
                                    </div>
                                    @if (end($point["new_year"]["meta"]) <= 0)
                                        <div class="info-box mb-3 bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-level-down-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Perdidas</span>
                                                <span class="info-box-number">{{ number_format(end($point["new_year"]["meta"]), 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Porcentaje</span>
                                                <span class="info-box-number">{{ number_format(end($point["new_year"]["perc"]), 2, ',', '.') }}%</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fas fa-level-up-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Ganancias</span>
                                                <span class="info-box-number">{{ number_format(end($point["new_year"]["meta"]), 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Porcentaje</span>
                                                <span class="info-box-number">{{ number_format(end($point["new_year"]["perc"]), 2, ',', '.') }}%</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
                                <button class="nav-link nav-sm" id="#price-christmas" style="padding: 0.25rem 0.75em" data-bs-toggle="tab" data-bs-target="#price-christmas">Navidad</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link mr-2 active" id="#price-new-year" style="padding: 0.25rem 0.75em" data-bs-toggle="tab" data-bs-target="#price-new-year">Año Nuevo</a>
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
                    <div class="tab-content p-0">
                        <div class="chart tab-pane" id="price-christmas" style="position: relative; ">
                            <canvas id="prices-christmas-chart-canvas" width="300" height="300" class="chartjs-render-monitor"></canvas>
                        </div>
                        <div class="chart tab-pane active" id="price-new-year" style="position: relative;">
                            <canvas id="prices-new-year-chart-canvas" width="300" height="300" class="chartjs-render-monitor"></canvas>
                        </div>
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
                    <div class="tab-content p-0">
                        <canvas id="quantity-chart-canvas" width="250" height="250" style="display: block;" class="chartjs-render-monitor"></canvas>
                    </div>
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
                                <button class="nav-link nav-sm" id="#people-christmas" style="padding: 0.25rem 0.75em" data-bs-toggle="tab" data-bs-target="#people-christmas">Navidad</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link mr-2 active" id="#people-new-year" style="padding: 0.25rem 0.75em" data-bs-toggle="tab" data-bs-target="#people-new-year">Año Nuevo</button>
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
                    <div class="tab-content p-0">
                        <div class="chart tab-pane" id="people-christmas" style="position: relative; ">
                            <canvas id="people-christmas-chart-canvas" width="300" height="300"  class="chartjs-render-monitor"></canvas>
                        </div>
                        <div class="chart tab-pane active" id="people-new-year" style="position: relative;">
                            <canvas id="people-new-year-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        var christmasEarningsChart = new Chart(document.getElementById('christmas-earnings-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: point["christmas"]["date"],
                datasets: [{
                    label: 'Ventas',
                    data: point["christmas"]["data"],
                    backgroundColor: 'rgba(17, 182, 212, 0.5)',
                    borderColor : 'rgba(17, 182, 212, 1)',
                    type: 'line',
                    order: 0
                },
                {
                    label: '',
                    data: point["christmas"]["meta"],
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
                legend: {
                    display: false
                }
            }
        })

        var newYearEarningsChart = new Chart(document.getElementById('new-year-earnings-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: point["new_year"]["date"],
                datasets: [{
                    label: 'Ventas',
                    data: point["new_year"]["data"],
                    backgroundColor: 'rgba(17, 182, 212, 0.5)',
                    borderColor : 'rgba(17, 182, 212, 1)',
                    type: 'line',
                    order: 0
                },
                {
                    label: '',
                    data: point["new_year"]["meta"],
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
                legend: {
                    display: false
                }
            }
        })

        var christmasSalesChart = new Chart(document.getElementById('christmas-sales-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["christmas"]["sales"]["labels"],
                datasets: [{
                    label: 'Adultos',
                    data: sales["christmas"]["sales"]["adults"],
                    backgroundColor: 'rgba(200, 21, 21, 0.5)',
                    borderColor: 'rgba(200, 21, 21, 1)',
                    order: 1
                    },{
                    label: 'Niños',
                    data: sales["christmas"]["sales"]["childrem"],
                    backgroundColor: 'rgba(27, 177, 15, 0.5)',
                    borderColor: 'rgba(27, 177, 15, 1)',
                    order: 1
                    },{
                    label: 'Venta',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    data: sales["christmas"]["sales"]["data"],
                    type: 'line',
                    order: 0
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
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        })

        var newYearSalesChart = new Chart(document.getElementById('new-year-sales-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: sales["new_year"]["sales"]["labels"],
                datasets: [{
                    label: 'Adultos',
                    data: sales["new_year"]["sales"]["adults"],
                    backgroundColor: 'rgba(52, 58, 64, 0.5)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    order: 1
                    },{
                    label: 'Niños',
                    data: sales["new_year"]["sales"]["childrem"],
                    backgroundColor: 'rgba(202, 158, 22, 0.5)',
                    borderColor: 'rgba(202, 158, 22, 1)',
                    order: 1
                    },{
                    label: 'Venta',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    data: sales["new_year"]["sales"]["data"],
                    type: 'line',
                    order: 0
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
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        })

        var quantityPieChart = new Chart(document.getElementById('quantity-chart-canvas').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Navidad', 'Año Nuevo'],
                datasets: [{
                    label: 'Vendidas',
                    backgroundColor: ['rgba(200, 21, 21, 1)', 'rgba(52, 58, 64, 1)'],
                    borderColor: ['rgba(255, 255, 255, 1)', 'rgba(255, 255, 255, 1)'],
                    data: [sales["christmas"]["quantity"], sales["new_year"]["quantity"]]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Pie Chart'
                    }
                },
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                }
            }
        })

        var peopleChristmasChart = new Chart(document.getElementById('people-christmas-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Adultos',
                    backgroundColor: 'rgba(200, 21, 21, 0.6)',
                    borderColor: 'rgba(200, 21, 21, 1)',
                    data: [sales["christmas"]["adults"]]
                },{
                    label: 'Niños',
                    backgroundColor: 'rgba(27, 177, 15, 0.6)',
                    borderColor: 'rgba(27, 177, 15, 1)',
                    data: [sales["christmas"]["childrem"]]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Pie Chart'
                    }
                },
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                }
            }
        })

        var peopleNewYearChart = new Chart(document.getElementById('people-new-year-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Adultos',
                    backgroundColor: 'rgba(52, 58, 64, 0.6)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    data: [sales["new_year"]["adults"]]
                },{
                    label: 'Niños',
                    backgroundColor: 'rgba(202, 158, 22, 0.6)',
                    borderColor: 'rgba(202, 158, 22, 1)',
                    data: [sales["new_year"]["childrem"]]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Pie Chart'
                    }
                },
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                }
            }
        })

        var pricesChristmasChart = new Chart(document.getElementById('prices-christmas-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ["180$", "150$", "100$", "60$", "40$"],
                datasets: [{
                    label: '',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: sales["christmas"]["prices"],
                }]
            },
            options: {
                indexAxis: 'y',
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Pie Chart'
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var pricesNewYearChart = new Chart(document.getElementById('prices-new-year-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ["250$", "200$", "150$", "100$", "75$"],
                datasets: [{
                    label: '',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    data: [
                        sales["new_year"]["prices"]["250"],
                        sales["new_year"]["prices"]["200"],
                        sales["new_year"]["prices"]["150"],
                        sales["new_year"]["prices"]["100"],
                        sales["new_year"]["prices"]["75"]]
                }]
            },
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Pie Chart'
                    }
                }
            }
        })
    </script>
@stop