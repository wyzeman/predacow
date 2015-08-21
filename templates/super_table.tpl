<script type="text/javascript">

    $(document).ready(function() {
        $('#tabs_{$uniqid}').tabs();


        {section name=cb loop=$callbacks}

        $(document).on('click', "button[id^='button_{$callbacks[cb].id}_supertable_']", function(evt) {

            evt.preventDefault();

            var v = $(this).attr('id').split('_');
            var id = v[v.length-1];

            {if isset($callbacks[cb].confirm) && ($callbacks[cb].confirm eq true)}
            if (confirm('{t}Are you sure?{/t}')) {

                {if isset($callbacks[cb].javascript)}
                    {$callbacks[cb].javascript}
                {else}
                    window.location = '?{$callbacks[cb].id}=' + id;
                {/if}
            }
            {else}
                {if isset($callbacks[cb].javascript)}
                    {$callbacks[cb].javascript}
                {else}
                    window.location = '?{$callbacks[cb].id}=' + id;
                {/if}
            {/if}


        });

        {/section}

    });


</script>

{$payload}

<div id="tabs_{$uniqid}">

    <ul>
        <li><a href="#tabs_{$uniqid}_table">{t}{$labels.title_table|stripslashes}{/t}</a></li>

        {if $action_add eq true}
        <li><a href="#tabs_{$uniqid}_add">{t}{$labels.title_add|stripslashes}{/t}</a></li>
        {/if}
    </ul>

    <div id="tabs_{$uniqid}_table">

        {if isset($filter) || ($searchable eq true) }
        <div class="pure-g">
        {if isset($filter)}

                <div class="pure-u-1-3" align="left">
                    <div style="margin-top:10px" class="pure-form">{$filter.name}:
                    <select style="width:220px" onchange="window.location='?filter='+this.value">
                        <option value="-1">---</option>
                        {section name=f loop=$filter.source}
                            <option value="{$filter.source[f].id}" {$filter.source[f].extra}>{$filter.source[f].name|stripslashes}</option>
                        {/section}
                    </select></div>
                </div>

        {/if}

        {if $searchable eq true}


            {if (isset($filter)) }
                <div class="pure-u-1-3" align="left">
            {else}
                <div class="pure-u-2-3" align="left">
            {/if}
                    {if strlen($search_keywords) > 0}
                    <div style="margin-top:20px">Search result: <b>{$count_total|number_format} {t}item(s){/t}</b> with keyword(s): <b>{$search_keywords}</b>&nbsp;<a href="?search="><img style="vertical-align: middle" src="images/reset.png"></a></div>
                    {/if}
                </div>
                <div class="pure-u-1-3" align="right">
            <form class="pure-form">
                <fieldset>
                <input type="text" id="search_text" name="search" placeholder="{t}Search{/t}">
                </fieldset>
            </form>
                </div>

        {/if}
            {/if}
        </div>
        {$table}
    </div>

    {if $action_add eq true}
    <div id="tabs_{$uniqid}_add">
        {$form_add}
    </div>
    {/if}
</div>
