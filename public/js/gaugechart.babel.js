var gauge = [];
$(function() {
    class GaugeChart {
        constructor(element, params) {
            this._element = element;
            this._initialValue = params.initialValue;
            this._higherValue = params.higherValue;
            this._title = params.title;
            this._subtitle = params.subtitle;
        }
        _buildConfig() {
            var element = this._element;
            return {
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
                            size: 18,
                            family: '"Open Sans", sans-serif'
                        }
                    }
                },
                title: {
                    verticalAlignment: 'bottom',
                    text: this._title,
                    font: {
                        family: '"Open Sans", sans-serif',
                        color: '#fff',
                        size: 18
                    },
                    subtitle: {
                        text: this._subtitle,
                        font: {
                            family: '"Open Sans", sans-serif',
                            color: '#fff',
                            weight: 700,
                            size: 30
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
        }
        init() {
            $(this._element).dxCircularGauge(this._buildConfig());
        }
    };

    class GaugeChartMini {
        constructor(element, params) {
            this._element      = element;
            this._initialValue = params.initialValue;
            this._higherValue  = params.higherValue;
            this._title        = params.title;
            this._subtitle     = params.subtitle;
        }
        _buildConfig() {
            let element = this._element;
            return {
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
                            color: '#fff',
                            size: 14,
                            family: '"Open Sans", sans-serif'
                        }
                    }
                },
                title: {
                    verticalAlignment: 'bottom',
                    text: this._title,
                    font: {
                        family: '"Open Sans", sans-serif',
                        weight: 700,
                        color: '#fff',
                        size: 14
                    },
                    subtitle: {
                        text: this._subtitle,
                        font: {
                            family: '"Open Sans", sans-serif',
                            color: '#fff',
                            weight: 700,
                            size: 20
                        }
                    }
                },
                onInitialized: function() {
                    let currentGauge = $(element);
                    let circle = currentGauge.find('.dxg-spindle-hole').clone();
                    let border = currentGauge.find('.dxg-spindle-border').clone();
                    currentGauge.find('.dxg-title text').first().attr('y', 48);
                    currentGauge.find('.dxg-title text').last().attr('y', 28);
                }
            }
        }
        init() {
            $(this._element).dxCircularGauge(this._buildConfig());
        }
    }

    $(document).ready(function () {
        var percentage = document.querySelector('#percentage').dataset.percentage;
        $('#percentage').each(function(index, item){
            var params = {
                initialValue: percentage,
                higherValue: 100,
                title: `Habitaciones Ocupadas`,
                subtitle: financial(percentage)+'%'
            };
            gauge[0] = new GaugeChart(item, params);
            gauge[0].init();
        });
    });

    $(document).ready(function () {
        var percentage = document.querySelector('#percentage-mini-1').dataset.percentage;
        $('#percentage-mini-1').each(function(index, item){
            var params = {
                initialValue: percentage,
                higherValue: 100,
                title: ` `,
                subtitle: financial(percentage)+'%'
            };
            gauge[1] = new GaugeChartMini(item, params);
            gauge[1].init();
        });
    });

    $(document).ready(function () {
        var percentage = document.querySelector('#percentage-mini-2').dataset.percentage;
        $('#percentage-mini-2').each(function(index, item){
            var params = {
                initialValue: percentage,
                higherValue: 100,
                title: ` `,
                subtitle: financial(percentage)+'%'
            };
            gauge[2] = new GaugeChartMini(item, params);
            gauge[2].init();
        });
    });

    $(document).ready(function () {
        var percentage = document.querySelector('#percentage-mini-3').dataset.percentage;
        $('#percentage-mini-3').each(function(index, item){
            var params = {
                initialValue: percentage,
                higherValue: 100,
                title: ` `,
                subtitle: financial(percentage)+'%'
            };
            gauge[3] = new GaugeChartMini(item, params);
            gauge[3].init();
        });
    });
});

function financial(x) {
    return Number.parseFloat(x).toFixed(2);
}

function gauges_array(){
    return [{
        "percentage": document.querySelector('#percentage').dataset.percentage,
        "name": '#percentage',
        "title": `Habitaciones Ocupadas`
    },{
        "percentage": document.querySelector('#percentage-mini-1').dataset.percentage,
        "name": '#percentage-mini-1',
        "title": ` `
    },{
        "percentage": document.querySelector('#percentage-mini-2').dataset.percentage,
        "name": '#percentage-mini-2',
        "title": ` `
    },{
        "percentage": document.querySelector('#percentage-mini-3').dataset.percentage,
        "name": '#percentage-mini-3',
        "title": ` `
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
                subtitle: financial(percentage)+'%'
            };
            if (i<=0) {
                var gauge = new GaugeChart(item, params);
                gauge.init();
            }else{
                var gauge = new GaugeChartMini(item, params);
                gauge.init();
            }
        });
        i++;
    });
};