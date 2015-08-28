<?php

require_once("includes/init.php");

if (isset($_SESSION[SI]["user"]["id"])) {
   //create the events
   $DB->insert(
       "tb_events_logs",
       array(
           "id_user" => $_SESSION[SI]["user"]["id"],
           "timestamp" => time(),
           "event_type" => 0,
           "description" => $_SESSION[SI]["user"]["username"]." has left the building."
       )
   );


   $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_LOGOUT,"");

   $DB->logoff($_SESSION[SI]["user"]["id"]);
}

die_redirect("index.php");