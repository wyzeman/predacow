<?php

function build_events_table($timestamp = null) {

    global $DB;

    $output = "<table id=\"table_events\" style=\"color:#9CF\" cellspacing=0 cellpadding=0>";
    $output .= "<th><tr style=\"background-color:#369\"><td nowrap style=\"padding:5px\"><b>".T_("Time")."</b></td><td nowrap style=\"padding:5px\"><b>".T_("Type")."</b></td><td width=\"100%\" style=\"padding:5px\"><b>".T_("Description")."</b></td></tr></th>";
    
    if ($timestamp != null) {
        
        $items = $DB->select("*","tb_events_logs", array("timestamp",">", $timestamp), array("id DESC"));

        } else {
       
        $items = $DB->select("*","tb_events_logs", array("timestamp",">", time()-(60*60*24)), array("id DESC"));
    }

    
    $count = 0;
    foreach($items as $item) {
        
        $type = "images/events/normal.png";
        if ($item["event_type"] == Database::$EVENT_WARNING) {
            $type = "images/events/warning.png";
        } else if ($item["event_type"] == Database::$EVENT_IMPORTANT)  {
            $type = "images/events/important.png";
        } else if ($item["event_type"] == Database::$EVENT_MOBILE)  {
            $type = "images/events/mobile.png";
        }
        
        if ($count++ % 2 == 0) {
            $output .= "<tr style=\"background-color:#fff\">";
        } else {
            $output .= "<tr style=\"background-color:#eee\">";
            
        }
        $output .= "<td style=\"color:black;width:55px;padding:2px;vertical-align:top\" nowrap>".date("H:i:s", $item["timestamp"])."</td>";
        $output .= "<td style=\"color:black;width:40px;padding:2px;vertical-align:top\" align=\"center\" nowrap><img src=\"".$type."\"></td>";
        $output .= "<td style=\"color:black;padding:5px;vertical-align:top\">".$item["description"]."</td>";
        $output .= "</tr>";
    }
    
    $output .= "</table>";
    
    $total_unseens = 0;
    
    return array("output"=>$output,"total_unseens"=>$total_unseens);
}
// Handle events
$events_opened = $DB->getScalar("opened", "tb_events", array("id_user", "=", $_SESSION[SI]["user"]["id"]));

if ($events_opened == null) {
    $events_opened = 0;
    $DB->insert("tb_events", array("opened" => 0, "id_user" => $_SESSION[SI]["user"]["id"]));
}


$time_expiration = time() - CONFIG_SESSION_IDLE_TIME;
$TPL->assign("events_opened", $events_opened);
$TPL->assign("table_events", build_events_table());

if ($events_opened == 1) {
    $DB->update("tb_events", array("timestamp"=>time()), array("id_user","=", $_SESSION[SI]["user"]["id"]));
}
