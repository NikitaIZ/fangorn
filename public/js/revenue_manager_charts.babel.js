
        var limit_one   = report["month"][0]["history"]["DYS"] - 1;
        var limit_two   = report["month"][1]["history"]["DYS"] - 1;
        var limit_three = report["month"][2]["history"]["DYS"] - 1;

        const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
        const down    = (ctx, value, days) => ctx.p0.parsed.x >= days ? value : undefined;

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

        var array = gauges_array(date);

        gauges_show(array);

        function orden_forecast(label, x, y, days) {
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
                case "% Occ":
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
                        label = 'Pronostico Room Revenue: ';
                        label += financial(y);
                        label += '$';
                    }
                break;
                case "F&B Revenue":
                    if (x <= days){
                        label = 'Historico F&B Revenue: ';
                        label += financial(y);
                        label += '$';
                    }else{
                        label = 'Pronostico F&B Revenue: ';
                        label += financial(y);
                        label += '$';
                    }
                break;
                case "Other Revenue":
                    if (x <= days){
                        label = 'Historico Other Revenue: ';
                        label += financial(y);
                        label += '$';
                    }else{
                        label = 'Pronostico Other Revenue: ';
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

        function colorize(opaque, days) {
            if (opaque === true){
                return (ctx) => {
                    const v = ctx.parsed.y;
                    const h = ctx.parsed.x;
                    const c = v < -50 ? 'rgba(214, 0, 0, 0.5)'
                    : v < 20 && h < days+1 ? 'rgba(214, 0, 0, 0.75)'
                    : v < 20 && h > days   ? 'rgba(214, 0, 0, 0.5)'
                    : v < 50 && h < days+1 ? 'rgba(68, 222, 40, 0.5)'
                    : v < 50 && h > days   ? 'rgba(68, 222, 40, 0.5)'
                    : 'rgba(68, 222, 40, 0.5)';
                    return c;
                };
            }else{
                return (ctx) => {
                    const v = ctx.parsed.y;
                    const h = ctx.parsed.x;
                    const c = v < -50 ? 'rgba(214, 0, 0, 1)'
                    : v < 20 && h < days+1 ? 'rgba(214, 0, 0, 1)'
                    : v < 20 && h > days   ? 'rgba(214, 0, 0, 0.75)'
                    : v < 50 && h < days+1 ? 'rgba(68, 222, 40, 1)'
                    : v < 50 && h > days   ? 'rgba(68, 222, 40, 0.75)'
                    : 'rgba(68, 222, 40, 1)';
                    return c;
                };
            }
        }

        function show_form(){
            date1.className = "invisible d-none";
            date2.className = "col-6";
        };
        function hidden_form(){
            date1.className = "col-6";
            date2.className = "invisible d-none";
        };
        function show_RAT(){
            pers.className = "invisible d-none";
            rat.className   = "col-6";
        };
        function hidden_RAT(){
            pers.className = "col-6";
            rat.className   = "invisible d-none";
        };

        var averageChart = new Chart(document.getElementById('forecast-meta-1-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: report["month"][0]["dates"],
                datasets: [{
                    label: 'Nº Habs',
                    data: report["month"][0]["NRS"],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', limit_one),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_one),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                    type: 'line',
                    order: 0,
                },{
                    label: '% Occ',
                    data: report["month"][0]["OCC"],
                    backgroundColor: report["month"][0]["BOCC"],
                    borderColor: report["month"][0]["LOCC"],
                    borderWidth: 1,
                    order: 1,
                },{
                    label: '% Promedio',
                    data: report["month"][0]["OCP"],
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
                                        label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_one);
                                    }
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
                        backgroundColor: colorize(true, limit_one),
                        borderColor: colorize(false, limit_one),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var averageChart = new Chart(document.getElementById('forecast-meta-2-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: report["month"][1]["dates"],
                datasets: [{
                    label: 'Nº Habs',
                    data: report["month"][1]["NRS"],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', limit_two),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_two),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                    type: 'line',
                    order: 0,
                },{
                    label: '% Occ',
                    data: report["month"][1]["OCC"],
                    backgroundColor: report["month"][1]["BOCC"],
                    borderColor: report["month"][1]["LOCC"],
                    borderWidth: 1,
                    order: 1,
                },{
                    label: '% Promedio',
                    data: report["month"][1]["OCP"],
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
                                        label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_two);
                                    }
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
                        backgroundColor: colorize(true, limit_two),
                        borderColor: colorize(false, limit_two),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var averageChart = new Chart(document.getElementById('forecast-meta-3-chart-canvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: report["month"][2]["dates"],
                datasets: [{
                    label: 'Nº Habs',
                    data: report["month"][2]["NRS"],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', limit_three),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_three),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                    type: 'line',
                    order: 0,
                },{
                    label: '% Occ',
                    data: report["month"][2]["OCC"],
                    backgroundColor: report["month"][2]["BOCC"],
                    borderColor: report["month"][2]["LOCC"],
                    borderWidth: 1,
                    order: 1,
                },{
                    label: '% Promedio',
                    data: report["month"][2]["OCP"],
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
                                        label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_three);
                                    }
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
                        backgroundColor: colorize(true, limit_three),
                        borderColor: colorize(false, limit_three),
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
                labels: report["month"][0]["dates"],
                datasets: [
                {
                    label: 'ADR',
                    data: report["month"][0]["ADR"],
                    borderColor: 'rgba(60, 141, 188, 1)',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(60, 141, 188, 0.5)', limit_one),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_one),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'RevPAR',
                    data: report["month"][0]["RVP"],
                    borderColor: 'rgba(47, 195, 38, 1)',
                    backgroundColor: 'rgba(47, 195, 38, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 195, 38, 0.5)', limit_one),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_one),
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_one);
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
                        backgroundColor: colorize(true, limit_one),
                        borderColor: colorize(false, limit_one),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var moneyChart = new Chart(document.getElementById('forecast-money-2-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"][1]["dates"],
                datasets: [
                {
                    label: 'ADR',
                    data: report["month"][1]["ADR"],
                    borderColor: 'rgba(60, 141, 188, 1)',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(60, 141, 188, 0.5)', limit_two),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_two),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'RevPAR',
                    data: report["month"][1]["RVP"],
                    borderColor: 'rgba(47, 195, 38, 1)',
                    backgroundColor: 'rgba(47, 195, 38, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 195, 38, 0.5)', limit_two),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_two),
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_two);
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
                        backgroundColor: colorize(true, limit_two),
                        borderColor: colorize(false, limit_two),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var moneyChart = new Chart(document.getElementById('forecast-money-3-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"][2]["dates"],
                datasets: [
                {
                    label: 'ADR',
                    data: report["month"][2]["ADR"],
                    borderColor: 'rgba(60, 141, 188, 1)',
                    backgroundColor: 'rgba(60, 141, 188, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(60, 141, 188, 0.5)', limit_three),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_three),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'RevPAR',
                    data: report["month"][2]["RVP"],
                    borderColor: 'rgba(47, 195, 38, 1)',
                    backgroundColor: 'rgba(47, 195, 38, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 195, 38, 0.5)', limit_three),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_three),
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_three);
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
                        backgroundColor: colorize(true, limit_three),
                        borderColor: colorize(false, limit_three),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var revenueChart = new Chart(document.getElementById('forecast-revroom-1-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"][0]["dates"],
                datasets: [{
                    label: 'Room Revenue',
                    data: report["month"][0]["RVN"],
                    borderColor: 'rgba(47, 159, 131, 1)',
                    backgroundColor: 'rgba(47, 159, 131, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 159, 131, 0.5)', limit_one),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_one),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'F&B Revenue',
                    data: report["month"][0]["FVN"],
                    borderColor: 'rgba(97, 217, 104, 1)',
                    backgroundColor: 'rgba(97, 217, 104, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(97, 217, 104, 0.5)', limit_one),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_one),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'Other Revenue',
                    data: report["month"][0]["OVN"],
                    borderColor: 'rgba(195, 225, 98, 1)',
                    backgroundColor: 'rgba(195, 225, 98, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(195, 225, 98, 0.5)', limit_one),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_one),
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_one);
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
                        backgroundColor: colorize(true, limit_one),
                        borderColor: colorize(false, limit_one),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var revenueChart = new Chart(document.getElementById('forecast-revroom-2-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"][1]["dates"],
                datasets: [{
                    label: 'Room Revenue',
                    data: report["month"][1]["RVN"],
                    borderColor: 'rgba(47, 159, 131, 1)',
                    backgroundColor: 'rgba(47, 159, 131, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 159, 131, 0.5)', limit_two),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_two),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'F&B Revenue',
                    data: report["month"][1]["FVN"],
                    borderColor: 'rgba(97, 217, 104, 1)',
                    backgroundColor: 'rgba(97, 217, 104, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(97, 217, 104, 0.5)', limit_two),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_two),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'Other Revenue',
                    data: report["month"][1]["OVN"],
                    borderColor: 'rgba(195, 225, 98, 1)',
                    backgroundColor: 'rgba(195, 225, 98, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(195, 225, 98, 0.5)', limit_two),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_two),
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_two);
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
                        backgroundColor: colorize(true, limit_two),
                        borderColor: colorize(false, limit_two),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })

        var revenueChart = new Chart(document.getElementById('forecast-revroom-3-chart-canvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: report["month"][2]["dates"],
                datasets: [{
                    label: 'Room Revenue',
                    data: report["month"][2]["RVN"],
                    borderColor: 'rgba(47, 159, 131, 1)',
                    backgroundColor: 'rgba(47, 159, 131, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(47, 159, 131, 0.5)', limit_three),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_three),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'F&B Revenue',
                    data: report["month"][2]["FVN"],
                    borderColor: 'rgba(97, 217, 104, 1)',
                    backgroundColor: 'rgba(97, 217, 104, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(97, 217, 104, 0.5)', limit_three),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_three),
                    },
                    tension: 0.5,
                    pointStyle: 'circle',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    spanGaps: true,
                },{
                    label: 'Other Revenue',
                    data: report["month"][2]["OVN"],
                    borderColor: 'rgba(195, 225, 98, 1)',
                    backgroundColor: 'rgba(195, 225, 98, 0.5)',
                    segment: {
                        borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(195, 225, 98, 0.5)', limit_three),
                        borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], limit_three),
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, limit_three);
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
                        backgroundColor: colorize(true, limit_three),
                        borderColor: colorize(false, limit_three),
                        borderWidth: 2
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                }
            }
        })
