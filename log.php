<?php
require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");

$page = new CustomPage(UserLevel::ADMIN);
$page->setTitle(T_("User Manager"));
$page->setMenu($MENU_ITEMS);
$page->show();

