<script type="text/javascript">
{literal}
 $(document).ready(function() {
 {/literal}

     $(".phonenumber").mask("(999) 999-9999");


    $('#form_{$form_id}').validate({
    rules: {
        password: {
            required: true,
            minlength: 5
        },
        password_again: {
            required: true,
            minlength: 5,
            equalTo: "#password"
        }

    },
        errorPlacement: function(error, element) {
            error.css('color', 'red');
            error.insertAfter(element);
        },
        wrapper: "div"


});

    var form_id = '{$form_id}';
  
{section name=b loop=$buttons}

    var id = '#form_' + form_id + '_{$buttons[b].name|stripslashes}';
    {literal}
    $(id).click(function(event) {
    {/literal}
        {if $buttons[b].type eq 0}
            {if $ajax_validation eq true}
            console.log('URL: {$form_url_ajax}');
        $.ajax( {
            type: "POST",
            url: '{$form_url_ajax}',
            data: $('#form_' + form_id).serialize()
        }).done(function(result) {

            var json = JSON.parse(result);
            if (json == null) {
                console.log(result);
            }
            if (json.result == false) {
                alert(json.error);
            } else {
                $('#form_' + form_id).submit();
            }
        });
            {else}
                $('#form_' + form_id).submit();
            {/if}
        {/if}
        {if $buttons[b].type eq 1}
           $('#form_' + form_id)[0].reset();
        {/if}
        {if $buttons[b].type eq 2}
            window.location = '{$buttons[b].url|stripslashes}';
        {/if}
        {if $buttons[b].type eq 4}
            {$buttons[b].url|stripslashes}(event);
        {/if}

        event.preventDefault();
        {literal}
    });

    {/literal}
{/section}

{literal}

 });
 {/literal}
</script>

<div style="text-align:left" class="ui-widget">
    {if strlen($form_title) == 0}
    {else}
    <div style="background-color:#1f8dd6;color:white;margin-top:0px;margin-bottom:15px;padding:10px"><b>{$form_title}</b></div>
    {/if}
    <form id="form_{$form_id}" method="{$form_method}" action="{$form_url}" autocomplete="off" enctype="multipart/form-data" class="pure-form pure-form-aligned">
        <fieldset>
            {section name=i loop=$items}
            {* Hidden *}
            {if $items[i].type eq 8}
            <input type="hidden" id="{$items[i].name}" name="{$items[i].name}" value="{$items[i].value}">
            {elseif $items[i].type eq 13}
                <div style="background-color:#6f6e6d;color:white;margin-top:30px;margin-bottom:15px;padding:10px">
                <b>{$items[i].label|stripslashes}</b>
                </div>

            {else}
                <div class="pure-control-group">
                {* Notice *}
                {if $items[i].type eq 7}
                <div class="ui-state-highlight ui-corner-all padding_10px margin_5px" {if isset($items[i].width)}style="width:{$items[i].width}"{/if}>
                    {$items[i].label|stripslashes}
                </div>
                {else}

                <label style="color:{$label_color};text-align:{$label_align};{if $label_width > 0}width:{$label_width};{/if}">
                {* Checkbox *}
                {if ($items[i].type eq 2)}
                {else}
                {* Label *}
                {if ($items[i].type eq 3)}
                    <br/>
               <b style="padding:5px;color:{$label_color}">{$items[i].label|stripslashes}</b>
               <br/>
                {else}{* Anything else *}
                    {if ($items[i].type eq 14)}
                    {else}

                {$items[i].label|stripslashes}&nbsp;
                        {/if}
                {/if}
                {/if}
                </label>

                    {* Input *}
                    {if $items[i].type eq 0}
                        <input type="text" name="{$items[i].name}" id="{$items[i].name}" placeholder="{$items[i].label|stripslashes}" value="{$items[i].value}" class="{$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">
                    {/if}

                    {* Input (Phone number) *}
                    {if $items[i].type eq 12}
                        <input type="text" name="{$items[i].name}" id="{$items[i].name}" placeholder="{$items[i].label|stripslashes}" value="{$items[i].value}" class="phonenumber {$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">

                    {/if}

                    {* Text Area *}
                    {if $items[i].type eq 1}
                    <textarea name="{$items[i].name}" id="{$items[i].name}" class="{$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">{$items[i].value}</textarea>
                    {/if}

                    {* Check Box *}
                    {if $items[i].type eq 2}
                            <input type="checkbox" name="{$items[i].name}" id="{$items[i].name}" {if $items[i].value eq true}checked{/if}> {$items[i].label|stripslashes}
                    {/if}

                    {* Label *}
                    {if $items[i].type eq 3}
                        {$items[i].value|stripslashes}
                    {/if}

                    {* Select *}
                    {if $items[i].type eq 4}
                    <select name="{$items[i].name}" id="{$items[i].name}" class="{$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">

                        {section name=l loop=$items[i].value}
                        <option value="{$items[i].value[l].id}" {$items[i].value[l].extra}>{$items[i].value[l].name|stripslashes}</option>
                        {sectionelse}
                        <option value="">{t}No value!{/t}</option>
                        {/section}

                    </select>
                    {/if}

                    {* Password *}
                    {if $items[i].type eq 5}
                        <input type="password" name="{$items[i].name}" id="password" placeholder="{$items[i].label|stripslashes}"  value="{$items[i].value}" class="input_text {$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">
                    </div>
                    <div class="pure-control-group">
                        <label style="color:{$label_color};text-align:{$label_align};{if $label_width > 0}width:{$label_width}{/if}">
                    {t}Password (Again){/t}</label>
                        <input type="password" name="{$items[i].name}_again" id="password_again" placeholder="{$items[i].label|stripslashes}"  value="{$items[i].value}" class="{$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">

                    {/if}

                    {* File *}
                    {if $items[i].type eq 9}
                        <input type="file" name="{$items[i].name}" id="{$items[i].name}" {if $items[i].value eq true}checked{/if} />
                    {/if}

                    {* Read-only *}
                    {if $items[i].type eq 6}
                          <span id="{$items[i].name}"><b>{$items[i].value}</b></span>
                    {/if}

                    {* Autocomplete *}
                    {if $items[i].type eq 10}
                        <input type="text" name="{$items[i].name}" id="{$items[i].name}" value="{$items[i].value.text}" class="ui-widget-content {$items[i].validation}" style="{if isset($items[i].width)}width:{$items[i].width};{/if}{if isset($items[i].height)}height:{$items[i].height};{/if}">
                        <script type="text/javascript"t>
                            $(function() {

                                $( "#{$items[i].name}" ).autocomplete({
                                    source: "?autocomplete={$items[i].name}",
                                    minLength: 2,
                                    select: function( event, ui ) {
                                    }
                                });

                            });
                        </script>
                    {/if}

                    {* Widget *}
                    {if $items[i].type eq 11}
                        <span>{$items[i].value}</span>
                    {/if}
                    {* Checkbox group *}
                    {if $items[i].type eq 14}
                        <div style="background-color:#6f6e6d;color:white;margin-top:30px;margin-bottom:15px;padding:10px">
                            <b>{$items[i].label|stripslashes}</b>
                        </div>

                        <span>
                            {section name=cb loop=$items[i].value}
                                <div style="display:inline-block;white-space: nowrap">
                                <input type="checkbox" name="{$items[i].value[cb].name}" id="{$items[i].value[cb].name}" {if $items[i].value[cb].value eq true}checked{/if}>
                                    {$items[i].value[cb].label|stripslashes}&nbsp;&nbsp;
                                </div>
                            {/section}

                        </span>
                    {/if}

                {/if}
                </div>
            {/if}
            {/section}


            {if count($buttons) > 0}
            <div class="pure-controls">
                    {section name=b loop=$buttons}
                    <button id="form_{$form_id}_{$buttons[b].name}" class="pure-button" style="border:1px solid #aaa;">{$buttons[b].label}</button>

                    {/section}
                    
            </div>

            {/if}


        </fieldset>
    </form>
</div>