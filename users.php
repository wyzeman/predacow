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
    $form = new FormWidget(T_("Change Password for user:")." ".$DB->getScalar("email_address","tb_users",["id","=",$id]),"",FormWidget::FORM_METHOD_POST,"320px","right");


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
                "label" => T_("First Name"),
                "column" => "first_name",
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
                "label" => T_("Last Name"),
                "column" => "last_name",
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
                "label" => T_("Phone Number"),
                "column" => "phone_number",
                "table" => [
                    "width" => "120px"
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_PHONENUMBER,
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "value" => ""
                ]

            ],
            [
                "label" => T_("Fax. Number"),
                "column" => "fax_number",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_PHONENUMBER,
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
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
                "label" => T_("Facebook ID"),
                "column" => "fb_id",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "validation" => "",
                    "add" => false,
                    "modify" => true,
                    "width" => "300px",
                    "value" => ""
                ]

            ],
            [
                "label" => T_("Twitter ID"),
                "column" => "twitter_id",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "validation" => "",
                    "add" => false,
                    "modify" => true,
                    "width" => "300px",
                    "value" => "",
                ]

            ],
            [
                "label" => T_("LinkedIn ID"),
                "column" => "linkedin_id",
                "form" => [
                            "type" => FormWidget::FORM_ITEM_INPUT,
                            "validation" => "",
                            "add" => false,
                            "modify" => true,
                            "width" => "300px",
                            "value" => "",
                        ]

                ],
            [
                "label" => "Shipping Coordinates",
                "column" => "",
                "form" => ["type"=>FormWidget::FORM_ITEM_SEPARATOR,"validation"=>"","add"=>true,"modify"=>true, "value"=>""]
            ],
            [
                "label" => T_("Street Address #1"),
                "column" => [ "table" => "tb_users_addresses", "name" => "shipping_address1", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("Street Address #2"),
                "column" => [ "table" => "tb_users_addresses", "name" => "shipping_address2", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("City"),
                "column" => [ "table" => "tb_users_addresses", "name" => "shipping_city", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("State"),
                "column" => [ "table" => "tb_users_addresses", "name" => "shipping_state", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("Country"),
                "column" => [ "table" => "tb_users_addresses", "name" => "shipping_country", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("Postal Code"),
                "column" => [ "table" => "tb_users_addresses", "name" => "shipping_postalcode", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "220px","value"=>""]
            ],
            [
                "label" => "Billing Coordinates",
                "column" => "",
                "form" => ["type"=>FormWidget::FORM_ITEM_SEPARATOR,"validation"=>"","add"=>true,"modify"=>true, "value"=>""]
            ],

            [
                "label" => T_("Street Address #1"),
                "column" => [ "table" => "tb_users_addresses", "name" => "billing_address1", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("Street Address #2"),
                "column" => [ "table" => "tb_users_addresses", "name" => "billing_address2", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("City"),
                "column" => [ "table" => "tb_users_addresses", "name" => "billing_city", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("State"),
                "column" => [ "table" => "tb_users_addresses", "name" => "billing_state", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("Country"),
                "column" => [ "table" => "tb_users_addresses", "name" => "billing_country", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "300px","value"=>""]
            ],
            [
                "label" => T_("Postal Code (Billing)"),
                "column" => [ "table" => "tb_users_addresses", "name" => "billing_postalcode", "key" => "id_user" ],
                "form" => [ "type" => FormWidget::FORM_ITEM_INPUT, "validation" => "", "add" => true, "modify" => true, "width" => "220px","value"=>""]
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

            $row["phone_number"] = format_phone($row["phone_number"]);
            return $row;
        }

        public function callbackDeletePost($delete_id) {

            global $DB;
            $DB->delete("tb_users_addresses", ["id_user","=",$delete_id]);


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