<?php

require_once("includes/init.php");

if (isset($_SESSION[SI]["user"]["id"])) {
   $DB->logoff($_SESSION[SI]["user"]["id"]);
}

die_redirect("index.php");