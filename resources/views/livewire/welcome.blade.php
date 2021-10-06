<div class="chart tab-pane active" id="year-graf-1" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="year-day-1-chart-canvas" width="300" height="300" style="display: block;" class="chartjs-render-monitor"></canvas>
                    </div>
                    <input wire:model="search" class="form-control" placeholder="dd/mm" >

                    @section('js')
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script>
<script type="text/javascript" src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>
<script type="text/javascript" src="js/gaugechart.babel.js"></script>

<script>

   
    const data_year = {!! json_encode($data_year) !!};
    function financial(x) {
        return Number.parseFloat(x).toFixed(2);
    }

    var yearChart1Canvas = document.getElementById('year-day-1-chart-canvas').getContext('2d')

    const data = {
        labels: [
            data_year['date'][0],
            data_year['date'][1],
            data_year['date'][2],
            data_year['date'][3],
        ],
        datasets: [
                {
                label: 'ADR',
                data: [
                        data_year['ADR'][0],
                        data_year['ADR'][1],
                        data_year['ADR'][2],
                        data_year['ADR'][3],
                ],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                },
                {
                label: 'RevPAR',
                data: [
                        data_year['RevPAR'][0],
                        data_year['RevPAR'][1],
                        data_year['RevPAR'][2],
                        data_year['RevPAR'][3],
                ],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                }
            ]
    };

    const config = {
        type: 'line',
        data: data,
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
        
    };

    var yearChart1 = new Chart(yearChart1Canvas, config);

</script>

@stop

