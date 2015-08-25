<?php
require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");
$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("System Summary"));
$page->setMenu($MENU_ITEMS);

function displaySuperTable() {

    global $page, $TPL, $DB;


    require_once("includes/classes/SuperTable.php");


    $fields =
        [
            [
                "label" => T_("Who"),
                "column" => "field_who",
                "table" => [
                    "width" => "120px"
                ]

            ],

            [
                "label"=> T_("How"),
                "column" => "field_how",
                "table" => [
                    "width" => "120px"
                ]
            ],

            [
                "label"=> T_("What"),
                "column" => "field_what",
                "table" => [
                    "width" => "120px"
                ]
            ],
            [
                "label"=> T_("Reference"),
                "column" => "field_reference",
                "table" => [
                    "width" => "120px"
                ]
            ],

            [
                "label"=> T_("When"),
                "column" => "field_when",
                "table" => [
                    "width" => "120px"
                ]
            ],
        ];



    class MySuperTable extends SuperTable
    {



        public function callbackFilterRow($row) {
            if ($row["field_when"] > 0) {
                $row["field_when"] = date("m/d/Y", $row["field_when"]);
            }

            return $row;
        }



    }


    $buttons = [];
    //  $buttons[] = ["id" => "password_entry", "label" => "", "icon" => "key", "tooltip" => T_("Change Password"), "confirm" => false, "before" => true];



    $st = new MySuperTable("tb_activities");

    $st->setFields($fields);
    $st->SetSortedColumn("tb_activities.id", "DESC");
    $st->setActions(false, false, false, $buttons);
    $st->setSearchable(true);
    //$st->setFilter(T_("User Level"),"user_level",[["id"=>1,"name"=>T_("Normal")],["id"=>100,"name"=>T_("Staff")],["id"=>255,"name"=>T_("Administrator")]]);

// Generate graph data
    $graph_data = array();


    $days = 30;


    for ($i=1;$i<=$days;$i++) {

        $day = date("d") - $days + $i;
        $timestamp_start = mktime(0,0,0,date("m"),$day);
        $timestamp_stop = mktime(23,59,59,date("m"),$day);
        $timestamp_lastyear_start = mktime(0, 0, 0, date('Y')-1,$day);
        $timestamp_lastyear_stop = mktime(23, 59, 59,  date('Y')-1,$day);
        $total_login = 0;
        $total_lastyear_login = 0;

        $logins = $DB->select(
            "*",
            "tb_activities",
            array(
                array("field_when",">=",$timestamp_start),
                "AND",
                array("field_when","<=",$timestamp_stop)
            )
        );


        $lastyear_logins = $DB->select(
            "*",
            "tb_activities",
            array(
                array("field_when",">=",$timestamp_lastyear_start ),
                "AND",
                array("field_when","<=",$timestamp_lastyear_stop)
            )
        );


        foreach($logins as $login) {

            $total_login++;
        }

        foreach($lastyear_logins as $lastyear_login) {

            $total_lastyear_login++;
        }




        $graph_data[] = "['".date("d-M-y",$timestamp_start)."',".$total_login."]";
        $graph_data2[] = "['".date("d-M-y",$timestamp_start)."',".$total_lastyear_login."]";
    }

    $TPL->assign("graph_data",implode($graph_data, ","));
    $TPL->assign("graph_data2",implode($graph_data2, ","));
    $page->setContent($TPL->fetch("activity.tpl").$st->display());

    $page->show();




}


displaySuperTable();