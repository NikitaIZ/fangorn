@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<div class="row py-2">
    <div id="date1" class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3 style="font-size: 1.75rem;">{{ $date }}</h3>
                <p style="font-size: 1.25rem;">Fecha</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <a  onclick="show_form()" class="small-box-footer">
                Actualizar <i class="fas fa-fw fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div id="date2" class="invisible d-none">
        <div class="small-box bg-info">
            {!! Form::model('chart', ['route' => ['test1'], 'method' => 'post']) !!}
            <div class="inner p-2">
                {!! Form::date('date', null, ['class' => 'form-control mb-3']) !!}
                {!! Form::submit('Enviar', ['class' => 'form-control ']) !!}
            </div>
            {!! Form::close() !!}
            <a onclick="hidden_form()" class="small-box-footer">
                cancelar <i class="fas fa-fw fa-times"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 style="font-size: 1.75rem;">{{ $dolar }} Bs</h3>
                <p style="font-size: 1.25rem;">Tasa del Día</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            @can('dolar.index')
                <a href="{{ route('dolar.index') }}" class="small-box-footer">
                    Actualizar <i class="fas fa-fw fa-arrow-circle-right"></i>
                </a>
            @endcan
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="{{ $colors[0] }}">
            <div class="inner">
                <h3>{{ number_format($dataYear['Hab'][0]) }}</h3>
                <p style="font-size: 1.25rem;">Habitaciones Ocupadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-bed"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="{{ $colors[1] }}">
            <div class="inner">
                <h3>{{ number_format($dataYear['Pax'][0]) }}</h3>
                <p style="font-size: 1.25rem;">Total de Huespedes</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <section class="col-lg-7 connectedSortable ">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-week mr-1"></i>
                    Semana
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-sm active" href="#week-graf-1" style="padding: 0.25rem 0.75em" data-toggle="tab">1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#week-graf-2" style="padding: 0.25rem 0.75em" data-toggle="tab">2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#week-graf-3" style="padding: 0.25rem 0.75em" data-toggle="tab">3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#week-graf-4" style="padding: 0.25rem 0.75em" data-toggle="tab">4</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="week-graf-1" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="week-1-chart-canvas" width="300" height="300"  class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="chart tab-pane" id="week-graf-2" style="position: relative; height: 300px;">
                        <canvas id="week-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                    </div>
                    <div class="chart tab-pane" id="week-graf-3" style="position: relative; height: 300px;">
                        <canvas id="week-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                    </div>
                    <div class="chart tab-pane" id="week-graf-4" style="position: relative; height: 300px;">
                        <canvas id="week-4-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-area"></i>
                    Cada año
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-sm active" href="#year-graf-1" style="padding: 0.25rem 0.75em" data-toggle="tab">1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#year-graf-2" style="padding: 0.25rem 0.75em" data-toggle="tab">2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#year-graf-3" style="padding: 0.25rem 0.75em" data-toggle="tab">3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mr-2" href="#year-graf-4" style="padding: 0.25rem 0.75em" data-toggle="tab">4</a>
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
                    <div class="chart tab-pane active" id="year-graf-1" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="year-day-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="chart tab-pane" id="year-graf-2" style="position: relative; height: 300px;">
                        <canvas id="year-day-2-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                    </div>
                    <div class="chart tab-pane" id="year-graf-3" style="position: relative; height: 300px;">
                        <canvas id="year-day-3-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                    </div>
                    <div class="chart tab-pane" id="year-graf-4" style="position: relative; height: 300px;">
                        <canvas id="year-day-4-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor" ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="col-lg-5 connectedSortable ">
        <div class="card bg-gradient-info">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-percentage mr-1"></i>
                    Porcentaje de ocupación
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class="">
                        </div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class="">
                        </div>
                    </div>
                </div>
                <div class="gauge-container">
                    <div data-percentage={{ $percentage['dia'] }} class="gauge">
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="row">
                    <div class="col-4 text-center">
                        <div class="gauge-mini-container">
                            <div id="percentage-mini-1" data-percentage={{ $percentage['ayer']}} class="gauge-mini">
                            </div>
                        </div>
                        <div class="text-white">
                            Ayer
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="gauge-mini-container">
                            <div id="percentage-mini-2"  data-percentage={{ $percentage['mes'] }} class="gauge-mini">
                            </div>
                        </div>
                        <div class="text-white">
                            Mes
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="gauge-mini-container">
                            <div id="percentage-mini-3"  data-percentage={{ $percentage['año'] }} class="gauge-mini">
                            </div>
                        </div>
                        
                        <div class="text-white">
                            Año
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="row align-items-start">
    <div class="col">
        <div class="card">
            <div class="card-header border-0">
                <h4 class="card-title">
                    <i class="fas fa-clipboard-list mr-1"></i>
                    Reporte del Día
                </h4>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{ route('xmls.index') }}" class="btn btn-dark btn-sm mr-2">
                                Ver Todos
                            </a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn bg-dark btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </li>
                    </ul>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rooms Occupied (Hab) :</td>
                                <td>{{ number_format($dataYear['Hab'][0]) }}</td>
                            </tr>
                            <tr>
                                <td>Total In-House Persons (Pax) :</td>
                                <td>{{ number_format($dataYear['Pax'][0]) }}</td>
                            </tr>
                            <tr>
                                <td>Percentage of Occupied Rooms (%) :</td>
                                <td>{{ number_format($dataYear['Per']['Dia'][0], 2) }}%</td>
                            </tr>
                            <tr>
                                <td>Average Daily Rate (ADR) :</td>
                                <td id="bolivares" class="invisible d-none">{{ number_format($dataYear['ADR'][0], 2) }} Bs</td>
                                <td id="dolars">{{ number_format($dataYear['ADR'][0], 2) }}$</td>
                            </tr>
                            <tr>
                                <td>Revenue Per Available Room Day (RevPAR) :</td>
                                <td id="bolivares" class="invisible d-none">{{ number_format($dataYear['RevPAR'][0], 2) }} Bs</td>
                                <td id="dolars">{{ number_format($dataYear['RevPAR'][0], 2)  }}$</td>
                            </tr>
                            <tr>
                                <td>Departure Rooms (DEP) :</td>
                                <td>{{ number_format($dataYear['DEP'][0], 0) }}</td>
                            </tr>
                            <tr>
                                <td>Arrival Rooms (ARR) :</td>
                                <td>{{ number_format($dataYear['ARR'][0], 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('xmls.show', $dataYear['id'][0]) }}" class="btn btn-dark">
                    Ver Detalles
                </a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header text-center">
                <h4>Buffet</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Adults </th>
                                <th>Children</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buffet as $service)
                            <tr>
                                <td>{{ $service->service }}</td>
                                <td>{{ $service->adults }}$</td>
                                <td>{{ $service->children }}$</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                @can('buffet.index')
                <a href="{{ route('buffet.index') }}" class="btn btn-dark btn-sm">
                    Actualizar Buffet
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>

<svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="gradientGauge">
            <stop class="color-red" offset="0%"/>
            <stop class="color-yellow" offset="17%"/>
            <stop class="color-yellow" offset="40%"/>
            <stop class="color-green" offset="87%"/>
            <stop class="color-green" offset="100%"/>
        </linearGradient>
    </defs>  
</svg>

@stop



@section('js')
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script>
<script type="text/javascript" src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>
<script type="text/javascript" src="js/gaugechart.babel.js"></script>

<script>

    const dataWeek = {!! json_encode($dataWeek) !!};
    const dataYear = {!! json_encode($dataYear) !!};

    function show_form(){
        date1.className = "invisible d-none";
        date2.className = "col-lg-3 col-6";
    };

    function hidden_form(){     
        date1.className = "col-lg-3 col-6";
        date2.className = "invisible d-none";
    };

    function financial(x) {
        return Number.parseFloat(x).toFixed(2);
    }

    var weekChart1 = new Chart(document.getElementById('week-1-chart-canvas').getContext('2d'), {
        type: 'line',
        data: {
            labels: [
                dataWeek['date'][6],
                dataWeek['date'][5],
                dataWeek['date'][4],
                dataWeek['date'][3],
                dataWeek['date'][2],
                dataWeek['date'][1],
                dataWeek['date'][0]
            ],
            datasets: [{
                label: 'ADR',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                data: [
                    dataWeek['ADR'][6],
                    dataWeek['ADR'][5],
                    dataWeek['ADR'][4],
                    dataWeek['ADR'][3],
                    dataWeek['ADR'][2],
                    dataWeek['ADR'][1],
                    dataWeek['ADR'][0]
                ]
            },
            {
                label: 'RevPAR',
                backgroundColor: 'rgba(75, 192, 192, 0.9)',
                borderColor: 'rgba(75, 192, 192, 0.8)',
                data: [
                    dataWeek['RevPAR'][6],
                    dataWeek['RevPAR'][5],
                    dataWeek['RevPAR'][4],
                    dataWeek['RevPAR'][3],
                    dataWeek['RevPAR'][2],
                    dataWeek['RevPAR'][1],
                    dataWeek['RevPAR'][0]
                ]
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
                                label = context.dataset.label;
                                label += ': ';
                                label += financial(context.parsed.y);
                                label += '$';
                            }
                            return label;
                        }
                    }
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

    var weekChart2 = new Chart(document.getElementById('week-2-chart-canvas').getContext('2d'), {
        type: 'line',
        data: {
            labels:[
                dataWeek['date'][6],
                dataWeek['date'][5],
                dataWeek['date'][4],
                dataWeek['date'][3],
                dataWeek['date'][2],
                dataWeek['date'][1],
                dataWeek['date'][0]
            ],
            datasets: [{
                label: 'Percentage of Occupied Rooms (%)',
                data: [
                    dataWeek['Per'][6],
                    dataWeek['Per'][5],
                    dataWeek['Per'][4],
                    dataWeek['Per'][3],
                    dataWeek['Per'][2],
                    dataWeek['Per'][1],
                    dataWeek['Per'][0],
                ],
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                x:{
                    display: true,
                },
                y: {
                    display: true,
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.parsed.x !== null) {
                                label = context.dataset.label;
                                label += ': ';
                                label += financial(context.parsed.y);
                                label += '%';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    var weekChart3 = new Chart(document.getElementById('week-3-chart-canvas').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                dataWeek['date'][6],
                dataWeek['date'][5],
                dataWeek['date'][4],
                dataWeek['date'][3],
                dataWeek['date'][2],
                dataWeek['date'][1],
                dataWeek['date'][0]
            ],
            datasets: [{
                label: 'Hab',
                data: [
                    dataWeek['Hab'][6],
                    dataWeek['Hab'][5],
                    dataWeek['Hab'][4],
                    dataWeek['Hab'][3],
                    dataWeek['Hab'][2],
                    dataWeek['Hab'][1],
                    dataWeek['Hab'][0]
                ],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderWidth: 1
            },
            {
                label: 'Pax',
                data: [
                    dataWeek['Pax'][6],
                    dataWeek['Pax'][5],
                    dataWeek['Pax'][4],
                    dataWeek['Pax'][3],
                    dataWeek['Pax'][2],
                    dataWeek['Pax'][1],
                    dataWeek['Pax'][0]
                ],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
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
        },
    });

    var weekChart4 = new Chart(document.getElementById('week-4-chart-canvas').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                dataWeek['date'][6],
                dataWeek['date'][5],
                dataWeek['date'][4],
                dataWeek['date'][3],
                dataWeek['date'][2],
                dataWeek['date'][1],
                dataWeek['date'][0]
            ],
            datasets: [{
                label: 'DEP',
                data: [
                    dataWeek['DEP'][6],
                    dataWeek['DEP'][5],
                    dataWeek['DEP'][4],
                    dataWeek['DEP'][3],
                    dataWeek['DEP'][2],
                    dataWeek['DEP'][1],
                    dataWeek['DEP'][0]
                ],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderWidth: 1
            },
            {
                label: 'ARR',
                data: [
                    dataWeek['ARR'][6],
                    dataWeek['ARR'][5],
                    dataWeek['ARR'][4],
                    dataWeek['ARR'][3],
                    dataWeek['ARR'][2],
                    dataWeek['ARR'][1],
                    dataWeek['ARR'][0]
                ],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
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
        },
    });

    var yearChart1 = new Chart(document.getElementById('year-day-1-chart-canvas').getContext('2d'), {
        type: 'line',
        data: {
            labels: [
                dataYear['date'][3],
                dataYear['date'][2],
                dataYear['date'][1],
                dataYear['date'][0],
            ],
            datasets: [{
                label: 'ADR',
                data: [
                    dataYear['ADR'][3],
                    dataYear['ADR'][2],
                    dataYear['ADR'][1],
                    dataYear['ADR'][0],
                ],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
            },
            {
                label: 'RevPAR',
                data: [
                    dataYear['RevPAR'][3],
                    dataYear['RevPAR'][2],
                    dataYear['RevPAR'][1],
                    dataYear['RevPAR'][0],
                ],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
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
                                label = context.dataset.label;
                                label += ': ';
                                label += financial(context.parsed.y);
                                label += '$';
                            }
                            return label;
                        }
                    }
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
        },
    });

    var yearChart2 = new Chart(document.getElementById('year-day-2-chart-canvas').getContext('2d'), {
        type: 'line',
        data: {
            labels:[
                dataYear['date'][3],
                dataYear['date'][2],
                dataYear['date'][1],
                dataYear['date'][0],
            ],
            datasets: [{
                label: 'Día',
                data: [
                    dataYear['Per']['Dia'][3],
                    dataYear['Per']['Dia'][2],
                    dataYear['Per']['Dia'][1],
                    dataYear['Per']['Dia'][0],
                ],
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
            },
            {
                label: 'Mes',
                data: [
                    dataYear['Per']['Mes'][3],
                    dataYear['Per']['Mes'][2],
                    dataYear['Per']['Mes'][1],
                    dataYear['Per']['Mes'][0],
                ],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
            },
            {
                label: 'Año',
                data: [
                    dataYear['Per']['Año'][3],
                    dataYear['Per']['Año'][2],
                    dataYear['Per']['Año'][1],
                    dataYear['Per']['Año'][0],
                ],
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                x:{
                    display: true,
                    
                },
                y: {
                    display: true,
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            if (context.parsed.x !== null) {
                                label = context.dataset.label;
                                label += ': ';
                                label += financial(context.parsed.y);
                                label += '%';
                            }
                            return label;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                },
                title: {
                    display: true,
                    text: 'Percentage of Occupied Rooms (%)'
                }
            },
            hover: {
                mode: 'index',
                intersec: false
            },
        }
    });

    var yearChart3 = new Chart(document.getElementById('year-day-3-chart-canvas').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                dataYear['date'][3],
                dataYear['date'][2],
                dataYear['date'][1],
                dataYear['date'][0],
            ],
            datasets: [{
                label: 'Hab',
                data: [
                    dataYear['Hab'][3],
                    dataYear['Hab'][2],
                    dataYear['Hab'][1],
                    dataYear['Hab'][0],
                ],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderWidth: 1
            },
            {
                label: 'Pax',
                data: [
                    dataYear['Pax'][3],
                    dataYear['Pax'][2],
                    dataYear['Pax'][1],
                    dataYear['Pax'][0],
                ],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
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
            },
        },
    });

    var yearChart4 = new Chart(document.getElementById('year-day-4-chart-canvas').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                dataYear['date'][3],
                dataYear['date'][2],
                dataYear['date'][1],
                dataYear['date'][0],
            ],
            datasets: [{
                label: 'DEP',
                data: [
                    dataYear['DEP'][3],
                    dataYear['DEP'][2],
                    dataYear['DEP'][1],
                    dataYear['DEP'][0],
                ],
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                borderWidth: 1
            },
            {
                label: 'ARR',
                data: [
                    dataYear['ARR'][3],
                    dataYear['ARR'][2],
                    dataYear['ARR'][1],
                    dataYear['ARR'][0],
                ],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
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
            },
        },
    });

    function formato(texto){
        return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
    }

</script>

@stop

