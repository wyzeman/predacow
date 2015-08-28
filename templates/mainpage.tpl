<link rel="stylesheet" type="text/css" href="scripts/jqplot/jquery.jqplot.css" />


<script src="scripts/jqplot/jquery.jqplot.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="scripts/jqplot/plugins/jqplot.canvasTextRenderer.js"></script>

{$form}


<p><div id="pie1" style=" height:240px; max-width:300px; "></div></p><br>

<script type="text/javascript">

    $(document).ready(function(){
        var plot1 = $.jqplot('pie1', [[{$graph_data}]], {
            {literal}
            gridPadding: {top:0, bottom:38, left:0, right:0},
            seriesDefaults:{
                renderer:$.jqplot.PieRenderer,
                trendline:{ show:false },
                rendererOptions: { padding: 8, showDataLabels: true }
            },
            legend:{
                show:true,
                placement: 'outside',
                rendererOptions: {
                    numberRows: 1
                },
                location:'s',
                marginTop: '15px'
            }
            {/literal}
        });
    });

</script>