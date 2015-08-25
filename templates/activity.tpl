<link rel="stylesheet" type="text/css" href="scripts/jqplot/jquery.jqplot.css" />


<script src="scripts/jqplot/jquery.jqplot.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>




<p><div id="chart_activity" style="margin-left:auto;margin-right:auto; height:240px; max-width:1400px; "></div></p><br>
<script type="text/javascript">
    $(document).ready(function () {
        $.jqplot._noToImageButton = true;


    var plot1 = $.jqplot("chart_activity", [[{$graph_data2}], [{$graph_data}]], {
        seriesColors: ["rgba(78, 135, 194, 0.7)", "rgb(211, 235, 59)"],
        title: 'System login',
        highlighter: {
            show: true,
            sizeAdjust: 1,
            tooltipOffset: 9
        },
        grid: {
            background: 'rgba(57,57,57,0.0)',
            drawBorder: false,
            shadow: false,
            gridLineColor: '#666666',
            gridLineWidth: 2
        },
        legend: {
            show: true,
            placement: 'outside'
        },
        seriesDefaults: {
            rendererOptions: {
                smooth: true,
                animation: {
                    show: true
                }
            },
            showMarker: false
        },
        series: [
            {
                fill: true,
                label: 'last years'
            },
            {
                label: 'this year'
            }
        ],
        axesDefaults: {
            rendererOptions: {
                baselineWidth: 1.5,
                baselineColor: '#444444',
                drawBaseline: false
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.DateAxisRenderer,
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    formatString: "%b %e",
                    angle: -30,
                    textColor: '#aaaaaa'
                },

                tickInterval: "7 days",
                drawMajorGridlines: false
            },
            yaxis: {
                renderer: $.jqplot.LogAxisRenderer,
                pad: 0,
                rendererOptions: {
                    minorTicks: 1
                },
                tickOptions: {
                    formatString: "%'d",
                    showMark: false
                }
            }
        }
    });

    $('.jqplot-highlighter-tooltip').addClass('ui-corner-all')
    });


</script>



