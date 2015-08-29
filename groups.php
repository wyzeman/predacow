<?php
require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");
$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("Groups Management"));
$page->setMenu($MENU_ITEMS);


/**
 *
 */
function displaySuperTable() {

    global $page, $DB;

    require_once("includes/classes/SuperTable.php");


    $groups[] = ["id"=>-1,"name"=>T_("---")];

    $tmp_groups = $DB->select("*","tb_groups");

    $parent_groups = array();

    for ($i=0;$i<count($tmp_groups);$i++) {

        $groups[] = $tmp_groups[$i];

        $is_parent = $DB->getCount("tb_groups",array("id","=",$tmp_groups[$i]["parent_group"]));

        if ($is_parent > 0) {

            $new_groups = $DB->select("*","tb_groups",array("id","=",$tmp_groups[$i]["parent_group"]));
            $parent_groups[] = $new_groups[0];
        }
    }






    $fields =
        [
            [
                "label" => T_("Group name"),
                "column" => "name",
                "table" => [
                    "width" => "120px"
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => ""
                ]
            ],
            [
                "label" => T_("Sub group of"),
                "column" => "parent_group",
                "table" => [
                    "width" => "120px"
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_SELECT,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => [
                        "source" =>
                            $groups,
                        "selection" => 0
                    ]
                ]
            ],
            [
                "label" => T_("Active"),
                "column" => "active",
                "table" => [
                    "width" => "120px",
                    "replace" => [
                        0 => '<span style="color:red">'.T_("No").'</span>',
                        1 => '<span style="color:green">'.T_("Yes").'</span>'
                    ]
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKBOX,
                    "width" => "400px",
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "value" => true
                ]

            ],




            [
                "label" => T_("Date Created"),
                "column" => "timestamp_created",
                "table" => [
                    "width" => "120px"
                ]
            ],



        ];



    class MySuperTable extends SuperTable
    {


        public function callbackAddPost($items,  $foreign_items, $insert_id) {

            global $DB, $LOG;
            $DB->update("tb_groups",["timestamp_created"=>time()],["id","=",$insert_id]);


            $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_CREATE_GROUP,$items["name"],implode(",",$items));

            $DB->insert(
                "tb_events_logs",
                array(
                    "event_type" => 0,
                    "description" => $_SESSION[SI]["user"]["username"]." has created a new group: ".$items["name"],
                    "timestamp" => time()
                )
            );

        }

        public function callbackModifyPost($items, $foreign_items, $modify_id) {

            global $DB, $LOG;

            $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_MODIFY_GROUP,$items["name"],implode(",",$items));

            $DB->insert(
                "tb_events_logs",
                array(
                    "event_type" => 0,
                    "description" => $_SESSION[SI]["user"]["username"]." has modifyed group: ".$items["name"]." info.",
                    "timestamp" => time()
                )
            );

        }
        public function callbackDeletePre($delete_id) {

            global $DB, $LOG;

            $name = $DB->getScalar("name","tb_groups",array("id","=",$delete_id));

            $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_DELETED_GROUP,$name);

            $DB->insert(
                "tb_events_logs",
                array(
                    "event_type" => 0,
                    "description" => $_SESSION[SI]["user"]["username"]." has deleted the group: ".$name,
                    "timestamp" => time()
                )
            );

        }



        public function callbackFilterRow($row) {

            global $DB;

            if ($row["timestamp_created"] > 0) {
                $row["timestamp_created"] = date("m/d/Y", $row["timestamp_created"]);
            } elseif ($row["timestamp_created"] == 0) {
                $row["timestamp_created"] = T_("Since the begining of Mktime();");
            }

            if ($row["parent_group"] == -1) {
                $row["parent_group"] = "---";
            } else {
                $row["parent_group"] = $DB->getScalar("name","tb_groups", array("id", "=", $row["parent_group"]));
            }

            return $row;
        }


        public function callbackFilterModifyItems($form_items, $id) {

            $j=0;
            $items = $form_items[1]["value"];

            for($i=0;$i<count($items);$i++) {
                if ($items[$i]["id"] != $id) {
                    $tmp_items[$j] = $items[$i];
                    $j++;
                }
            }
            if (count($tmp_items ) > 0) {
                $form_items[1]["value"] = $tmp_items;
            }
            return $form_items;
        }
    }


    $buttons = [];



    $st = new MySuperTable("tb_groups");
    $st->setLabel("title_table",T_("System Groups"));
    $st->setLabel("title_add",T_("Add Group"));
    $st->setLabel("button_add",T_("Add Group"));
    $st->setLabel("button_modify",T_("Modify User"));
    $st->setFields($fields);
    $st->SetSortedColumn("tb_groups.id", "DESC");
    $st->setActions(true, true, true, $buttons);
    $st->setSearchable(true);
    $st->setFilter(T_("Parent"),"parent_group",$parent_groups);


    $page->setContent($st->display());
    $page->show();

}


displaySuperTable();