<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");

$page = new CustomPage(UserLevel::ADMIN);
$page->setTitle(T_("User Manager"));
$page->setMenu($MENU_ITEMS);


/**
 * @param $id
 */
function displayPasswordForm($id) {

    global $page, $DB;

    require_once("includes/classes/widgets/FormWidget.php");
    $form = new FormWidget(T_("Change Password for user:")." ".$DB->getScalar("username","tb_users",["id","=",$id]),"",FormWidget::FORM_METHOD_POST,"320px","right");


    $items = [];
    $items[] = ["name" => "password", "label" => T_("New password"),  "type" => FormWidget::FORM_ITEM_PASSWORD, "validation" => "true","value"=>""];


    $buttons = [
        ["name" => "add", "icon" => "check", "label" => T_("Save Changes"), "type" => FormWidget::FORM_BUTTON_SUBMIT],
        ["name" => "cancel", "icon" => "cancel", "label" => T_("Cancel"), "type" => FormWidget::FORM_BUTTON_LINK, "url" => "users.php"],
    ];

    $page->setContent($form->generate($items,$buttons));
    $page->show();

    die();
}

/**
 *
 */
function displaySuperTable() {

    global $page, $DB;

    require_once("includes/classes/SuperTable.php");


    $groups = $DB->select("*","tb_groups");

    if (count($groups) > 0) {
        for ($i=0;$i<count($groups);$i++) {
            $newgroups[$i]["id"] = $groups[$i]["id"];
            $newgroups[$i]["value"] = 0;
            $newgroups[$i]["label"] = $groups[$i]["name"];
            $newgroups[$i]["name"] = $groups[$i]["name"];

        }

    } else {
        $newgroups = array();
    }

    $groups = $newgroups;



    $fields =
        [
            [
                "label" => T_("Username"),
                "column" => "username",
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
                "label"=> T_("Email Address"),
                "column" => "email_address",
                "table" => [
                    "width" => "120px"
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "width" => "400px",
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
                "label" => T_("User Level"),
                "column" => "user_level",
                "table" => [
                    "width" => "120px",
                    "replace" => [
                        1 => T_("User"),
                        100 => T_("Staff"),
                        255 => T_("Admin.")
                    ]
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_SELECT,
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "value" => [
                        "source" => [
                            ["id"=>1,"name"=>T_("Normal User")],
                            ["id"=>100,"name"=>T_("Staff")],
                            ["id"=>255,"name"=>T_("Administrator")],

                        ],
                        "selection" => 0
                    ],
                ]

            ],

            [
                "label" => T_("Group"),
                "column" => "id_group",
                "table" => [
                    "width" => "120px",
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKGROUP,
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "value" =>  $groups,
                ]

            ],
            [
                "label" => T_("Password"),
                "column" => "password",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_PASSWORD,
                    "validation" => "",
                    "add" => true,
                    "modify" => false,
                    "value" => ""
                ]

            ],


            [
                "label" => T_("Date Created"),
                "column" => "timestamp_created",
                "table" => [
                    "width" => "120px"
                ]
            ],
            [
                "label" => T_("Default Language"),
                "column" => "default_language",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_SELECT,
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "width" => "200px",
                    "value" => [
                        "source" => [
                            ["id"=>"en_US","name"=>T_("English")],
                            ["id"=>"fr_CA","name"=>T_("French")],
                        ],
                        "selection" => "en_US"
                    ],
                ]

            ],

            [
                "label" => T_("Last visit from"),

                "column" => "@country_code",
                "table" => [
                    "width" => "120px"
                ]
            ],



        ];



    class MySuperTable extends SuperTable
    {

        public function callbackAddValidate($items, $foreign_items) {




            global $DB;
            if ($items["email_address"] == "") {
                return ["result"=>false,"error"=>T_("Email address is empty!")];
            }

            // Check for duplicate emails
            if ($DB->getCount("tb_users", ["email_address","=",$items["email_address"]]) > 0) {
                return ["result"=>false,"error"=>T_("Email address already in use!")];
            }

            return ["result"=>true, "error"=>""];
        }

        public function callbackAddPost($items,  $foreign_items, $insert_id) {

            global $DB, $LOG, $INPUT;

            $groups = $DB->select("*","tb_groups");

            for ($i=0;$i<count($groups);$i++) {
                 if ($INPUT->post->keyExists(str_replace(" ","_",$groups[$i]["name"]))) {
                     $DB->insert(
                         "tb_groups_users",
                         array(
                             "id_user" => $insert_id,
                             "id_group" => $groups[$i]["id"]
                         )
                     );
                 }
            }

            $DB->update("tb_users",["timestamp_created"=>time()],["id","=",$insert_id]);
            $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_CREATE_USER,$items["username"],implode(",",$items));

            $DB->insert(
                "tb_events_logs",
                array(
                    "event_type" => 0,
                    "description" => $_SESSION[SI]["user"]["username"]." has created a new user: ".$items["username"],
                    "timestamp" => time()
                )
            );
        }

        public function callbackModifyValidate($items, $foreign_items, $modify_id) {


            global $DB;

            if ($items["email_address"] == "") {
                return ["result"=>false,"error"=>T_("Email address is empty!")];
            }
            // Check for duplicate emails
            if ($DB->getCount("tb_users", [["email_address","=",$items["email_address"]],"AND",["id","!=",$modify_id]]) > 0) {
                return ["result"=>false,"error"=>T_("Email address already in use!")];
            }



            return ["result"=>true, "error"=>""];
        }

        public function callbackModifyPost($items, $foreign_items, $modify_id) {

            global $DB, $LOG, $INPUT;

            $groups = $DB->select("*","tb_groups");

            for ($i=0;$i<count($groups);$i++) {
                $remove_id = $DB->delete(
                    "tb_groups_users",
                    array(
                        array("id_user","=",$modify_id),
                        "AND",
                        array("id_group","=", $groups[$i]["id"])
                    )
                );
                if ($INPUT->post->keyExists(str_replace(" ","_",$groups[$i]["name"]))) {
                    $DB->insert(
                        "tb_groups_users",
                        array(
                            "id_user" => $modify_id,
                            "id_group" => $groups[$i]["id"]
                        )
                    );
                }
            }

            $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_MODIFY_USER,$items["username"],implode(",",$items));

            $DB->insert(
                "tb_events_logs",
                array(
                    "event_type" => 0,
                    "description" => $_SESSION[SI]["user"]["username"]." has modifyed user: ".$items["username"]." info.",
                    "timestamp" => time()
                )
            );

        }



        public function callbackFilterRow($row) {

            global $DB;

            if ($row["timestamp_created"] > 0) {
                $row["timestamp_created"] = date("m/d/Y", $row["timestamp_created"]);
            }


            $groups = $DB->select("*","tb_groups_users", array("id_user","=",$row["id"]));

            $row["id_group"] = "";

            if (count($groups > 0)) {
                for ($i=0;$i<count($groups);$i++) {
                    $row["id_group"] .= $DB->getScalar("name","tb_groups",array("id","=",$groups[$i]["id_group"])).", ";
                }

            }

            $country_code = $DB->select("country_code","tb_users_geolocalisation",array("id_user", "=", $row["id"]));

           if (count($country_code) > 0) {
                $row["country_code"] = "<img src=\"".$DB->getScalar("flag_url","tb_country",array("code","=",$country_code[count($country_code) -1]["country_code"]))."\"></img>";
            } else {
                $row["country_code"] = "N/A";
            }

            return $row;
        }

        public function callbackFilterModifyItems($form_items, $id) {

            global $DB;

            $in_groups = $DB->select("*","tb_groups_users",array("id_user","=",$id));

            for ($i=0;$i<count($form_items[4]["value"]);$i++) {
                for($j=0;$j<count($in_groups);$j++) {
                    if ($form_items[4]["value"][$i]["id"] == $in_groups[$j]["id_group"] ) {
                        $form_items[4]["value"][$i]["value"] = true;
                    }
                }
            }

            return $form_items;
        }


        public function callbackAddPre($items, $foreign_items) {


            $items["password"] = crypt($items["password"],'$5$');
            return $items;
        }


        public function callbackDeletePre($delete_id) {

            global $DB, $LOG;

            $username = $DB->getScalar("username","tb_users",array("id","=",$delete_id));

            $LOG->logActivity($_SESSION[SI]["user"]["username"],LogMonitor::ACTIVITY_DELETED_USER,$username);

            $DB->insert(
                "tb_events_logs",
                array(
                    "event_type" => 0,
                    "description" => $_SESSION[SI]["user"]["username"]." has deleted the user: ".$username,
                    "timestamp" => time()
                )
            );

            $DB->delete("tb_groups_users",array("id_user","=", $delete_id));
        }
    }




    $buttons = [];
    $buttons[] = ["id" => "password_entry", "label" => "", "icon" => "key", "tooltip" => T_("Change Password"), "confirm" => false, "before" => true];



    $st = new MySuperTable("tb_users");
    $st->setLabel("title_table",T_("System Users"));
    $st->setLabel("title_add",T_("Add User"));
    $st->setLabel("button_add",T_("Add User"));
    $st->setLabel("button_modify",T_("Modify User"));
    $st->setFields($fields);
    $st->SetSortedColumn("tb_users.id", "DESC");
    $st->setActions(true, true, true, $buttons);
    $st->setSearchable(true);
    $st->setFilter(T_("User Level"),"user_level",[["id"=>1,"name"=>T_("Normal")],["id"=>100,"name"=>T_("Staff")],["id"=>255,"name"=>T_("Administrator")]]);
    //$st->setFilter(T_("Groups"),"id_group",$groups);

    $page->setContent($st->display());
    $page->show();

}


// Handle user requests
if ($INPUT->get->keyExists("password_entry")) {
    $id = $INPUT->get->getInt("password_entry");

    if ($INPUT->post->keyExists("password")) {
        $password = $INPUT->post->noTags("password");
        if (strlen($password) > 0) {
            $password = crypt($password,'$5$');
            $DB->update("tb_users", ["password"=>$password],["id","=",$id]);
            die_notice("users.php",T_("The password was successfully changed."));
        }
    }

    displayPasswordForm($id);
}
displaySuperTable();