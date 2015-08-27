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

            global $DB;
            $DB->update("tb_groups",["timestamp_created"=>time()],["id","=",$insert_id]);
        }


        public function callbackFilterRow($row) {

            global $DB;

            if ($row["timestamp_created"] > 0) {
                $row["timestamp_created"] = date("m/d/Y", $row["timestamp_created"]);
            } elseif ($row["timestamp_created"] == 0) {
                $row["timestamp_created"] = T_("Since the begining of Mktime();");
            }

            return $row;
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


    $page->setContent($st->display());
    $page->show();

}


displaySuperTable();