{include file="header.tpl"}

{literal}
<script type="text/javascript">


$(function(){

    $('#dialog_forgot_container').dialog({ autoOpen: false });
    $('#dialog_forgot_container').dialog( 'option', 'resizable', false );
    $('#dialog_forgot_container').dialog( 'option', 'modal', true );
    $('#dialog_forgot_container').dialog( 'option', 'width', 500 );


    // Focus username field
    $('#username').focus();

    // If someone press enter in username we focus on password field
    $('#username').keydown(function(event) {
        if (event.keyCode == '13') {
            event.preventDefault();
            $('#password').focus();
        }
    });


    $('#password').keydown(function(event) {
        if (event.keyCode == '13') {
            event.preventDefault();
            $('#button_login_continue').click();
        }
    });

    {/literal}

    {if isset($enable_forgot)}
    {literal}

    // Click callback on 'Continue' button of the forgot password dialog
    $('#button_forgot_continue').click(function() {
        var email_address = $('#email_address').val();

        // Show error dialog when email address field is empty!
        if (email_address == '') {

            {/literal}
            var dlgTitle = '{t}Unable to continue{/t}';
            var dlgContent = '{t}Your email address field is empty!{/t}';
            {literal}

            var newX = ($(window).width() - $('#dialog_container').width)/2;
            var newY = 180;
            $('#dialog_container').dialog('option', 'position', [newX,newY] );
            $('#dialog_container').dialog('option', 'title',dlgTitle);
            $('#dialog_content').html(dlgContent);
            $('#dialog_container').bind( "dialogclose", function(event, ui) {
                $('#email_address').focus();
            });
            $('#dialog_container').dialog('open');
            return;

        }

        {/literal}
        var current_script = '{$current_script}';
        var ajaxData = 'email_address='+email_address;
        {literal}

        // Hide button
        $('#span_forgot_continue').addClass('ui-helper-hidden');
        $('#span_forgot_pleasewait').removeClass('ui-helper-hidden');
        // AJAX submission of username and password
        $.ajax({ url: current_script, type:'POST', data: ajaxData, success: function(result){

            $('#span_forgot_continue').removeClass('ui-helper-hidden');
            $('#span_forgot_pleasewait').addClass('ui-helper-hidden');

            if (result != 'TRUE') {
                {/literal}
                var dlgTitle = '{t}Unable to continue{/t}';
                var dlgContent = '{t}Unable to send a email to this address (' + result + '){/t}';
                {literal}

                var newX = ($(window).width() - $('#dialog_container').width)/2;
                var newY = 180;
                $('#dialog_container').dialog('option', 'position', [newX,newY] );
                $('#dialog_container').dialog('option', 'title',dlgTitle);
                $('#dialog_content').html(dlgContent);
                $('#dialog_container').bind( "dialogclose", function(event, ui) {
                    $('#password').focus();
                });
                $('#dialog_container').dialog('open');
                return;
            } else {
                {/literal}
                var dlgTitle = '{t}Operation completed{/t}';
                var dlgContent = '{t}A email containing your new password was succesfully sent.{/t}';
                {literal}


                var newX = ($(window).width() - $('#dialog_container').width)/2;
                var newY = 180;

                $('#dialog_container').dialog('option', 'position', [newX,newY] );
                $('#dialog_container').dialog('option', 'title',dlgTitle);
                $('#dialog_content').html(dlgContent);


                $('#dialog_forgot_container').dialog('close');
                $('#dialog_container').dialog('open');

                return;
            }
        }});


    });


    // Click callback on 'Forgot password' link
    $('#link_login_forgot').click(function(evt) {

        evt.preventDefault();

        var newX = ($(window).width() - $('#dialog_forgot_container').width)/2;
        var newY = 180;
        $('#dialog_forgot_container').dialog('option', 'position', [newX,newY] );
        $('#dialog_forgot_container').dialog('open');
        $('#email_address').val('');
        $('#email_address').focus();
        $('#email_address').keydown(function(event) {
            if (event.keyCode == '13') {
                event.preventDefault();
                $('#button_forgot_continue').click();
            }
        });
        return;
    });

    {/literal}
    {/if}

    {if isset($enable_register)}
    var register_url='{$register_url}';
    // Click callback on 'Forgot password' link
    $('#button_login_register').click(function() {
        window.location=register_url;
        return;
    });
    {/if}

    {literal}

    // Click callback on 'Continue' button of the main login form
    $('#button_login_continue').click(function(evt) {


        evt.preventDefault();

        // Login using ajax
        var username = $('#username').val();
        var password = $('#password').val();

        // Show error dialog when username field is empty!
        if (username == '') {

            {/literal}
            var dlgTitle = '{t}Unable to perform a login{/t}';
            var dlgContent = '{t}Your username field is empty!{/t}';
            {literal}

            var newX = ($(window).width() - $('#dialog_container').width)/2;
            var newY = 180;
            $('#dialog_container').dialog('option', 'position', [newX,newY] );
            $('#dialog_container').dialog('option', 'title',dlgTitle);
            $('#dialog_content').html(dlgContent);
            $('#dialog_container').bind( "dialogclose", function(event, ui) {
                $('#username').focus();
            });
            $('#dialog_container').dialog('open');
            return;
        }

        // Show error dialog when password field is empty!
        if (password == '') {

            {/literal}
            var dlgTitle = '{t}Unable to perform a login{/t}';
            var dlgContent = '{t}Your password field is empty!{/t}';
            {literal}

            var newX = ($(window).width() - $('#dialog_container').width)/2;
            var newY = 180;
            $('#dialog_container').dialog('option', 'position', [newX,newY] );
            $('#dialog_container').dialog('option', 'title',dlgTitle);
            $('#dialog_content').html(dlgContent);
            $('#dialog_container').bind( "dialogclose", function(event, ui) {
                $('#password').focus();
            });
            $('#dialog_container').dialog('open');
            return;
        }

        {/literal}
        var current_script = '{$current_script}';
        var ajaxData = 'username='+username+'&password='+password;
        {literal}


        // AJAX submission of username and password
        $.ajax({ url: current_script, type:'POST', data: ajaxData, success: function(result){


            if (result != 'TRUE') {
                {/literal}
                var dlgTitle = '{t}Unable to perform a login{/t}';
                var dlgContent = '{t}The username and password entered are not matching any entry in our database!{/t}';
                {literal}

                var newX = ($(window).width() - $('#dialog_container').width)/2;
                var newY = 180;
                $('#dialog_container').dialog('option', 'position', [newX,newY] );
                $('#dialog_container').dialog('option', 'title',dlgTitle);
                $('#dialog_content').html(dlgContent);
                $('#dialog_container').bind( "dialogclose", function(event, ui) {
                    $('#password').focus();
                });
                $('#dialog_container').dialog('open');
                return;
            } else {
                {/literal}
                window.location = '{$complete_url}';
                {literal}
            }
        }});

    });


});

</script>
{/literal}



<div id="dialog_forgot_container" title="{t}Forgot Password Reminder{/t}" class="login_content ui-helper-hidden">
    <form class="pure-form pure-forma-ligned" method="post">
        <fieldset>
            <div class="pure-control-group">
                <div class="ui-state-highlight">{t}A new password will be generated and the details will be sent to you through your email address.{/t}</div>
            </div>
            <div class="pure-control-group">
                <label for="forgot_email_address">{t}Email Address{/t}</label>
                <input id="forgot_email_address" type="text" placeholder="{t}Email Address{/t}" name="forgot_email_address" required>
            </div>
            <div class="pure-controls">
                <span id="span_forgot_continue"><button type="button" id="button_forgot_continue" class="pure-button pure-button-primary">{t}Continue{/t}</button></span>
                <span id="span_forgot_pleasewait" class="ui-helper-hidden"><div class="padding_5px">{t}Please wait... {/t}<img src="images/ajax-loader.gif"></div></span>
            </div>
        </fieldset>
    </form>
</div>

<div class="login_content">
    <img src="images/logo.png" class="pure-img" style="padding-bottom:20px">

    <form class="pure-form pure-form-aligned" method="post">
        <fieldset>
            <div class="pure-control-group">
                <label for="username">{t}Username{/t}</label>
                <input id="username" type="text" placeholder="{t}Username{/t}" name="username" required>
            </div>

            <div class="pure-control-group">
                <label for="password">{t}Password{/t}</label>
                <input id="password" type="password" name="password" placeholder="{t}Password{/t}" required>
            </div>

            <div class="pure-controls">
                {if isset($enable_register)}
                    <label for="link_login_register" class="pure-checkbox">
                        <a href="#" id="button_login_register" class="pure-">{t}Register Account{/t}</a>
                    </label>
                {/if}
                {if isset($enable_forgot)}
                    <label for="link_login_forgot" class="pure-checkbox">
                        <a href="#" id="link_login_forgot" class="pure-">{t}I forgot my password{/t}</a>
                    </label>
                {/if}
                <button type="submit" id="button_login_continue" class="pure-button pure-button-primary">{t}Continue{/t}</button>
            </div>
        </fieldset>
    </form>

</div>

{include file="footer.tpl"}