<?php

// Login page
require_once("includes/init.php");

require_once("includes/classes/pages/LoginPage.php");
$login = new LoginPage();
$login->show(false,false);
