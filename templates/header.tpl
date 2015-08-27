<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>{$website_name|stripslashes}</title>
    <meta name="google" value="notranslate" />
    <meta charset="utf-8">
    <link href="styles/pure/pure-min.css" rel="stylesheet" type="text/css"/>
    <link href="styles/fa/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="styles/webchat.css" rel="stylesheet" type="text/css"/>
    <link href="styles/events.css" rel="stylesheet" type="text/css"/>
    <link href="styles/alerts.css" rel="stylesheet" type="text/css"/>
    <link href="scripts/jquery/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="styles/stacktable/stacktable.css" rel="stylesheet" type="text/css"/>
    <link href="scripts/jquery_notification/notification.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="scripts/jquery/external/jquery/jquery.js"></script>
    <script type="text/javascript" src="scripts/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="styles/stacktable/stacktable.js"></script>
    <script type="text/javascript" src="scripts/jquery_validate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="scripts/jquery_notification/jquery.notification.js"></script>
    <script type="text/javascript" src="scripts/jquery.maskedinput.min.js"></script>

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="styles/website-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="styles/website.css">
    <!--<![endif]-->

    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <![endif]-->


    <script type="text/javascript">


        $(function(){

            $('#dialog_container').dialog({ autoOpen: false });
            $('#dialog_container').dialog( 'option', 'resizable', false );
            $('#dialog_container').dialog( 'option', 'modal', true );
            $('#dialog_container').dialog( "option", "buttons", { "OK": function() { $(this).dialog("close"); } } );
            $('#dialog_container').dialog( 'option', 'width', 400 );

            {if isset($notice) }

            $.createNotification({ content: "{$notice|stripslashes}" })

            {/if}
            {if isset($warning) }

            $.createWarning({ content: "{$warning|stripslashes}" })

            {/if}



        });
    </script>

</head>

<body>



<div id="dialog_container" title="Undefined" class="ui-helper-hidden">
    <p id="dialog_content">Undefined</p>
</div>
