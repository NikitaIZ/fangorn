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
                color: '#000',
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
              size: 16
            },
            subtitle: {
              text: this._subtitle,
              font: {
                family: '"Open Sans", sans-serif',
                color: '#fff',
                weight: 700,
                size: 32
              }
            }
          },
          onInitialized: function() {
            let currentGauge = $(element);
            let circle = currentGauge.find('.dxg-spindle-hole').clone();
            let border = currentGauge.find('.dxg-spindle-border').clone();
  
            currentGauge.find('.dxg-title text').first().attr('y', 48);
            currentGauge.find('.dxg-title text').last().attr('y', 28);
            currentGauge.find('.dxg-value-indicator').append(border, circle);
          }
          
        }
      }
      
      init() {
        $(this._element).dxCircularGauge(this._buildConfig());
      }
    }

    class GaugeChartMini {
      constructor(element, params) {
        this._element = element;
        this._initialValue = params.initialValue;
        this._higherValue = params.higherValue;
        this._title = params.title;
        this._subtitle = params.subtitle;
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
                color: '#000',
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
            currentGauge.find('.dxg-value-indicator').append(border, circle);
          }
          
        }
      }
      
      init() {
        $(this._element).dxCircularGauge(this._buildConfig());
      }
    }

    function financial(x) {
      return Number.parseFloat(x).toFixed(2);
    }

    $(document).ready(function () {
      let percentage = document.querySelector('.gauge').dataset.percentage;
      $('.gauge').each(function(index, item){
        let params = {
          initialValue: percentage,
          higherValue: 100,
          title: `Habitaciones Ocupadas`,
          subtitle: financial(percentage)+'%'
        };
        let gauge = new GaugeChart(item, params);
        gauge.init();
      });
    });

    $(document).ready(function () {
      let percentage = document.querySelector('#percentage-mini-1').dataset.percentage;
      $('#percentage-mini-1').each(function(index, item){
        let params = {
          initialValue: percentage,
          higherValue: 100,
          title: ` `,
          subtitle: financial(percentage)+'%'
        };
        let gauge = new GaugeChartMini(item, params);
        gauge.init();
      });
    });

    $(document).ready(function () {
      let percentage = document.querySelector('#percentage-mini-2').dataset.percentage;
      $('#percentage-mini-2').each(function(index, item){
        let params = {
          initialValue: percentage,
          higherValue: 100,
          title: ` `,
          subtitle: financial(percentage)+'%'
        };
        let gauge = new GaugeChartMini(item, params);
        gauge.init();
      });
    });

    $(document).ready(function () {
      let percentage = document.querySelector('#percentage-mini-3').dataset.percentage;
      $('#percentage-mini-3').each(function(index, item){
        let params = {
          initialValue: percentage,
          higherValue: 100,
          title: ` `,
          subtitle: financial(percentage)+'%'
        };
        let gauge = new GaugeChartMini(item, params);
        gauge.init();
      });
    });
    
    
});