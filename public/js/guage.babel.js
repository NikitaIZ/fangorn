var gauge = [];
var gauges = [];

function financial(x) {
    return Number.parseFloat(x).toFixed(2);
}

function GaugeChart(element, params) {
    this._element = element;
    this._initialValue = params.initialValue;
    this._higherValue = params.higherValue;
    this._title = params.title;
    this._subtitle = params.subtitle;
    var element = this._element;
    var buildConfig = {
        value: this._initialValue,
        valueIndicator: {
            color: '#000'
        },
        geometry: {
            startAngle: 180,
            endAngle: 360
        },
        scale: {
            startValue: 0,
            endValue: this._higherValue,
            customTicks: [0, 25, 50, 75, 100],
            tick: { 
                length: 8
            },
            label: {
                font: {
                    color: '#ffffff',
                    size: params.size_one,
                    family: '"Montserrat", "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol" '
                }
            }
        },
        title: {
            verticalAlignment: 'bottom',
            text: this._title,
            font: {
                family: '"Montserrat", "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol" ',
                color: '#fff',
                line: 2,
                size: params.size_one
            },
            subtitle: {
                text: this._subtitle,
                font: {
                    family: '"Gotham-Rounded-Bold", "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"',
                    color: '#fff',
                    weight: 100,
                    size: params.size_two
                }
            }
        },
        onInitialized: function() {
            var currentGauge = $(element);
            var circle = currentGauge.find('.dxg-spindle-hole').clone();
            var border = currentGauge.find('.dxg-spindle-border').clone();
            currentGauge.find('.dxg-title text').first().attr('y', 48);
            currentGauge.find('.dxg-title text').last().attr('y', 28);
        }
    }
    $(this._element).dxCircularGauge(buildConfig);

};

function gauges_array(date){
    return [{
        "percentage": document.querySelector('#date-'+ date +'').dataset.percentage,
        "name": '#date-'+date,
        "title": `Habitaciones Ocupadas`,
        "size_one": 18,
        "size_two": 30
    },{
        "percentage": document.querySelector('#date-'+ date +'-mini-1').dataset.percentage,
        "name": '#date-'+ date +'-mini-1',
        "title": `Ayer`,
        "size_one": 18,
        "size_two": 20
    },{
        "percentage": document.querySelector('#date-'+ date +'-mini-2').dataset.percentage,
        "name": '#date-'+ date +'-mini-2',
        "title": `Mes`,
        "size_one": 18,
        "size_two": 20
    },{
        "percentage": document.querySelector('#date-'+ date +'-mini-3').dataset.percentage,
        "name": '#date-'+ date +'-mini-3',
        "title": `Año`,
        "size_one": 18,
        "size_two": 20
    }];
}

function gauges_show(data){
    var i = 0;
    data.forEach(element => {
        var percentage = element.percentage;
        $(element.name).each(function(index, item){
            var params = {
                initialValue: percentage,
                higherValue: 100,
                title: element.title,
                subtitle: financial(percentage)+'%', 
                size_one: element.size_one,
                size_two: element.size_two
            };
            gauge[i] = GaugeChart(item, params);
        });
        i++;
    });
};