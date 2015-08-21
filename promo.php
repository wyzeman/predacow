<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");

$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("Promo Codes"));
$page->setMenu($MENU_ITEMS);
$page->show();