function financial(x) {
    return Number.parseFloat(x).toFixed(2);
}

function DevtoolGaugeChart(selector, { data = [], options = {},  options1 = {} }) {
    const width    = options.width || 200,
        height     = options.height || 200,
        radiusArc  = Math.min(height, width),
        minVal     = 0.00 // .02, // for rounded corners
        maxVal     = 1 + minVal,
        initDelay  = options.initDelay || 250,
        duration   = options.duration || 700, // carbon durationSlow02
        startValue = 0,
        tau     = 2 * Math.PI,
        arc     = d3.arc()
                    .innerRadius(radiusArc/2 - 12)
                    .cornerRadius((radiusArc/2) - (radiusArc/2 * .925)) // rounded corners
                    .outerRadius(radiusArc/2)
                    .startAngle(0),
        container  = d3.select(selector),
        svg        = container.append('svg')
                    .classed('bx--chart-gauge--red', true)
                    .classed('bx--chart-gauge--zero', true)
                    .classed('bx--chart-gauge--delta-in', false)
                    .classed('bx--chart-gauge', true)
                    .attr('viewBox', '0 0 ' + width + ' ' + height)
                    .attr('preserveAspectRatio', 'none')
                    .attr('xmlns', 'http://www.w3.org/2000/svg')
                    .html(`<defs>
                            <linearGradient id="linear-gradient" gradientTransform="rotate(45)">
                                <stop class="gradient-start" offset="0%" style="transition-duration: ${duration}ms"></stop>
                                <stop class="gradient-end" offset="100%" style="transition-duration: ${duration}ms"></stop>
                            </linearGradient>
                        </defs>`),
        mask       = svg.append("mask")
                        .attr('id', 'bx--chart-gauge__progress-bar')
                        .classed('bx--chart-gauge__progress-bar', true),
        visual     = svg.append("g")
                        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
                        .append("g")
                        .classed('bx--chart-gauge__visual', true),
        content    = svg.append("g")
                        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
                        .append("g")
                        .classed('bx--chart-gauge__content', true);

    const progressBar = mask.append("path")
                            .style('fill', '#fff')
                            .datum({endAngle: minVal * tau})
                            .attr("d", arc);

    const background   =  visual.append("path")
                                .datum({endAngle: tau})
                                .classed('bx--chart-gauge__background', true)
                                .attr("d", arc);

    const progressColor = visual.append("path")
                                .datum({endAngle: tau})
                                .attr('mask', 'url(#bx--chart-gauge__progress-bar)')
                                .classed('bx--chart-gauge__progress-bar-color', true)
                                .attr("d", arc);
    
     // start square end round
     // mask.append('rect')
     //       .style('fill', '#fff')
     //       .attr('width', '20')
     //       .attr('height', '40')
     //       .attr('y', '-50%')

    const value   =  content.append('text')
                            .classed('bx--chart-gauge__value', true)
                            .attr("text-anchor", "middle")
                            .attr("dy", 16) // offset y
                            // .attr("dominant-baseline", "middle")

    const number = value.append('tspan')
                        .datum({value: startValue})
                        .text(startValue)
                        // .attr("dominant-baseline", "middle")
                        .classed('bx--chart-gauge__value-number', true);

    value.append('tspan')
            .text('%')
            // .attr("dominant-baseline", "hanging")
            // .attr("dominant-baseline", "baseline")
            .attr("dy", -24) // offset y
            .attr("dx", 2) // offset X
            .classed('bx--chart-gauge__value-unit', true);

    const deltaGroup  =  content.append('g')
                                .classed('bx--chart-gauge__delta', true) 

    const deltaNumber  =  deltaGroup.append('text')
                                    .datum({deltaValue: startValue})
                                    .text('100')
                                    .classed('bx--chart-gauge__delta-number', true)
                                    .attr("text-anchor", "middle");
    
    const deltaCarets  =  deltaGroup.append('g')
                                    .attr('transform', positionCaret(deltaNumber))
                                    .classed('bx--chart-gauge__delta-carets', true);
    
    const deltaCaretNegative  =  deltaCarets.append('polygon')
                                            .classed('bx--chart-gauge__delta-caret', true)
                                            .classed('bx--chart-gauge__delta-caret--negative', true)
                                            .attr('points', '15 7.5 10 13.75 5 7.5'); // carbon caret icon
    
    const deltaCaretPositive  =  deltaCarets.append('polygon')
                                            .classed('bx--chart-gauge__delta-caret', true)
                                            .classed('bx--chart-gauge__delta-caret--positive', true)
                                            .attr('points', '5 12.5 10 6.25 15 12.5'); // carbon caret icon

    function positionCaret (el) {
        const box = el.node().getBBox();
        const width = box.width;
        const height = box.height;
        return `translate(-${(width/2) + 24}, -${(height/2) + 7})`
    }

    function arcTween(newAngle) {
        return function(d) {
            var interpolate = d3.interpolate(d.endAngle, newAngle);
            return function(t) {
                d.endAngle = interpolate(t);
                return arc(d);
            };
        };
    }
    
    function numberTween (endValue) {
        return function(d) {
            var interpolate = d3.interpolate(d.value, endValue);
            return function(t) {
                d.value = financial(interpolate(t));
                number.text(d.value);
            };
        };
    }
    
    function resultColor (value) {
        const colorStatus = {
            green: false,
            yellow: false,
            orange: false,
            red: false
        };

        if (value >= 75) {
            colorStatus.green = true;
        } else if (value >= 50) {
            colorStatus.yellow = true;
        } else if (value >= 25) {
            colorStatus.orange = true;
        } else if (value >= 0) {
            colorStatus.red = true;
        }

        svg.classed('bx--chart-gauge--green', colorStatus.green);
        svg.classed('bx--chart-gauge--yellow', colorStatus.yellow);
        svg.classed('bx--chart-gauge--orange', colorStatus.orange);
        svg.classed('bx--chart-gauge--red', colorStatus.red);
    }
    
    function deltaTween (endValue) {
        return function(d) {
            var interpolate = d3.interpolate(d.deltaValue, endValue);
            return function(t) {
                d.deltaValue = financial(interpolate(t));
                deltaNumber.text(d.deltaValue + '%');
                deltaCarets.attr('transform', positionCaret(deltaNumber))
            };
        };
    }
    
    function formatDelta (d) {
        return financial(d * 100) / 100;
    }

    function update (data) {
        if (data[0]) {
            transValue(data[0].value * 100); // raw value for display
            transProgBar(forceMinMax(data[0].value));
        }

        if (data[1]) {
            transDeltaNumber(data[1].value * 100);
        }
    }
    
    function forceMinMax (value) {
        if (value <= minVal) {
            return minVal;
        } else if (value >= .995) {
            return maxVal;
        }

        return value;
    }
    
    function transDeltaNumber (value) {
        const sign = Math.sign(value) !== -1;
        svg.classed('bx--chart-gauge--delta-in', value);
        svg.classed('bx--chart-gauge--delta-negative', value && !sign);
        svg.classed('bx--chart-gauge--delta-positive', value && sign);

        // rotate icon whether negative or positive
        // animate icon and alt icon
        deltaNumber.transition()
                    .ease(d3.easeSin)
                    .duration(duration)
                    .tween("text", deltaTween(value))
    }
    
    function transValue (value) {
        svg.classed('bx--chart-gauge--zero', financial(value) <= 0);
        resultColor(value);
        number.transition()
                .ease(d3.easeSin)
                .duration(duration)
                .tween("text", numberTween(value))
    }

    function transProgBar (value) {
        let easing = value ? d3.easeSinOut : d3.easeSinIn;

        progressBar.transition()
            .ease(easing)
            .duration(duration)
            .attrTween("d", arcTween(value * tau));
    }

    setTimeout(() => {
        update(data);
    }, initDelay);

    return { update };
};
