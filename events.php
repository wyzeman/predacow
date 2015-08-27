<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");
//security_check(false, "index.php");

$user_id = $_SESSION[SI]["user"]["id"];

// Handle toggling
if ($INPUT->post->keyExists("toggle") == true) {
    $opened = $INPUT->post->getInt("toggle");
    $DB->update("tb_events", array("opened" => $opened,"timestamp"=>time()), array("id_user", "=",$user_id));
    
    die("SUCCESS");
}

// Handle refresh
if ($INPUT->post->keyExists("refresh") == true) {

    $output = array();
    $output["result"] = "SUCCESS";

    $timestamp = $DB->getScalar("timestamp","tb_events", array("id_user","=",$user_id));
    $opened = $DB->getScalar("opened","tb_events", array("id_user","=",$user_id));
    
    // Detect unseen entries
    $count_events = $DB->getCount("tb_events_logs", array("timestamp",">",$timestamp));
    
    $table = build_events_table();
    $output["total_unseens"] = $count_events;
    $output["table_events"] = base64_encode($table["output"]);
    
    if ($opened == 1) {
        $DB->update("tb_events", array("timestamp"=>time()), array("id_user","=", $user_id));
    }
    
    die(json_encode($output));
}


die("ERROR");



