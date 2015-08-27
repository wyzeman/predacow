<script type="text/javascript">

    var alerts_opened = {$alerts_opened};

    function alerts_refresh() {

      $.ajax({
            url: 'alerts.php',
            type: 'POST',
            data: 'refresh=1'
        }).done(function(data) {

            var json = JSON.parse(data);
            var decoded = $.base64Decode(json.table_alerts);

            if (json.total_unseens > 0) {
                $('#alerts_image').attr('src','images/alerts/alerts_blink.gif');
            } else {
                $('#alerts_image').attr('src','images/alerts/alerts_normal.png');
            }

            if (json.total_unseens > 0) {
                $('#div_alerts').removeClass('div_no_alerts');
                $('#div_alerts').addClass('div_alerts');
            } else {
                $('#div_alerts').removeClass('div_alerts');
                $('#div_alerts').addClass('div_no_alerts');

            }

            $('#div_alerts_listing').html($.base64Decode(json.table_alerts));

        });

    }

    {literal}
    $(document).ready(function() {

       $("a[id^='alerts_panel_toggle']").click(function(event) {

            event.preventDefault();

            var newOpened = (alerts_opened===0?1:0);
            $.ajax({
                   url: 'alerts.php',
                   type: 'POST',
                   data: 'toggle=' + newOpened

               }).done(function(data) {

//                   var json = JSON.parse(data);
                   if (alerts_opened == 0) {
                        $('#div_alerts_listing').show();
                        $('#div_alerts').animate({
                           width:  "320px",
                           height: "220px"
                        }, 200, function() {
                        });

                       $('#div_events').animate({
                           left: "340px"
                       }, 200, function() {
                       });

                   } else {
                        $('#div_alerts').animate({
                            width:  "90px",
                            height: "16px"
                        }, 200, function() {
                            $('#div_alerts_listing').hide();
                        });

                       $('#div_events').animate({
                           left: "110px"
                       }, 200, function() {
                       });
                   }
                alerts_opened = newOpened;

               }).fail(function(data) {
               });

        });

        setInterval('alerts_refresh()',6000);
    });
    {/literal}

</script>


<div id="alerts_anchor">
    {if $alerts_opened eq 1}
    {if $table_alerts.total_unseens > 0}
    <div id="div_alerts" class="div_alerts ui-corner-top" style="height:220px;width:320px" class="ui-corner-top">
    <div id="div_alerts_header"><a id="alerts_panel_toggle" href="#"><img src="images/alerts/alerts_blink.gif" id="alerts_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Alerts{/t}</a></div>
    {else}
    <div id="div_alerts"  class="div_no_alerts ui-corner-top" style="height:220px;width:320px" class="ui-corner-top">
    <div id="div_alerts_header"><a id="alerts_panel_toggle" href="#"><img src="images/alerts/alerts_normal.png" id="alerts_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Alerts{/t}</a></div>
    {/if}
    <div id="div_alerts_listing" class="ui-corner-all">
    {else}
    {if $table_alerts.total_unseens > 0}
    <div id="div_alerts" class="div_alerts ui-corner-top" style="height:16px" class="ui-corner-top">
    <div id="div_alerts_header"><a id="alerts_panel_toggle" href="#"><img src="images/alerts/alerts_blink.gif" id="alerts_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Alerts{/t}</a></div>
    {else}
    <div id="div_alerts" class="div_no_alerts ui-corner-top" style="height:16px" class="ui-corner-top">
    <div id="div_alerts_header"><a id="alerts_panel_toggle" href="#"><img src="images/alerts/alerts_normal.png" id="alerts_image" width="16" height="16"  style="vertical-align:text-bottom">&nbsp;{t}Alerts{/t}</a></div>
    {/if}
    <div id="div_alerts_listing" class="ui-corner-all" style="display:none">
    {/if}
    {$table_alerts.output}
    
    </div>
</div>
    </div>
    