@extends('adminlte::page')
@section('title', 'Test')

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
        <section class="col-11">
            <h1>{{ $data["month"]["name"] }} {{ $data["today"]["PAX"] }}</h1>
        </section>
        <section class="col-1">
            <div class="dropdown float-right">
                <a class="btn btn-wyndham dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Mes
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @switch($month)
                        @case(1)
                            <li><a class="dropdown-item disabled" href="#">Septiembre</a></li>
                            <li><a class="dropdown-item" href="{{ route('test.show', ['month' => 2]) }}">Octubre</a></li>
                            <li><a class="dropdown-item" href="{{ route('test.show', ['month' => 3]) }}">Noviembre</a></li>
                        @break
                        @case(2)
                            <li><a class="dropdown-item" href="{{ route('test.show', ['month' => 1]) }}">Septiembre</a></li>
                            <li><a class="dropdown-item disabled" href="#">Octubre</a></li>
                            <li><a class="dropdown-item" href="{{ route('test.show', ['month' => 3]) }}">Noviembre</a></li>
                        @break
                        @case(3)
                            <li><a class="dropdown-item" href="{{ route('test.show', ['month' => 1]) }}">Septiembre</a></li>
                            <li><a class="dropdown-item" href="{{ route('test.show', ['month' => 2]) }}">Octubre</a></li>
                            <li><a class="dropdown-item disabled" href="#">Noviembre</a></li>
                        @break
                    @endswitch
                </ul>
            </div>
        </section>
    </div>
@stop

@section('content')
    <div class="row">
        <section class="col-lg-12">
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
                        <div class="col-md-9 pb-4">
                            <div class="chart">
                                <div style="position: relative; height:25rem; width:auto">
                                    <canvas id="forecast-money-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if ($data["month"]["history"]["DYS"] > 0)
                                <div class="row mb-3">
                                    <p class="col-12 text-center">
                                        <strong>Historico</strong>
                                    </p>
                                    <div class="col-6">
                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["history"]["ADR"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["history"]["RVP"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($data["month"]["forecast"]["DYS"] > 0)
                                <div class="row mb-3">
                                    <p class="col-12 text-center">
                                        <strong>Pronostico</strong>
                                    </p>
                                    <div class="col-6">
                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188, 0.75); color:white">
                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["forecast"]["ADR"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38, 0.75); color:white">
                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["forecast"]["RVP"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($data["month"]["history"]["DYS"] > 0 && $data["month"]["forecast"]["DYS"] > 0)
                                <div class="row mb-3">
                                    <p class="col-12 text-center">
                                        <strong>Total</strong>
                                    </p>
                                    <div class="col-6">
                                        <div class="info-box m-0" style="background-color: rgb(60, 141, 188); color:white">
                                            <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["total"]["ADR"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-box m-0" style="background-color: rgb(47, 195, 38); color:white">
                                            <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["total"]["RVP"], 2, ',', '.') }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                        @if ($agent->isDesktop())
                            <div class="col-md-3">
                                @if ($data["month"]["history"]["DYS"] > 0)
                                    <div class="row mb-3">
                                        <p class="col-12 text-center">
                                            <strong>Historico</strong>
                                        </p>
                                        <div class="col-6">
                                            <div class="info-box bg-warning m-0">
                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ $data["month"]["history"]["NRS"] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-primary m-0">
                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ number_format($data["month"]["history"]["OCC"], 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($data["month"]["forecast"]["DYS"] > 0)
                                    <div class="row mb-3">
                                        <p class="col-12 text-center">
                                            <strong>Pronostico</strong>
                                        </p>
                                        <div class="col-6">
                                            <div class="info-box bg-warning-off m-0">
                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ $data["month"]["forecast"]["NRS"] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-primary-off m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ number_format($data["month"]["forecast"]["OCC"], 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($data["month"]["history"]["DYS"] > 0 && $data["month"]["forecast"]["DYS"] > 0)
                                    <div class="row mb-3">
                                        <p class="col-12 text-center">
                                            <strong>Total</strong>
                                        </p>
                                        <div class="col-6">
                                            <div class="info-box bg-warning m-0">
                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ $data["month"]["total"]["NRS"] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-primary m-0">
                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ number_format($data["month"]["total"]["OCC"], 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="col-md-9">
                            <div class="chart">
                                <div style="position: relative; height:25rem; width:auto">
                                    <canvas id="forecast-meta-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                        @if ($agent->isMobile())
                            <div class="col-md-3">
                                @if ($data["month"]["history"]["DYS"] > 0)
                                    <div class="row mb-3">
                                        <p class="col-12 text-center">
                                            <strong>Historico</strong>
                                        </p>
                                        <div class="col-6">
                                            <div class="info-box bg-warning m-0">
                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ $data["month"]["history"]["NRS"] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-primary m-0">
                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ number_format($data["month"]["history"]["OCC"], 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($data["month"]["forecast"]["DYS"] > 0)
                                    <div class="row mb-3">
                                        <p class="col-12 text-center">
                                            <strong>Pronostico</strong>
                                        </p>
                                        <div class="col-6">
                                            <div class="info-box bg-warning-off m-0">
                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ $data["month"]["forecast"]["NRS"] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-primary-off m-0" style="background-color: rgb(0, 123, 255, 0.75); color:white">
                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ number_format($data["month"]["forecast"]["OCC"], 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($data["month"]["history"]["DYS"] > 0 && $data["month"]["forecast"]["DYS"] > 0)
                                    <div class="row mb-3">
                                        <p class="col-12 text-center">
                                            <strong>Total</strong>
                                        </p>
                                        <div class="col-6">
                                            <div class="info-box bg-warning m-0">
                                                <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ $data["month"]["total"]["NRS"] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-box bg-primary m-0">
                                                <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-number">{{ number_format($data["month"]["total"]["OCC"], 2, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
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
                        <div class="col-md-10 pb-4">
                            <div class="chart">
                                <div style="position: relative; height:25rem; width:auto">
                                    <canvas id="forecast-revroom-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            @if ($data["month"]["history"]["DYS"] > 0)
                                <div class="row mb-3">
                                    <p class="col-12 text-center">
                                        <strong>Historico</strong>
                                    </p>
                                    <div class="col-12">
                                        <div class="info-box m-0" style="background-color: rgb(246, 120, 16); color:white">
                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["history"]["RVN"], 2, ",", ".") }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($data["month"]["forecast"]["DYS"] > 0)
                                <div class="row mb-3">
                                    <p class="col-12 text-center">
                                        <strong>Pronostico</strong>
                                    </p>
                                    <div class="col-12">
                                        <div class="info-box m-0" style="background-color: rgb(246, 120, 16, 0.75); color:white">
                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{ number_format($data["month"]["forecast"]["RVN"], 2, ",", ".") }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($data["month"]["history"]["DYS"] > 0 && $data["month"]["forecast"]["DYS"] > 0)
                                <div class="row mb-3">
                                    <p class="col-12 text-center">
                                        <strong>Total</strong>
                                    </p>
                                    <div class="col-12">
                                        <div class="info-box m-0" style="background-color: rgb(246, 120, 16); color:white">
                                            <span class="info-box-icon"><i class="fas fa-solid fa-pen-clip"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number">{{number_format($data["month"]["total"]["RVN"], 2, ",", ".") }}$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
    
    <script type="text/javascript" src="//d3js.org/d3.v4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script type="text/javascript" src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>

    <script>
        var report = {!! json_encode($data) !!};

        var days = report["month"]["history"]["DYS"] - 1;

        const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
        const down    = (ctx, value) => ctx.p0.parsed.x >= days ? value : undefined;

        const title = {
            text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
            labels: {
                color: 'black',
                font: {
                    weight: 'bold',
                    family: 'Montserrat'
                },
            }
        };

        function orden_forecast(label, x, y) {
            switch (label) {
                case "Nº Habs":
                    if (x <= days){
                        label = 'Historico Hab: ';
                        label += y;
                    }else{
                        label = 'Pronostico Hab: ';
                        label += y;
                    }
                break;
                case "Nº Pax":
                    if (x <= days){
                        label = 'Historico Prs: ';
                        label += y;
                    }else{
                        label = 'Pronostico Prs: ';
                        label += y;
                    }
                break;
                case "% Ocupacion":
                    if (x <= days){
                        label = 'Historico Occ: ';
                        label += financial(y);
                        label += '%';
                    }else{
                        label = 'Pronostico Occ: ';
                        label += financial(y);
                        label += '%';
                    }
                break;
                case "RevPAR":
                    if (x <= days){
                        label = 'Historico RevPAR: ';
                        label += financial(y);
                        label += '$';
                    }else{
                        label = 'Pronostico RevPAR: ';
                        label += financial(y);
                        label += '$';
                    }
                break;
                case "Room Revenue":
                    if (x <= days){
                        label = 'Historico Room Revenue: ';
                        label += financial(y);
                        label += '$';
                    }else{
                        label = 'Pronostico RevPAR: ';
                        label += financial(y);
                        label += '$';
                    }
                break;
                case "ADR":
                    if (x <= days){
                        label = 'Historico ADR: ';
                        label += financial(y);
                        label += '$';
                    }else{
                        label = 'Pronostico ADR: ';
                        label += financial(y);
                        label += '$';
                    }
                break;
            }
            return label;
        }

        function financial(x) {
            return x.toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function colorize(opaque) {
            if (opaque === true){
                return (ctx) => {
                    const v = ctx.parsed.y;
                    const h = ctx.parsed.x;
                    const c = v < -50 ? 'rgba(214, 0, 0, 0.5)'
                    : v < 20 && h < days+1 ? 'rgba(214, 0, 0, 0.5)'
                    : v < 20 && h > days ? 'rgba(214, 0, 0, 0.5)'
                    : v < 50 && h < days+1 ? 'rgba(68, 222, 40, 0.5)'
                    : v < 50 && h > days ? 'rgba(68, 222, 40, 0.5)'
                    : 'rgba(68, 222, 40, 0.5)';
                    return c;
                };
            }else{
                return (ctx) => {
                    const v = ctx.parsed.y;
                    const h = ctx.parsed.x;
                    const c = v < -50 ? 'rgba(214, 0, 0, 1)'
                    : v < 20 && h < days+1 ? 'rgba(214, 0, 0, 1)'
                    : v < 20 && h > days ? 'rgba(214, 0, 0, 0.75)'
                    : v < 50 && h < days+1 ? 'rgba(68, 222, 40, 1)'
                    : v < 50 && h > days ? 'rgba(68, 222, 40, 0.75)'
                    : 'rgba(68, 222, 40, 1)';
                    return c;
                };
            }
        }

        var averageChart = new Chart(document.getElementById('forecast-meta-1-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: report["month"]["dates"],
                datasets: [{
                    label: 'Nº Habs',
                    data: report["month"]["NRS"],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)'),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                    type: 'line',
                    order: 0,
                },{
                    label: '% Ocupacion',
                    data: report["month"]["OCC"],
                    backgroundColor: report["month"]["BOCC"],
                    borderColor: report["month"]["LOCC"],
                    borderWidth: 1,
                    order: 1,
                },{
                    label: '% Promedio',
                    data: report["month"]["OCP"],
                    borderWidth: 1,
                    order: 1
                },]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: title,
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.x !== null) {
                                    if (context.dataset.label == '% Promedio') {
                                        if (context.parsed.y < 20 ) {
                                            label = 'Perdidas: ';
                                            label += financial(context.parsed.y);
                                            label += '%';
                                        }else{
                                            label = 'Ganancias: ';
                                            label += financial(context.parsed.y);
                                            label += '%';
                                        }
                                    }else{
                                        label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y);
                                    }
                                    console.log(context.dataset.label);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
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
                    },
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
                }
            }
        })

        var moneyChart = new Chart(document.getElementById('forecast-money-1-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"]["dates"],
                datasets: [
                {
                    label: 'ADR',
                    data: report["month"]["ADR"],
                    borderColor: 'rgba(60, 141, 188, 1)',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(60, 141, 188, 0.5)'),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'RevPAR',
                    data: report["month"]["RVP"],
                    borderColor: 'rgba(47, 195, 38, 1)',
                    backgroundColor: 'rgba(47, 195, 38, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 195, 38, 0.5)'),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: title,
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
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
                    },
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
                }
            }
        })

        var moneyChart = new Chart(document.getElementById('forecast-revroom-1-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"]["dates"],
                datasets: [
                {
                    label: 'Room Revenue',
                    data: report["month"]["RVN"],
                    borderColor: 'rgba(246, 120, 16, 1)',
                    backgroundColor: 'rgba(246, 120, 16, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(246, 120, 16, 0.5)'),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: title,
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: {
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
                    },
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
                }
            }
        })

    </script>
@stop