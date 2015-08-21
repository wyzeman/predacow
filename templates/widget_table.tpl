<script type="text/javascript">

    $(document).on('mouseenter',".table_table_widget tr", function() {
        if ($(this).attr('orig_background') == null) {
            return;
        }
        $(this).css("background","rgb(200, 200, 200)");

    });
    $(document).on('mouseleave',".table_table_widget tr", function() {
        if ($(this).attr('orig_background') == null) {
            return;
        }
        $(this).css("background-color",$(this).attr('orig_background'));

    });

    $(function() {
                {literal}
                $('.table_table_widget').cardtable({myClass:'stacktable small-only' });
                {/literal}
    }
    )

</script>


<table class="table_table_widget pure-table pure-table-horizontal {$class}" cellspacing="2" cellpadding="3" border="0" width="100%">

    <thead>
    {section name=c loop=$columns}
    {if isset($columns[c].width)}
        <th nowrap  style="min-width:{$columns[c].width}">
    {else}
        <th nowrap style="text-align:left">
    {/if}

        {if $sortable eq false}
            {$columns[c].name|stripslashes}
        {else}
            {if $columns[c].db_name eq $order_by}
                {if $order_dir eq 'DESC'}
                <a href="?order_by={$columns[c].db_name}&order_dir=ASC">{$columns[c].name|stripslashes}</a>
                <img class="stacktable_img" src="images/dir_desc.png" border="0">
                </a>
                {else}
                <a href="?order_by={$columns[c].db_name}&order_dir=DESC">{$columns[c].name|stripslashes}</a>
                <img class="stacktable_img" src="images/dir_asc.png" border="0">
                {/if}

            {else}
            <a href="?order_by={$columns[c].db_name}&order_dir=DESC">{$columns[c].name|stripslashes}</a>
            {/if}

        {/if}

        </th>
    {/section}
    {if $show_actions}
        <th nowrap width="{$actions_width}" style="max-width:{$actions_width}">&nbsp;</th>
    {/if}
    </thead>
    <tbody>
    {section name=v loop=$values}

    {if (isset($values[v].background_color))}
    <tr style="background-color:{$values[v].background_color}" orig_background="{$values[v].background_color}">
    {else}
        <tr>
    {/if}

        {section name=vv loop=$values[v].data}

       {if $values[v].editable[vv] > 0}
        <td nowrap class="td_row_table_widget" align="left">
            <input type="text" id="editable_{$table_id}_{$smarty.section.vv.index}_{$values[v].id}" name="table_field_{$smarty.section.v.index}_{$smarty.section.vv.index}" class="ui-widget-content" style="width:98%;height:100%" value="{$values[v].data[vv]|stripslashes}">
        </td>
        {else}
        <td  class="td_row_table_widget" align="left">{$values[v].data[vv]}</td>
        {/if}
        {/section}

        
        {if $show_actions}
        <td  class="td_row_table_widget" valign="top" nowrap style="vertical-align:middle">

            
            {section name=bb loop=$buttons}
            {if $buttons[bb].label eq ''}

            {if $smarty.section.bb.index eq 0}
            {if isset($values[v].button1_label)}
                <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i>{$values[v].button1_label|stripslashes}</button>
                {else}
                <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i></button>
            {/if}
            {elseif $smarty.section.bb.index eq 1}
            {if isset($values[v].button2_label)}
            <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i>{$values[v].button2_label|stripslashes}</button>
            {else}
            <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i></button>
            {/if}
            {elseif $smarty.section.bb.index eq 2}
            {if isset($values[v].button3_label)}
            <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i>{$values[v].button3_label|stripslashes}</button>
            {else}
            <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i></button>
            {/if}
            {else}
            <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i></button>
            {/if}
            
            {else}
            <button id="button_{$buttons[bb].id}_{$table_id}_{$values[v].id}" title="{$buttons[bb].tooltip|stripslashes}" class="pure-button" style="border:1px solid #aaa;font-size:85%"><i class="fa fa-{$buttons[bb].icon}"></i>{$buttons[bb].label|stripslashes}</button>
            {/if}
            {/section}

        </td>
        
        {/if}
    </tr>

    {sectionelse}
    <tr class="tr_row_table_widget">
        <td colspan="10" style="color:black;padding:5px">{t}{$empty_message}{/t}</td>
    </tr>
    {/section}
    </tbody>

</table>


{if $current_page != -1}
        {if $total_pages > 0}
    <div align="right" style="padding:5px">
        
        <table border="0" cellspacing="3" cellpadding="0">
        <tr>
                
        {if $current_page > 1}
            <td style="padding-right:5px"><a href="?table_page=1"><img src="images/rewind.png" style="margin-top:2px" border="0"></a></td>
        <td style="padding-right:5px"><a href="?table_page={$current_page - 1}"><img src="images/previous.png" style="margin-top:2px" border="0"></a></td>
        {/if}
        <td><span style="color:#666;padding-left:5px;padding-right:5px"><b>{$current_page}</b> / <b>{$total_pages|ceil}</b></span></td>
        {if $current_page < $total_pages}
        <td style="padding-left:5px"><a href="?table_page={$current_page + 1}"><img src="images/next.png" style="margin-top:2px" border="0"></a></td>
        <td style="padding-left:5px"><a href="?table_page={$total_pages}"><img src="images/ff.png" style="margin-top:2px" border="0"></a></td>
        {/if}
        </tr>
        </table>
        
    </div>
            
        {/if}
    
{/if}