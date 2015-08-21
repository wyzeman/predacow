<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");

$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("Products"));
$page->setMenu($MENU_ITEMS);

/**
 *
 */
function displaySuperTable() {
    global $page;

    require_once("includes/classes/SuperTable.php");

    $fields = [
        [
            "label" => T_("Label (English)"),
            "column" => "label_en_US",
            "table" => [
                "width" => "200px",
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
            "label" => T_("Label (French)"),
            "column" => "label_fr_CA",
            "table" => [
                "width" => "200px",
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
    ];

    class MySuperTable extends SuperTable {

        /**
         * @param $delete_id id in tb_categories table
         */
        public function callbackDeletePost($delete_id)
        {
            global $DB;

            $DB->delete("tb_products_options_relations", ["id_option","=",$delete_id]);

        }
    }

    $st = new MySuperTable("tb_products_options");
    $st->setLabel("title_table", T_("Options"));
    $st->setLabel("title_add", T_("Add Option"));
    $st->setFields($fields);
    $st->SetSortedColumn("id", "DESC");
    $st->setActions(true, true, true);
    $st->setSearchable(true);
    $page->setContent($st->display());
    $page->show();
}

// Handle user requests
displaySuperTable();