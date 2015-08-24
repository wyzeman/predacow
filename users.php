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

    global $page;

    require_once("includes/classes/SuperTable.php");


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

            global $DB;
            $DB->update("tb_users",["timestamp_created"=>time()],["id","=",$insert_id]);
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

        public function callbackFilterRow($row) {
            if ($row["timestamp_created"] > 0) {
                $row["timestamp_created"] = date("m/d/Y", $row["timestamp_created"]);
            }

            return $row;
        }




        public function callbackAddPre($items, $foreign_items) {

            $items["password"] = crypt($items["password"],'$5$');
            return $items;
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