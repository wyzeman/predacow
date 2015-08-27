<script type="text/javascript">
    
    var opened = {$events_opened};
    var audio_played = false;
    
    
    
    function events_refresh() {

      $.ajax({
            url: 'events.php',
            type: 'POST',
            data: 'refresh=1'
        }).done(function(data) {
            
            var json = JSON.parse(data);
            var decoded = $.base64Decode(json.table_events);
            
            if (opened === 0) {
                if (json.total_unseens > 0) {
                    if (audio_played == false) {
                       $.ionSound.play("event_beep.wav");
                       audio_played = true;
                    }
                    $('#events_image').attr('src','images/events/events_blink.gif');
                } else {
                    $('#events_image').attr('src','images/events/events_normal.png');
                }
            } else {
                 if (json.total_unseens > 0) {
                     if (audio_played == false) {
                        $.ionSound.play("event_beep.wav");
                        audio_played = true;
                    }    
                 }
                $('#events_image').attr('src','images/events/events_normal.png');
            }
            $('#div_events_listing').html($.base64Decode(json.table_events));
            
        });        
        
    }
    
    {literal}
    $(document).ready(function() {
       
       
       // Initialize sound sub-system
       $.ionSound( {
          
           sounds: [
               "event_beep.wav"
           ],
           path: "sounds/",
           multiPlay: false,
           volume: "0.5"
            
       });


       $("a[id^='events_panel_toggle']").click(function(event) {

            event.preventDefault();
            
            $('#events_image').attr('src','images/events/events_normal.png');

            audio_played = false;
            var newOpened = (opened===0?1:0);
            $.ajax({
                   url: 'events.php',
                   type: 'POST',
                   data: 'toggle=' + newOpened

               }).done(function(data) {

//                   var json = JSON.parse(data);
                   // TODO: Retrieve list of users
                   if (opened === 0) {
                        $('#div_events_listing').show();
                        $('#div_events').animate({
                           width:  "520px",
                           height: "220px"
                        }, 200, function() {
                        });
                   } else {
                        $('#div_events').animate({
                            width:  "100px",
                            height: "16px"
                        }, 200, function() {
                            $('#div_events_listing').hide();
                        });
                   }
                   opened = newOpened;

               }).fail(function(data) {
      //             alert('{t}Fatal error!{/t}');
               });
        
        });
        {/literal}
            
        setInterval('events_refresh()',6000);
        
    });


</script>


<div id="events_anchor">
    {if $events_opened eq 1}
    {if $alerts_opened eq 1}
<div id="div_events"  style="left:340px;height:220px;width:520px" class="ui-corner-top">
    {else}
    <div id="div_events"  style="left:110px;height:220px;width:520px" class="ui-corner-top">
    {/if}
    {if $table_events.total_unseens > 0}
    <div id="div_events_header"><a id="events_panel_toggle" href="#"><img src="images/events/events_blink.gif" id="events_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Events{/t}</a></div>
    {else}
    <div id="div_events_header"><a id="events_panel_toggle" href="#"><img src="images/events/events_normal.png" id="events_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Events{/t}</a></div>
    {/if}
    <div id="div_events_listing" class="ui-corner-all">
    {else}
        {if $alerts_opened eq 1}
<div id="div_events"  style="left:340px;height:16px" class="ui-corner-top">
    {else}
    <div id="div_events"  style="left:110px;height:16px" class="ui-corner-top">
    {/if}

    {if $table_events.total_unseens > 0}
    <div id="div_events_header"><a id="events_panel_toggle" href="#"><img src="images/events/events_blink.gif" id="events_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Events{/t}</a></div>
    {else}
    <div id="div_events_header"><a id="events_panel_toggle" href="#"><img src="images/events/events_normal.png" id="events_image" width="16" height="16"  style="vertical-align:text-bottom">&nbsp;{t}Events{/t}</a></div>
    {/if}
    <div id="div_events_listing" class="ui-corner-all" style="display:none">
    {/if}
    {$table_events.output}
    
    </div>
</div>
    </div>
    