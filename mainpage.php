<?php
require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");
require_once("includes/classes/widgets/FormWidget.php");
$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("System Summary"));
$page->setMenu($MENU_ITEMS);
/*echo "<pre>";
print_r($_SESSION);
die();*/
$user_stat = $DB->getCount("tb_users");
$group_stat = $DB->getCount("tb_groups");
$user_connect_stat = $DB->getCount("tb_sessions");

$items = array(
    array("width" => "100px", "name" => "user", "label" => T_("Users"), "value" => $user_stat, "type" => FormWidget::FORM_ITEM_READONLY, "validation" => "", "width" => "240px"),
    array("width" => "100px", "name" => "group", "label" => T_("Groups"), "value" => $group_stat, "type" => FormWidget::FORM_ITEM_READONLY, "validation" => "", "width" => "140px"),
    array("width" => "100px", "name" => "user_connected", "label" => T_("Users Connected"), "value" => $user_connect_stat, "type" => FormWidget::FORM_ITEM_READONLY, "validation" => "", "width" => "240px"),
);

$buttons = array(

);

$form = new FormWidget("", "#0", FormWidget::FORM_METHOD_POST, "160px", "right", "#333");
$TPL->assign("form", $form->generate($items, $buttons));


$user_connect_pcent = ($user_connect_stat / $user_stat) * 100;
$user_pcent = 100 - $user_connect_pcent;


$graph_data[] = "['Users connected',".$user_connect_pcent."]";
$graph_data[] = "['Total users',".$user_pcent."]";


$TPL->assign("graph_data",implode($graph_data, ","));

$content_data = $TPL->fetch("mainpage.tpl");
$page->setContent($content_data);

$page->show();