

<!-- Fix for IE outlines on A HREF -->
{literal}
    <script type="text/javascript">

        if (document.getElementById('nav') != null) {
            var links = document.getElementById('nav').getElementsByTagName('a');
            for ( var i = 0; i < links.length; i++ ) {
                links[i].onmousedown = function () {
                    this.blur();
                    return false;
                }
                links[i].onclick = function() {
                    this.blur();
                }
                if ( /msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent) ) {
                    links[i].onfocus = function() {
                        this.blur();
                    }
                }
            }
        }
    </script>
{/literal}

<div class="footer">
        &copy; {t}2015 All Rights Reserved{/t} <a href="#" class="link_light">Publirama Inc.</a>&nbsp;
        {section name=l loop=$languages}
            <a href="?LANG={$languages[l].gettext}"><img src="images/languages/{$languages[l].name}.png" alt="{$languages[l].name}" title="{$languages[l].name}"></a>
        {/section}

</div>
</body>
</html>