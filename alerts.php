<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");
//security_check(false, "index.php");

// Handle toggling
if ($INPUT->post->keyExists("toggle") == true) {

    $opened = $INPUT->post->getInt("toggle");
    $_SESSION[SESSION_IDENTIFIER]["alerts_opened"] = $opened;
    die("SUCCESS");
}

// Handle refresh
if ($INPUT->post->keyExists("refresh") == true) {

    $output = array();
    $output["result"] = "SUCCESS";

    $timestamp = $DB->getScalar("timestamp","tb_events", array("user_id","=",$user_id));
    $opened = $DB->getScalar("opened","tb_events", array("user_id","=",$user_id));


    $table = build_alerts_table();
    $output["total_unseens"] = $table["total_unseens"];
    $output["table_alerts"] = base64_encode($table["output"]);

    if ($opened == 1) {
        $DB->update("tb_events", array("timestamp"=>time()), array("user_id","=", $user_id));
    }

    die(json_encode($output));
}


die("ERROR");



