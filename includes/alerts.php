<?php

function build_alerts_table()
{

    global $DB;

    $expired_tasks = array();
   /* $expired_tasks = $DB->select("*", "tb_tasks", array(array("deleted", "=", 0),
        "AND",
        array("expired","=",1),
        "AND",
        array("user_id_completedby","=",-1)
    ));*/

    $total_unseens = count($expired_tasks);

    $output = "<table id=\"table_alerts\" style=\"color:#fff\" cellspacing=0 cellpadding=0>";
    $output .= "<th><tr style=\"background-color:#600\"><td width=\"160\" style=\"padding:5px\"><b>".T_("Task")."</b></td><td width=\"150\" nowrap><b>".T_("Elapsed Time")."</b></td></tr></th>";



    $count = 0;
    foreach($expired_tasks as $item) {

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
        $output .= "<td style=\"color:black;padding:5px;vertical-align:top\"><a style=\"color:black\" href=\"tasks.php?information=".$item["id"]."\">".T_("Task")." #".$item["id"]."</a></td>";
        $output .= "<td style=\"color:black;padding:5px;vertical-align:top\">".elapsed_time(time() - $item["timestamp_created"])."</td>";
        $output .= "</tr>";
    }

    $output .= "</table>";

    return array("output"=>$output,"total_unseens"=>$total_unseens);
}

if (isset($_SESSION[SI]["alerts_opened"]) == false) {
    $_SESSION[SI]["alerts_opened"] = false;
}


$time_expiration = time() - CONFIG_SESSION_IDLE_TIME;
if ($_SESSION[SI]["alerts_opened"] == false) {
    $TPL->assign("alerts_opened", 0);
} else {
    $TPL->assign("alerts_opened", 1);
}
$TPL->assign("table_alerts", build_alerts_table());

