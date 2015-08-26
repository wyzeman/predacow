<!-- webchat code go here -->
<script src="scripts/jquery.base64.js" type="text/javascript"></script>
<script src="scripts/ion.sound.js" type="text/javascript"></script>
<script type="text/javascript">

    var opened = {$webchat_opened};
    var previous_lengths = {};
    var previous_scrolls = {};
    var alreadyShaking = false;
    
    {literal}
    
    
    function webchat_refresh() {

      $.ajax({
            url: 'webchat.php',
            type: 'POST',
            data: 'refresh=1'
        }).done(function(data) {
            
            var json = JSON.parse(data);
            var decoded = $.base64Decode(json.table_webchat);
            
            if (json.total_unseens > 0) {
                console.log($('#webchat_image'));
                $('#webchat_image').attr('src','images/webchat/chat_blink.gif');
            } else {
                $('#webchat_image').attr('src','images/webchat/chat_normal.png');
                
            }
            
            $('#div_webchat_listing').html($.base64Decode(json.table_webchat));
            $('#webchat_users_count').html(json.users_connected);
            
            var createCount = 0;
            for (var  i=0;i<json.chatrooms.length;i++) {
                var chatroom_id = json.chatrooms[i].chatroom_id;
                var name = json.chatrooms[i].name;
                var content = json.chatrooms[i].content;
                var count = json.chatrooms[i].count;
                
                if(document.getElementById("window_chatroom_" + chatroom_id) !== null) {
                    
                    update_message_dialog(chatroom_id, content, count, i);
                } else {
                    
                    createCount++;
                    
                    // create
                    var dlg = build_message_dialog(chatroom_id, name, content, i,0);
                    var s = $('#span_webchat_messages');
                    s.html(s.html() + dlg);
                      $('#window_chatroom_'+chatroom_id).animate({opacity: 1}, 200, function() {
                          
                           setTimeout(function() {

                            // Scroll down
                            var tag = '#div_content_chatroom_' + chatroom_id;
                            var elem = $(tag);
                            elem.scrollTop(elem.prop('scrollHeight'));
                            
                        }, 50);
                          
                    });
                    
                }
            }
            
            if (createCount >= 0) {
                // We have to reset all scrollbars because when we create a new dialog we reset the html 
                // of all other dialogs.
                
                for (var m in previous_scrolls) {
                    var tag = '#div_content_chatroom_' + m;
                    var elem = $(tag);
                    elem.scrollTop(elem.prop('scrollHeight'));
                }
                
            }
            
        });        
        
    }
    
    function update_message_dialog(chatroom_id, content, count, pos) {
        
        var dlg = $('#window_chatroom_' + chatroom_id);

        if (dlg.css('right') != 'auto') {

            var rightOffset = 240 + ((pos % 4) * 240);
            var bottomOffset = 5 + (260 * Math.floor(pos / 4));

            var r = parseInt(dlg.css('right'),10);
            var b = parseInt(dlg.css('bottom'),10);

            var rightDiff = Math.abs(r - rightOffset);
            var bottomDiff = Math.abs(b - bottomOffset);

            // We do this to take in account the shake event

            if ((rightDiff >= 20) || (bottomDiff >=20)) {
                dlg.animate({
                   right: rightOffset ,
                   bottom: bottomOffset
                }, 500, function() {} );
            }
        }
        
        var c = $('#div_content_chatroom_' + chatroom_id);
        if (previous_lengths[chatroom_id] !== count) {
            
            if (previous_lengths[chatroom_id] != -1) {
                $.ionSound.play("chat_beep.wav");
            }
            previous_lengths[chatroom_id] = count;
            c.scrollTop(c.prop('scrollHeight'));
            previous_scrolls[chatroom_id] = c.scrollTop();
            
            
        }
        c.html(content);
        
    }
    
    
    function build_message_dialog(chatroom_id,name,content, pos, opacity) {
        
            var rightOffset = 240 + ((pos % 4) * 240);
            var bottomOffset = 5 + (260 * Math.floor(pos / 4));

            var img = 'person_white.png';
            var className = 'div_chat_message';
            if (chatroom_id < 0) {
                img = 'room_white.png';
                className = 'div_chat_room_message';
            }
            
            var dlg = '<div id="window_chatroom_'+chatroom_id+'" class="' + className +' ui-corner-top" style="opacity:'+opacity+';right:' +  rightOffset + 'px;bottom:' + bottomOffset + 'px">';
            dlg += '<div class="div_chat_message_header"><table border="0" style="border-spacing:0px">';
            dlg += '<tr>';
            dlg += '<td><img src="images/webchat/' + img + '" style="padding-right:5px;padding-top:0px"></td>';
            dlg += '<td width="100%" style="vertical-align:middle">' + name + '</td>';
            dlg += '<td><a id="webchat_close_message_' + chatroom_id+ '" href=""><img src="images/webchat/close.png" style="padding-top:1px" /></a></td>';
            dlg += '</tr></table></div>';
            dlg += '<div class="div_chat_message_content" id="div_content_chatroom_' + chatroom_id + '">' + content + '</div>';
            dlg += '<input type="text" class="div_chat_message_input" id="input_chatroom_' + chatroom_id+'">';
            dlg += '</div>';
            
            return dlg;
    }
    
    ////////////////////////
    
    $(document).ready(function() {
       
       
       // Initialize sound sub-system
       $.ionSound( {
          
           sounds: [
               "chat_beep.wav"
           ],
           path: "sounds/",
           multiPlay: false,
           volume: "0.3"
            
       });
       
       
       $("a[id^='webchat_panel_toggle']").click(function(event) {

            event.preventDefault();

            var newOpened = (opened===0?1:0);

            $.ajax({
                   url: 'webchat.php',
                   type: 'POST',
                   data: 'toggle=' + newOpened

               }).done(function(data) {

//                   var json = JSON.parse(data);
                   // TODO: Retrieve list of users
                   if (opened === 0) {
                        $('#div_webchat_listing').show();
                        $('#div_webchat').animate({
                           height: "440px"
                        }, 200, function() {
                        });
                   } else {
                        $('#div_webchat').animate({
                           height: "16px"
                        }, 200, function() {
                            $('#div_webchat_listing').hide();
                        });
                   }
                   opened = newOpened;

               }).fail(function(data) {
      //             alert('{t}Fatal error!{/t}');
               });
        
        });

        $(document).on('keypress',"input[id^='input_chatroom_']", function(event) {
            if (event.which === 13) {
                event.preventDefault();
                var field = $('#' + event.target.id);
                var v = field.attr('id').split('_');
             
                $.ajax({
                    url: 'webchat.php',
                    type: 'POST',
                    data: 'send_chatroom=' + v[2] + '&message=' + field.val()
                    
                }).done(function(data) {
                    webchat_refresh();                
                });
                
                field.val('');
            }
        });
            
        $(document).on('click',"a[id^='webchat_close_message_']", function(event) {

            event.preventDefault();
            
            var v = $(this).attr('id').split('_');
             $.ajax({
                url: 'webchat.php',
                type: 'POST',
                data: 'close_chatroom=' + v[3]
             }).done(function(data) {
                 
                 
            $('#window_chatroom_'+v[3]).animate({opacity: 0}, 100, function() {

                $('#window_chatroom_'+v[3]).remove();
                previous_lengths[v[3]] = -1;
                webchat_refresh();
                
            });

            });
        });
        
        
        $(document).on('click',"a[id^='button_chatroom_']", function(event) {

            event.preventDefault();

            var v = $(this).attr('id').split('_');
            
            if(document.getElementById("window_chatroom_" + v[2]) !== null) {
                alert("WTF");
                if (alreadyShaking == false) {
                    alreadyShaking = true;
                    $("#window_chatroom_" + v[2]).effect('shake',{distance:5}, 50, function() {
                        alreadyShaking = false;
                        var c = $('#div_content_chatroom_' + v[2]);                        
                        c.scrollTop(c.prop('scrollHeight'));
                         previous_scrolls[v[2]] = c.scrollTop();
                    });
                }
                return;
            }

            previous_lengths[v[2]] = -1;
            
            var real_name = $(this).attr('username');
             $.ajax({
                url: 'webchat.php',
                type: 'POST',
                data: 'open_chatroom=' + v[2] + '&real_name=' + real_name
                
             }).done(function(data) {
                alert(data);
                if (data == 'ERROR') {
                    {/literal}
                    alert('{t}Unable to open this chat room!{/t}');
                    {literal}
                } else {
                    webchat_refresh();
                }

            });
        
        
        });

         setInterval('webchat_refresh()',6000);
         
        var s = $('#span_webchat_messages');
        
       {/literal}
        {section name=c loop=$chatrooms}
 
            previous_lengths[{$chatrooms[c].chatroom_id}] = {$chatrooms[c].count};
            var dlg = build_message_dialog({$chatrooms[c].chatroom_id},'{$chatrooms[c].name}','{$chatrooms[c].content}', {$smarty.section.c.index},1);
            s.html(s.html() + dlg);
            
            setTimeout(function() {
                
            // Scroll down
            var tag = '#div_content_chatroom_' + {$chatrooms[c].chatroom_id};
            var elem = $(tag);
            elem.scrollTop(elem.prop('scrollHeight'));
            }, 50);
        
        {/section}
        {literal}
        
    });
    
    
    
        {/literal}

</script>

<div id="webchat_anchor">
    {if $webchat_opened eq 1}
<div id="div_webchat"  style="height:440px" class="ui-corner-top">
    {if $table_webchat.total_unseens > 0}
    <div id="div_webchat_header"><a id="webchat_panel_toggle" href="#"><img src="images/webchat/chat_blink.gif" id="webchat_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Online Chat{/t} (<span id="webchat_users_count">{$users_connected}</span>)</a></div>
    {else}
    <div id="div_webchat_header"><a id="webchat_panel_toggle" href="#"><img src="images/webchat/chat_normal.png" id="webchat_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Online Chat{/t} (<span id="webchat_users_count">{$users_connected}</span>)</a></div>
    {/if}
    <div id="div_webchat_listing" class="ui-corner-all">
    {else}
<div id="div_webchat"  style="height:16px" class="ui-corner-top">
    {if $table_webchat.total_unseens > 0}
    <div id="div_webchat_header"><a id="webchat_panel_toggle" href="#"><img src="images/webchat/chat_blink.gif" id="webchat_image" width="16" height="16" style="vertical-align:text-bottom">&nbsp;{t}Online Chat{/t} (<span id="webchat_users_count">{$users_connected}</span>)</a></div>
    {else}
    <div id="div_webchat_header"><a id="webchat_panel_toggle" href="#"><img src="images/webchat/chat_normal.png" id="webchat_image" width="16" height="16"  style="vertical-align:text-bottom">&nbsp;{t}Online Chat{/t} (<span id="webchat_users_count">{$users_connected}</span>)</a></div>
    {/if}
    <div id="div_webchat_listing" class="ui-corner-all" style="display:none">
    {/if}
    
    {$table_webchat.output}
    
    </div>
</div>
        <span id="span_webchat_messages"></span>
    </div>
