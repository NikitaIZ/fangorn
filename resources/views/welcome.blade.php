@extends('adminlte::page')
@section('title', 'Test')

@section('css')
<style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #0c437d;
        background-color: #ffffff;
    }
    .nav-pills .nav-link:not(.active):hover {
        color: #ffffff;
    }

    .nav-pills .nav-link {
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

@section('content')
<div class="row py-2">
    <section class="col-md-12">
        <div class="card">
            <div class="card-header" style="background-color: #0c437d!important; color: white;">
                <h3 class="card-title">
                    <i class="fa-solid fa-cloud-sun"></i>
                    Pronostico
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-sm active" href="#forecast-graf-1" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#forecast-graf-2" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#forecast-graf-3" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#forecast-graf-4" style="padding: 0.25rem 0.75em" data-bs-toggle="tab">4</a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn bg-white btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="forecast-graf-1">
                        <div class="row">
                            <div class="col-md-8 pb-4" style="min-height: 400px;">
                                <canvas id="forecast-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <strong>Subtotal Historico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(60, 141, 188); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["history"]["ADR"], 2, ',', '.') }}$</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(47, 195, 38); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["history"]["RVP"], 2, ',', '.') }}$</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Subtotal Pronostico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(60, 141, 188, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["forecast"]["ADR"], 2, ',', '.') }}$</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(47, 195, 38, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["forecast"]["RVP"], 2, ',', '.') }}$</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Total</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(60, 141, 188); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-scale-balanced"></i></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["ADR"], 2, ',', '.') }}$</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(47, 195, 38); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-money-bill-wave-alt"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["RVP"], 2, ',', '.') }}$</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="forecast-graf-2">
                        <div class="row">
                            <div class="col-md-8 pb-4" style="min-height: 400px;">
                                <canvas id="forecast-2-chart-canvas" width="400" height="400" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <strong>Subtotal Historico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(36, 106, 176); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["NRS"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(208, 130, 24); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["NPS"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(149, 82, 189); color:white">
                                                    <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["history"]["OCC"], 2, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Subtotal Pronostico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(82, 127, 172); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["NRS"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(227, 175, 106); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["NPS"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(149, 82, 189, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["forecast"]["OCC"], 2, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Total</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(36, 106, 176); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-door-closed"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["NRS"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(208, 130, 24); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-male"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["NPS"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(149, 82, 189); color:white">
                                                    <span class="info-box-icon"><i class="fa-solid fa-percent"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ number_format($array["total"]["OCC"], 2, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="forecast-graf-3">
                        <div class="row">
                            <div class="col-md-8 pb-4" style="min-height: 400px;">
                                <canvas id="forecast-3-chart-canvas" width="400" height="400" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <strong>Subtotal Historico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(0, 172, 172); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-house-user"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["HOU"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(111, 191, 70); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-hotel"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["COM"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(238, 28, 37); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-exclamation-triangle"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["NSR"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Subtotal Pronostico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(0, 172, 172, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-house-user"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["HOU"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(111, 191, 70, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-hotel"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["COM"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(238, 28, 37, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-exclamation-triangle"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["NSR"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Total</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(0, 172, 172); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-house-user"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["HOU"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(111, 191, 70); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-hotel"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["COM"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 col-sm-4">
                                                <div class="info-box mb-3" style="background-color: rgb(238, 28, 37); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-exclamation-triangle"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["NSR"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="forecast-graf-4">
                        <div class="row">
                            <div class="col-md-8 pb-4" style="min-height: 400px;">
                                <canvas id="forecast-4-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <strong>Subtotal Historico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(27, 188, 155); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-plane-arrival"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["ARR"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(45, 62, 80); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["history"]["DEP"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Subtotal Pronostico</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(27, 188, 155, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-plane-arrival"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["ARR"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(45, 62, 80, 0.75); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["forecast"]["DEP"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">
                                            <strong>Total</strong>
                                        </p>
                                        <div class="row">
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(27, 188, 155); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-plane-arrival"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["ARR"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                <div class="info-box mb-3" style="background-color: rgb(45, 62, 80); color:white">
                                                    <span class="info-box-icon"><i class="fas fa-solid fa-plane-departure"></i></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-number">{{ $array["total"]["DEP"] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    const array = {!! json_encode($array) !!};

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

    const title = {
        text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
        labels: {
            color: 'black',
            font: {
                weight: 'bold',
            },
        }
    };

    const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
    const down = (ctx, value) => ctx.p0.parsed.x >= array["total"]["history"]["DYS"]-1 ? value : undefined;

    function financial(x) {
        return Number.parseFloat(x).toFixed(2);
    }

    function orden(label, x, y) {
        switch (label) {
            case "Nº Habitaciones":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico Hab: ';
                    label += y;
                }else{
                    label = 'Pronostico Hab: ';
                    label += y;
                }
            break;
            case "Nº Personas":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico Prs: ';
                    label += y;
                }else{
                    label = 'Pronostico Prs: ';
                    label += y;
                }
            break;
            case "% Ocupacion":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico Occ: ';
                    label += financial(y);
                    label += '%';
                }else{
                    label = 'Pronostico Occ: ';
                    label += financial(y);
                    label += '%';
                }
            break;
            case "Complimentary":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico COMP: ';
                    label += y;
                }else{
                    label = 'Pronostico COMP: ';
                    label += y;
                }
            break;
            case "House Use":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico HU: ';
                    label += y;
                }else{
                    label = 'Pronostico HU: ';
                    label += y;
                }
            break;
            case "Out of Order":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico OOO: ';
                    label += y;
                }else{
                    label = 'Pronostico OOO: ';
                    label += y;
                }
            break;
            case "RevPAR":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico RevPAR: ';
                    label += financial(y);
                    label += '$';
                }else{
                    label = 'Pronostico RevPAR: ';
                    label += financial(y);
                    label += '$';
                }
            break;
            case "ADR":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico ADR: ';
                    label += financial(y);
                    label += '$';
                }else{
                    label = 'Pronostico ADR: ';
                    label += financial(y);
                    label += '$';
                }
            break;
            case "Arrival":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico ARR: ';
                    label += y;
                }else{
                    label = 'Pronostico ARR: ';
                    label += y;
                }
            break;
            case "Departure":
                if (x <= array["total"]["history"]["DYS"]-1){
                    label = 'Historico DEP: ';
                    label += y;
                }else{
                    label = 'Pronostico DEP: ';
                    label += y;
                }
            break;
        }
        return label;
    }

    var forecastChart1 = new Chart(document.getElementById('forecast-1-chart-canvas').getContext('2d'), {
        type: 'line',
        data: {
            labels: array["dates"],
            datasets: [{
                label: 'ADR',
                data: array["line"]["ADR"]["data"],
                borderColor: array["line"]["ADR"]["bord"],
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(108, 182, 225, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            },{
                label: 'RevPAR',
                data: array["line"]["RVP"]["data"],
                borderColor: array["line"]["RVP"]["bord"],
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(105, 206, 99, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }]
        },
        options: {
            radius: 0,
            maintainAspectRatio: false,
            plugins: {
                legend: title,
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            label = orden(context.dataset.label, context.parsed.x, context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: grill
        }
    })

    var forecastChart2 = new Chart(document.getElementById('forecast-2-chart-canvas').getContext('2d'), {
        type: 'bar',
        data: {
            labels: array["dates"],
            datasets: [{
                label: '% Ocupacion',
                data: array["bar"]["OCC"]["data"],
                backgroundColor: array["bar"]["OCC"]["back"],
                borderColor: array["bar"]["OCC"]["bord"],
                borderWidth: 3,
                order: 1,
            },{
                label: 'Nº Habitaciones',
                data: array["line"]["NRS"]["data"],
                borderColor: array["line"]["NRS"]["bord"],
                type: 'line',
                order: 0,
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(36, 106, 176, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                spanGaps: true
            },{
                label: 'Nº Personas',
                data: array["line"]["NPS"]["data"],
                borderColor: array["line"]["NPS"]["bord"],
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(208, 130, 24, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                spanGaps: true,
                type: 'line',
                order: 0,
            }]
        },
        options: {
            radius: 0,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context){
                            label = orden(context.dataset.label, context.parsed.x, context.parsed.y);
                            return label;
                        }
                    }
                }
            }
        }
    })

    var forecastChart3 = new Chart(document.getElementById('forecast-3-chart-canvas').getContext('2d'), {
        type: 'line',
        data: {
            labels: array["dates"],
            datasets: [{
                label: 'House Use',
                data: array["line"]["HOU"]["data"],
                borderColor: array["line"]["HOU"]["bord"],
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(0, 172, 172, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                spanGaps: true
            },{
                label: 'Complimentary',
                data: array["line"]["COM"]["data"],
                borderColor: array["line"]["COM"]["bord"],
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(111, 191, 70, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                spanGaps: true
            },{
                label: 'Out of Order',
                data: array["line"]["NSR"]["data"],
                borderColor: array["line"]["NSR"]["bord"],
                tension: 0.4,
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(238, 28, 37, 0.5)'),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6]),
                },
                spanGaps: true
            },
            ]
        },
        options: {
            radius: 0,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            label = orden(context.dataset.label, context.parsed.x, context.parsed.y);
                            return label;
                        }
                    }
                }
            }
        }
    })

    var forecastChart4 = new Chart(document.getElementById('forecast-4-chart-canvas').getContext('2d'),{
        type: 'bar',
        data: {
            labels: array["dates"],
            datasets: [{
                label: 'Arrival',
                data: array["bar"]["ARR"]["data"],
                backgroundColor: array["bar"]["ARR"]["back"],
                borderColor: array["bar"]["ARR"]["bord"],
                borderWidth: 1,
            },{
                label: 'Departure',
                data: array["bar"]["DEP"]["data"],
                backgroundColor: array["bar"]["DEP"]["back"],
                borderColor: array["bar"]["DEP"]["bord"],
                borderWidth: 1,
            }]
        },
        options: {
            radius: 0,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            label = orden(context.dataset.label, context.parsed.x, context.parsed.y);
                            return label;
                        }
                    }
                }
            }
        }
    })
</script>
@stop