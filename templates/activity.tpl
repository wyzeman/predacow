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




<p><div id="chart_activity" style="height:240px; width:1450px;"></div></p><br>
<script type="text/javascript">

    $(document).ready(function(){
        var plot1 = $.jqplot ('chart_activity', [[{$graph_data}]], {
            axes:{
                xaxis:{
                    renderer:$.jqplot.DateAxisRenderer,
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickOptions:{
                        formatString:'%b&nbsp;%#d'
                    }
                },
                yaxis:{
                    label:'Login Activity',
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer
                }

            },
            highlighter: {
                show: true,
                sizeAdjust: 7.5
            },
            cursor: {
                show: false
            }
        });

    });

</script>



