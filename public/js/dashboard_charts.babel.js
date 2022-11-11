var charts_normal = [];
var charts_forecast = [];
var charts_types = [];
var charts_types_forecast = [];


const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
const down    = (ctx, value, days) => ctx.p0.parsed.x >= days-1  ? value : undefined;

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
            family: 'Montserrat'
        },
    }
};

function color_type(name, one) {
    switch (name) {
        case "CNT": label = "rgba(206, 32, 41,"; break;
        case "CMP": label = "rgba(255, 104, 29,"; break;
        case "HSU": label = "rgba(255, 221, 38,"; break;
        case "COM": label = "rgba(0, 163, 254,"; break;
        case "PKG": label = "rgba(0, 35, 111,"; break;
        case "SLB": label = "rgba(45, 1, 109,"; break;
        case "WHD": label = "rgba(13, 109, 1,"; break;
        case "WHI": label = "rgba(146, 229, 75,"; break;
        case "MEG": label = "rgba(75, 229, 112,"; break;
        case "NAT": label = "rgba(40, 229, 129,"; break;
        case "LOC": label = "rgba(7, 155, 123,"; break;
        case "GOV": label = "rgba(10, 196, 215,"; break;
        case "BPR": label = "rgba(8, 138, 222,"; break;
        case "INT": label = "rgba(7, 113, 232,"; break;
        case "IOP": label = "rgba(13, 70, 192,"; break;
        case "DIS": label = "rgba(29, 32, 231,"; break;
        case "WHPI": label = "rgba(128, 88, 242,"; break;
        case "WHPN": label = "rgba(77, 40, 181,"; break;
        case "WHC": label = "rgba(132, 56, 229,"; break;
        case "GCP": label = "rgba(114, 24, 229,"; break;
        case "GCM": label = "rgba(172, 48, 243,"; break;
        case "GDP": label = "rgba(207, 13, 255,"; break;
        case "GEP": label = "rgba(245, 79, 240,"; break;
        case "GTR": label = "rgba(234, 24, 227,"; break;
        case "GTT": label = "rgba(185, 26, 132,"; break;
        case "GAS": label = "rgba(249, 15, 171,"; break;
        case "GMP": label = "rgba(200, 3, 93,"; break;
        case "GSF": label = "rgba(217, 5, 75,"; break;
        case "WEDD": label = "rgba(0, 0, 0,"; break;
        case "GGV": label = "rgba(179, 218, 3,"; break;
        case "ATP": label = "rgba(227, 220, 7,"; break;
    }
    if (one == true) {
        label += " 1)";
    }else{
        label += " 0.5)";
    }
    return label;
}

function financial(x) {
    return Number.parseFloat(x).toFixed(2);
};

function orden(label, y) {
    switch (label) {
        case "Nº Habitaciones":
            label = 'HAB: ';
            label += y;
        break;
        case "Nº Personas":
            label = 'PAX: ';
            label += y;
        break;
        case "% Ocupacion":
            label = 'OCC: ';
            label += financial(y);
            label += '%';
        break;
        case "Día":
            label = 'Día: ';
            label += financial(y);
            label += '%';
        break;
        case "Mes":
            label = 'Mes: ';
            label += financial(y);
            label += '%';
        break;
        case "Año":
            label = 'Año: ';
            label += financial(y);
            label += '%';
        break;
        case "RevPAR":
            label = label;
            label += ': ';
            label += financial(y);
            label += '$';
        break;
        case "ADR":
            label = label;
            label += ': ';
            label += financial(y);
            label += '$';
        break;
        case "Arrival":
            label = 'ARR: ';
            label += y;
        break;
        case "Departure":
            label = 'DEP: ';
            label += y;
        break;
    }
    return label;
}

function orden_type(label, y) {
    switch (label) {
        case "COM":
            label = 'Commercial: ';
            label += y;
        break;
        case "MEG":
            label = 'Mega Agency: ';
            label += y;
        break;
        case "NAT":
            label = 'Corp Pref-National: ';
            label += y;
        break;
        case "LOC":
            label = 'Corp Pref-Local: ';
            label += y;
        break;
        case "GOV":
            label = 'Government: ';
            label += y;
        break;
        case "PKG":
            label = 'Package: ';
            label += y;
        break;
        case "BPR":
            label = 'Brand Promotions: ';
            label += y;
        break;
        case "INT":
            label = 'Internet Mktg: ';
            label += y;
        break;
        case "IOP":
            label = 'Opaque Internet: ';
            label += y;
        break;
        case "DIS":
            label = 'Qualified Discounts: ';
            label += y;
        break;
        case "WHD":
            label = 'Travel Agent: ';
            label += y;
        break;
        case "WHI":
            label = 'Wholesale International: ';
            label += y;
        break;
        case "WHPI":
            label = 'Wholesale Property International: ';
            label += y;
        break;
        case "WHPN":
            label = 'Wholesale Property National: ';
            label += y;
        break;
        case "WHC":
            label = 'Wholesale-Cruise: ';
            label += y;
        break;
        case "GCP":
            label = 'Group-Corporate: ';
            label += y;
        break;
        case "GCM":
            label = 'Group-CMP: ';
            label += y;
        break;
        case "GDP":
            label = 'European Plan: ';
            label += y;
        break;
        case "GEP":
            label = 'Group EP: ';
            label += y;
        break;
        case "GTR":
            label = 'Group-Training: ';
            label += y;
        break;
        case "GTT":
            label = 'Group Tour & Travel: ';
            label += y;
        break;
        case "GAS":
            label = 'Group-Association: ';
            label += y;
        break;
        case "GMP":
            label = 'Group MMP: ';
            label += y;
        break;
        case "GSF":
            label = 'Group-SMERF: ';
            label += y;
        break;
        case "WEDD":
            label = 'Weeding: ';
            label += y;
        break;
        case "GGV":
            label = 'Group-Government: ';
            label += y;
        break;
        case "CNT":
            label = 'Time Share: ';
            label += y;
        break;
        case "ATP":
            label = 'Contract Airline Crew: ';
            label += y;
        break;
        case "CMP":
            label = 'Complimentary: ';
            label += y;
        break;
        case "HSU":
            label = 'House Use: ';
            label += y;
        break;
        case "SLB":
            label = 'SuperLiga: ';
            label += y;
        break;
    }
    return label;
}

function orden_forecast(label, x, y, day) {
    switch (label) {
        case "Nº Habs":
            if (x <= day-1){
                label = 'Historico Hab: ';
                label += y;
            }else{
                label = 'Pronostico Hab: ';
                label += y;
            }
        break;
        case "Nº Pax":
            if (x <= day-1){
                label = 'Historico Prs: ';
                label += y;
            }else{
                label = 'Pronostico Prs: ';
                label += y;
            }
        break;
        case "% Ocupacion":
            if (x <= day-1){
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
            if (x <= day-1){
                label = 'Historico COMP: ';
                label += y;
            }else{
                label = 'Pronostico COMP: ';
                label += y;
            }
        break;
        case "House Use":
            if (x <= day-1){
                label = 'Historico HU: ';
                label += y;
            }else{
                label = 'Pronostico HU: ';
                label += y;
            }
        break;
        case "Out of Order":
            if (x <= day-1){
                label = 'Historico OOO: ';
                label += y;
            }else{
                label = 'Pronostico OOO: ';
                label += y;
            }
        break;
        case "RevPAR":
            if (x <= day-1){
                label = 'Historico RevPAR: ';
                label += financial(y);
                label += '$';
            }else{
                label = 'Pronostico RevPAR: ';
                label += financial(y);
                label += '$';
            }
        break;
        case "RomRev":
            if (x <= day-1){
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
            if (x <= day-1){
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
            if (x <= day-1){
                label = 'Historico ARR: ';
                label += y;
            }else{
                label = 'Pronostico ARR: ';
                label += y;
            }
        break;
        case "Departure":
            if (x <= day-1){
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

function orden_forecast_type(label, x, y, day) {
    switch (label) {
        case "COM":
            if (x <= day-1){
                label = 'Historico Commercial: ';
                label += y;
            }else{
                label = 'Pronostico Commercial: ';
                label += y;
            }
        break;
        case "MEG":
            if (x <= day-1){
                label = 'Historico Mega Agency: ';
                label += y;
            }else{
                label = 'Pronostico Mega Agency: ';
                label += y;
            }
        break;
        case "NAT":
            if (x <= day-1){
                label = 'Historico Corp Pref-National: ';
                label += y;
            }else{
                label = 'Pronostico Corp Pref-National: ';
                label += y;
            }
        break;
        case "LOC":
            if (x <= day-1){
                label = 'Historico Corp Pref-Local: ';
                label += y;
            }else{
                label = 'Pronostico Corp Pref-Local: ';
                label += y;
            }
        break;
        case "GOV":
            if (x <= day-1){
                label = 'Historico Government: ';
                label += y;
            }else{
                label = 'Pronostico Government: ';
                label += y;
            }
        break;
        case "PKG":
            if (x <= day-1){
                label = 'Historico Package: ';
                label += y;
            }else{
                label = 'Pronostico Package: ';
                label += y;
            }
        break;
        case "BPR":
            if (x <= day-1){
                label = 'Historico Brand Promotions: ';
                label += y;
            }else{
                label = 'Pronostico Brand Promotions: ';
                label += y;
            }
        break;
        case "INT":
            if (x <= day-1){
                label = 'Historico Internet Mktg: ';
                label += y;
            }else{
                label = 'Pronostico Internet Mktg: ';
                label += y;
            }
        break;
        case "IOP":
            if (x <= day-1){
                label = 'Historico Opaque Internet: ';
                label += y;
            }else{
                label = 'Pronostico Opaque Internet: ';
                label += y;
            }
        break;
        case "DIS":
            if (x <= day-1){
                label = 'Historico Qualified Discounts: ';
                label += y;
            }else{
                label = 'Pronostico Qualified Discounts: ';
                label += y;
            }
        break;
        case "WHD":
            if (x <= day-1){
                label = 'Historico Travel Agent: ';
                label += y;
            }else{
                label = 'Pronostico Travel Agent: ';
                label += y;
            }
        break;
        case "WHI":
            if (x <= day-1){
                label = 'Historico Wholesale International: ';
                label += y;
            }else{
                label = 'Pronostico Wholesale International: ';
                label += y;
            }
        break;
        case "WHPI":
            if (x <= day-1){
                label = 'Historico Wholesale Property International: ';
                label += y;
            }else{
                label = 'Pronostico Wholesale Property International: ';
                label += y;
            }
        break;
        case "WHPN":
            if (x <= day-1){
                label = 'Historico Wholesale Property National: ';
                label += y;
            }else{
                label = 'Pronostico Wholesale Property National: ';
                label += y;
            }
        break;
        case "WHC":
            if (x <= day-1){
                label = 'Historico Wholesale-Cruise: ';
                label += y;
            }else{
                label = 'Pronostico Wholesale-Cruise: ';
                label += y;
            }
        break;
        case "GCP":
            if (x <= day-1){
                label = 'Historico Group-Corporate: ';
                label += y;
            }else{
                label = 'Pronostico Group-Corporate: ';
                label += y;
            }
        break;
        case "GCM":
            if (x <= day-1){
                label = 'Historico Group-CMP: ';
                label += y;
            }else{
                label = 'Pronostico Group-CMP: ';
                label += y;
            }
        break;
        case "GDP":
            if (x <= day-1){
                label = 'Historico European Plan: ';
                label += y;
            }else{
                label = 'Pronostico European Plan: ';
                label += y;
            }
        break;
        case "GEP":
            if (x <= day-1){
                label = 'Historico Group EP: ';
                label += y;
            }else{
                label = 'Pronostico Group EP: ';
                label += y;
            }
        break;
        case "GTR":
            if (x <= day-1){
                label = 'Historico Group-Training: ';
                label += y;
            }else{
                label = 'Pronostico Group-Training: ';
                label += y;
            }
        break;
        case "GTT":
            if (x <= day-1){
                label = 'Historico Group Tour & Travel: ';
                label += y;
            }else{
                label = 'Pronostico Group Tour & Travel: ';
                label += y;
            }
        break;
        case "GAS":
            if (x <= day-1){
                label = 'Historico Group-Association: ';
                label += y;
            }else{
                label = 'Pronostico Group-Association: ';
                label += y;
            }
        break;
        case "GMP":
            if (x <= day-1){
                label = 'Historico Group MMP: ';
                label += y;
            }else{
                label = 'Pronostico Group MMP: ';
                label += y;
            }
        break;
        case "GSF":
            if (x <= day-1){
                label = 'Historico Group-SMERF: ';
                label += y;
            }else{
                label = 'Pronostico Group-SMERF: ';
                label += y;
            }
        break;
        case "WEDD":
            if (x <= day-1){
                label = 'Historico Weeding: ';
                label += y;
            }else{
                label = 'Pronostico Weeding: ';
                label += y;
            }
        break;
        case "GGV":
            if (x <= day-1){
                label = 'Historico Group-Government: ';
                label += y;
            }else{
                label = 'Pronostico Group-Government: ';
                label += y;
            }
        break;
        case "CNT":
            if (x <= day-1){
                label = 'Historico Time Share: ';
                label += y;
            }else{
                label = 'Pronostico Time Share: ';
                label += y;
            }
        break;
        case "ATP":
            if (x <= day-1){
                label = 'Historico Contract Airline Crew: ';
                label += y;
            }else{
                label = 'Pronostico Contract Airline Crew: ';
                label += y;
            }
        break;
        case "CMP":
            if (x <= day-1){
                label = 'Historico Complimentary: ';
                label += y;
            }else{
                label = 'Pronostico Complimentary: ';
                label += y;
            }
        break;
        case "HSU":
            if (x <= day-1){
                label = 'Historico House Use: ';
                label += y;
            }else{
                label = 'Pronostico House Use: ';
                label += y;
            }
        break;
        case "SLB":
            if (x <= day-1){
                label = 'Historico SuperLiga: ';
                label += y;
            }else{
                label = 'Pronostico SuperLiga: ';
                label += y;
            }
        break;
    }
    return label;
}

function destroy(array){
    array.forEach(element => {
        element.destroy();
    });
}

function charts_array_all(report){
    return [{
        "type": 'line',
        "chart": document.getElementById('week-1-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": [{
            label: 'ADR',
            data: report['week']['ADR'],
            borderColor: 'rgba(23, 162, 184, 1)',
            backgroundColor: 'rgba(23, 162, 184, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'RevPAR',
            data: report['week']['RVP'],
            backgroundColor: 'rgba(40, 167, 69, 0.5)',
            borderColor: 'rgba(40, 167, 69, 1)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('week-2-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": [{
            label: 'Nº Habitaciones',
            data: report['week']['HAB'],
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            type: 'line',
            order: 0,
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'Nº Personas',
            data: report['week']['PAX'],
            borderColor: 'rgba(242, 26, 26, 1)',
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            type: 'line',
            order: 0,
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: '% Ocupacion',
            data: report['week']['PER'],
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1,
            order: 1,
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('week-3-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": [{
            label: 'Arrival',
            data: report['week']['ARR'],
            backgroundColor: 'rgba(27, 188, 155, 0.5)',
            borderColor: 'rgb(27, 188, 155)',
            borderWidth: 1,
        },{
            label: 'Departure',
            data: report['week']['DEP'],
            backgroundColor: 'rgba(45, 62, 80, 0.5)',
            borderColor: 'rgb(45, 62, 80)',
            borderWidth: 1,
        }]
    },{
        "type": 'line',
        "chart": document.getElementById('year-day-1-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'ADR',
            data: report['year']['ADR'],
            borderColor: 'rgba(23, 162, 184, 1)',
            backgroundColor: 'rgba(23, 162, 184, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'RevPAR',
            data: report['year']['RVP'],
            borderColor: 'rgba(40, 167, 69, 1)',
            backgroundColor: 'rgba(40, 167, 69, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        }]
    },{
        "type": 'line',
        "chart": document.getElementById('year-day-2-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'Día',
            data: report['year']['PDS'],
            borderColor: 'rgba(2, 132, 130, 1)',
            backgroundColor: 'rgba(2, 132, 130, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'Mes',
            data: report['year']['PMS'],
            borderColor: 'rgba(111, 28, 164, 1)',
            backgroundColor: 'rgba(111, 28, 164, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'Año',
            data: report['year']['PYS'],
            borderColor: 'rgba(176, 32, 124, 1)',
            backgroundColor: 'rgba(176, 32, 124, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('year-day-3-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'Nº Habitaciones',
            data: report['year']['HAB'],
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            borderColor: 'rgba(255, 193, 7, 1)',
            borderWidth: 1
        },{
            label: 'Nº Personas',
            data: report['year']['PAX'],
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            borderColor: 'rgba(242, 26, 26, 1)',
            borderWidth: 1
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('year-day-4-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'Departure',
            data: report['year']['DEP'],
            backgroundColor: 'rgba(27, 188, 155, 0.5)',
            borderColor: 'rgba(27, 188, 155, 1)',
            borderWidth: 1
        },{
            label: 'Arrival',
            data: report['year']['ARR'],
            backgroundColor: 'rgba(45, 62, 80, 0.5)',
            borderColor: 'rgba(45, 62, 80, 1)',
            borderWidth: 1
        }]
    }];
}

function charts_array_minus(report){
    return [{
        "type": 'bar',
        "chart": document.getElementById('week-2-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": [{
            label: 'Nº Habitaciones',
            data: report['week']['HAB'],
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            type: 'line',
            order: 0,
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'Nº Personas',
            data: report['week']['PAX'],
            borderColor: 'rgba(242, 26, 26, 1)',
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            type: 'line',
            order: 0,
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: '% Ocupacion',
            data: report['week']['OCC'],
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1,
            order: 1,
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('week-3-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": [{
            label: 'Arrival',
            data: report['week']['ARR'],
            backgroundColor: 'rgba(27, 188, 155, 0.5)',
            borderColor: 'rgb(27, 188, 155)',
            borderWidth: 1,
        },{
            label: 'Departure',
            data: report['week']['DEP'],
            backgroundColor: 'rgba(45, 62, 80, 0.5)',
            borderColor: 'rgb(45, 62, 80)',
            borderWidth: 1,
        }]
    },{
        "type": 'line',
        "chart": document.getElementById('year-day-2-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'Día',
            data: report['year']['PDS'],
            borderColor: 'rgba(2, 132, 130, 1)',
            backgroundColor: 'rgba(2, 132, 130, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'Mes',
            data: report['year']['PMS'],
            borderColor: 'rgba(111, 28, 164, 1)',
            backgroundColor: 'rgba(111, 28, 164, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        },{
            label: 'Año',
            data: report['year']['PYS'],
            borderColor: 'rgba(176, 32, 124, 1)',
            backgroundColor: 'rgba(176, 32, 124, 0.5)',
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 10
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('year-day-3-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'Nº Habitaciones',
            data: report['year']['HAB'],
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            borderColor: 'rgba(255, 193, 7, 1)',
            borderWidth: 1
        },{
            label: 'Nº Personas',
            data: report['year']['PAX'],
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            borderColor: 'rgba(242, 26, 26, 1)',
            borderWidth: 1
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('year-day-4-chart-canvas').getContext('2d'),
        "labels": report['year']['date'],
        "color": [{
            label: 'Departure',
            data: report['year']['DEP'],
            backgroundColor: 'rgba(27, 188, 155, 0.5)',
            borderColor: 'rgba(27, 188, 155, 1)',
            borderWidth: 1
        },{
            label: 'Arrival',
            data: report['year']['ARR'],
            backgroundColor: 'rgba(45, 62, 80, 0.5)',
            borderColor: 'rgba(45, 62, 80, 1)',
            borderWidth: 1
        }]
    }];
}

function types_array(report){
    var week_types = [{
        "type": 'line',
        "chart": document.getElementById('week-4-rooms-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": []
    },{
        "type": 'line',
        "chart": document.getElementById('week-4-people-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": []
    },{
        "type": 'line',
        "chart": document.getElementById('week-4-adults-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": []
    },{
        "type": 'line',
        "chart": document.getElementById('week-4-childrem-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": []
    },{
        "type": 'line',
        "chart": document.getElementById('week-4-rat-chart-canvas').getContext('2d'),
        "labels": report['week']['dates'],
        "color": []
    }];
    var i = 0;
    report["week"]["TOR"].forEach(element => {
        if (element.name == "CMP" || element.name == "HSU") {
            week_types[0]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[1]["color"][i] = {
                label: element.name,
                data: element.people,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[2]["color"][i] = {
                label: element.name,
                data: element.adults,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[3]["color"][i] = {
                label: element.name,
                data: element.childrem,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[4]["color"][i] = {
                label: element.name,
                data: element.rat,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
        }else{
            week_types[0]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[1]["color"][i] = {
                label: element.name,
                data: element.people,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[2]["color"][i] = {
                label: element.name,
                data: element.adults,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[3]["color"][i] = {
                label: element.name,
                data: element.childrem,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
            week_types[4]["color"][i] = {
                label: element.name,
                data: element.rat,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                borderWidth: 2,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
            };
        }
        i++
    });
    var i = 0;
    
    return week_types;
};

function forecast_array_one(report){
    return [{
        "days": report["month"]["history"]["DYS"],
        "type": 'bar',
        "chart": document.getElementById('forecast-occ-1-chart-canvas').getContext('2d'),
        "labels": report['month']['dates'],
        "color": [{
            label: 'Nº Habs',
            data: report["month"]["NRS"],
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', report["month"]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"]["history"]["DYS"]),
            },
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 3,
            pointHoverRadius: 6,
            spanGaps: true,
            type: 'line',
            order: 0,
        },{
            label: 'Nº Pax',
            data: report["month"]["NPS"],
            borderColor: 'rgba(242, 26, 26, 1)',
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(242, 26, 26, 0.5)', report["month"]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"]["history"]["DYS"]),
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
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('forecast-arrival-1-chart-canvas').getContext('2d'),
        "labels": report['month']['dates'],
        "color": [{
            label: 'Arrival',
            data: report["month"]["ARR"],
            backgroundColor: report["month"]["BARR"],
            borderColor: report["month"]["LARR"],
            borderWidth: 1,
        },{
            label: 'Departure',
            data: report["month"]["DEP"],
            backgroundColor: report["month"]["BDEP"],
            borderColor: report["month"]["LDEP"],
            borderWidth: 1,
        }]
    }];
}

function forecast_array_three(report){
    return [{
        "days": report["month"][0]["history"]["DYS"],
        "type": 'bar',
        "chart": document.getElementById('forecast-occ-1-chart-canvas').getContext('2d'),
        "labels": report['month'][0]['dates'],
        "color": [{
            label: 'Nº Habs',
            data: report["month"][0]["NRS"],
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', report["month"][0]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][0]["history"]["DYS"]),
            },
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 3,
            pointHoverRadius: 6,
            spanGaps: true,
            type: 'line',
            order: 0,
        },{
            label: 'Nº Pax',
            data: report["month"][0]["NPS"],
            borderColor: 'rgba(242, 26, 26, 1)',
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(242, 26, 26, 0.5)', report["month"][0]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][0]["history"]["DYS"]),
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
            data: report["month"][0]["OCC"],
            backgroundColor: report["month"][0]["BOCC"],
            borderColor: report["month"][0]["LOCC"],
            borderWidth: 1,
            order: 1,
        }]
    },{
        "days": report["month"][1]["history"]["DYS"],
        "type": 'bar',
        "chart": document.getElementById('forecast-occ-2-chart-canvas').getContext('2d'),
        "labels": report['month'][1]['dates'],
        "color": [{
            label: 'Nº Habs',
            data: report["month"][1]["NRS"],
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', report["month"][1]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][1]["history"]["DYS"]),
            },
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 3,
            pointHoverRadius: 6,
            spanGaps: true,
            type: 'line',
            order: 0,
        },{
            label: 'Nº Pax',
            data: report["month"][1]["NPS"],
            borderColor: 'rgba(242, 26, 26, 1)',
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(242, 26, 26, 0.5)', report["month"][1]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][1]["history"]["DYS"]),
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
            data: report["month"][1]["OCC"],
            backgroundColor: report["month"][1]["BOCC"],
            borderColor: report["month"][1]["LOCC"],
            borderWidth: 1,
            order: 1,
        }]
    },{
        "days": report["month"][2]["history"]["DYS"],
        "type": 'bar',
        "chart": document.getElementById('forecast-occ-3-chart-canvas').getContext('2d'),
        "labels": report['month'][2]['dates'],
        "color": [{
            label: 'Nº Habs',
            data: report["month"][2]["NRS"],
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(255, 193, 7, 0.5)', report["month"][2]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][2]["history"]["DYS"]),
            },
            tension: 0.5,
            pointStyle: 'circle',
            pointRadius: 3,
            pointHoverRadius: 6,
            spanGaps: true,
            type: 'line',
            order: 0,
        },{
            label: 'Nº Pax',
            data: report["month"][2]["NPS"],
            borderColor: 'rgba(242, 26, 26, 1)',
            backgroundColor: 'rgba(242, 26, 26, 0.5)',
            segment: {
                borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(242, 26, 26, 0.5)', report["month"][2]["history"]["DYS"]),
                borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][2]["history"]["DYS"]),
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
            data: report["month"][2]["OCC"],
            backgroundColor: report["month"][2]["BOCC"],
            borderColor: report["month"][2]["LOCC"],
            borderWidth: 1,
            order: 1,
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('forecast-arrival-1-chart-canvas').getContext('2d'),
        "labels": report['month'][0]['dates'],
        "color": [{
            label: 'Arrival',
            data: report["month"][0]["ARR"],
            backgroundColor: report["month"][0]["BARR"],
            borderColor: report["month"][0]["LARR"],
            borderWidth: 1,
        },{
            label: 'Departure',
            data: report["month"][0]["DEP"],
            backgroundColor: report["month"][0]["BDEP"],
            borderColor: report["month"][0]["LDEP"],
            borderWidth: 1,
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('forecast-arrival-2-chart-canvas').getContext('2d'),
        "labels": report['month'][1]['dates'],
        "color": [{
            label: 'Arrival',
            data: report["month"][1]["ARR"],
            backgroundColor: report["month"][1]["BARR"],
            borderColor: report["month"][1]["LARR"],
            borderWidth: 1,
        },{
            label: 'Departure',
            data: report["month"][1]["DEP"],
            backgroundColor: report["month"][1]["BDEP"],
            borderColor: report["month"][1]["LDEP"],
            borderWidth: 1,
        }]
    },{
        "type": 'bar',
        "chart": document.getElementById('forecast-arrival-3-chart-canvas').getContext('2d'),
        "labels": report['month'][2]['dates'],
        "color": [{
            label: 'Arrival',
            data: report["month"][2]["ARR"],
            backgroundColor: report["month"][2]["BARR"],
            borderColor: report["month"][2]["LARR"],
            borderWidth: 1,
        },{
            label: 'Departure',
            data: report["month"][2]["DEP"],
            backgroundColor: report["month"][2]["BDEP"],
            borderColor: report["month"][2]["LDEP"],
            borderWidth: 1,
        }]
    }];
}

function forecast_types_array_one(report){
    var month_types = [{
        "days": report["month"]["history"]["DYS"],
        "type": 'line',
        "chart": document.getElementById('forecast-rooms-1-chart-canvas').getContext('2d'),
        "labels": report['month']['dates'],
        "color": []
    }];
    var i = 0;
    report["month"]["TOR"].forEach(element => {
        if (element.name == "CMP" || element.name == "HSU") {
            month_types[0]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.0)') || down(ctx, 'rgb(108, 117, 125, 0.5)', report["month"]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"]["history"]["DYS"]),
                },
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }else{
            month_types[0]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, 'rgb(108, 117, 125, 0.5)', report["month"]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"]["history"]["DYS"]),
                },
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }
        i++
    });
    var i = 0;
    return month_types;
};

function forecast_types_array_three(report){
    var month_types = [{
        "days": report["month"][0]["history"]["DYS"],
        "type": 'line',
        "chart": document.getElementById('forecast-rooms-1-chart-canvas').getContext('2d'),
        "labels": report['month'][0]['dates'],
        "color": []
    },{
        "days": report["month"][1]["history"]["DYS"],
        "type": 'line',
        "chart": document.getElementById('forecast-rooms-2-chart-canvas').getContext('2d'),
        "labels": report['month'][1]['dates'],
        "color": []
    },{
        "days": report["month"][2]["history"]["DYS"],
        "type": 'line',
        "chart": document.getElementById('forecast-rooms-3-chart-canvas').getContext('2d'),
        "labels": report['month'][2]['dates'],
        "color": []
    }];
    var i = 0;
    report["month"][0]["TOR"].forEach(element => {
        if (element.name == "CMP" || element.name == "HSU") {
            month_types[0]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.0)') || down(ctx, element.lines, report["month"][0]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][0]["history"]["DYS"]),
                },
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }else{
            month_types[0]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, element.lines, report["month"][0]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][0]["history"]["DYS"]),
                },
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }
        i++
    });
    var i = 0;
    report["month"][1]["TOR"].forEach(element => {
        if (element.name == "CMP" || element.name == "HSU") {
            month_types[1]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, element.lines, report["month"][1]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][1]["history"]["DYS"]),
                },
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }else{
            month_types[1]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, element.lines, report["month"][1]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][1]["history"]["DYS"]),
                },
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }
        i++
    });
    var i = 0;
    report["month"][2]["TOR"].forEach(element => {
        if (element.name == "CMP" || element.name == "HSU") {
            month_types[2]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, element.lines, report["month"][2]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][2]["history"]["DYS"]),
                },
                hidden: true,
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }else{
            month_types[2]["color"][i] = {
                label: element.name,
                data: element.rooms,
                backgroundColor: color_type(element.name, false),
                borderColor: color_type(element.name, true),
                segment: {
                    borderColor: ctx => skipped(ctx, 'rgb(0,0,0,0.2)') || down(ctx, element.lines, report["month"][2]["history"]["DYS"]),
                    borderDash: ctx => skipped(ctx, [6, 6]) || down(ctx, [6, 6], report["month"][2]["history"]["DYS"]),
                },
                tension: 0.5,
                pointStyle: 'circle',
                pointRadius: 3,
                pointHoverRadius: 6,
                spanGaps: true
            }
        }
        i++
    });
    var i = 0;
    return month_types;
};

function charts_show(data){
    var i = 0;
    data.forEach(element => {
        charts_normal[i] = new Chart(element.chart, {
            type: element.type,
            data: {
                labels: element.labels,
                datasets: element.color
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: title,
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                label = orden(context.dataset.label, context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: grill
            }
        });
        i++;
    });
};

function charts_types_show(data){
    var i = 0;
    data.forEach(element => {
        charts_types[i] = new Chart(element.chart, {
            type: element.type,
            data: {
                labels: element.labels,
                datasets: element.color
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                label = orden_type(context.dataset.label, context.parsed.y);
                                return label;
                            }
                        }
                    }
                },
                scales: grill
            }
        });
        i++;
    });
};

function charts_forecast_show(data){
    var i = 0;
    data.forEach(element => {
        charts_forecast[i] = new Chart(element.chart, {
            type: element.type,
            data: {
                labels: element.labels,
                datasets: element.color
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
                                label = orden_forecast(context.dataset.label, context.parsed.x, context.parsed.y, element.days);
                                return label;
                            }
                        }
                    }
                },
                scales: grill
            }
        });
        i++;
    });
};

function charts_forecast_types_show(data){
    var i = 0;
    data.forEach(element => {
        charts_types_forecast[i] = new Chart(element.chart, {
            type: element.type,
            data: {
                labels: element.labels,
                datasets: element.color
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                label = orden_forecast_type(context.dataset.label, context.parsed.x, context.parsed.y, element.days);
                                return label;
                            }
                        }
                    }
                },
                scales: grill
            }
        });
        i++;
    });
};
