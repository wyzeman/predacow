{include file="header.tpl"}
<link href="styles/side-menu.css" rel="stylesheet" type="text/css"/>


<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">{$website_name}</a>

            <ul class="pure-menu-list">

                {section name=m loop=$menu_items}
                {if $current_userlevel >= $menu_items[m].user_level}

                   {if $menu_position eq $smarty.section.m.index}
                       <li class="pure-menu-item menu-item-divided pure-menu-selected">
                   {else}
                       <li class="pure-menu-item menu-item-divided">
                   {/if}
                   <a class="pure-menu-link" href="{$menu_items[m].url}?initial">{$menu_items[m].label|stripslashes}</a>
                    </li>
                    {else}
                    <li class="pure-menu-item menu-item-divided">
                    <a href="{$menu_items[m].url}?initial"><img src="{$menu_items[m].img}" alt="{$menu_items[m].label}" title="{$menu_items[m].label}"></a>
                    </li>
                    {/if}
                    {/section}
            </ul>

        </div>
    </div>
    <div id="main">
        <div class="header">
            <h1>{$title|stripslashes}</h1>

            <h2>
            {if isset($menu_items[$menu_position].sub_items)}
            {section name=s loop=$menu_items[$menu_position].sub_items}
                {if $submenu_position eq $smarty.section.s.index}
                <a href="{$menu_items[$menu_position].sub_items[s].url|stripslashes}"><b>{$menu_items[$menu_position].sub_items[s].label|stripslashes}</b></a>
                {else}
                    <a href="{$menu_items[$menu_position].sub_items[s].url|stripslashes}">{$menu_items[$menu_position].sub_items[s].label|stripslashes}</a>
                {/if}
                {if $smarty.section.s.last eq false}
                &nbsp;|&nbsp;
                {/if}
            {/section}
            {/if}
            </h2>
        </div>
        <div class="content">
          {$content}
        </div>
    </div>
</div>




<script type="text/javascript" src="scripts/ui.js"></script>

{include file="footer.tpl"}
