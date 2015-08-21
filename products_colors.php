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
    global $page,$TPL;

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
        [
            "label" => T_("Color Value"),
            "column" => "value",
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
            "label" => T_("Color Value #2"),
            "column" => "value2",
            "table" => [
                "width" => "200px",
            ],
            "form" => [
                "type" => FormWidget::FORM_ITEM_INPUT,
                "width" => "300px",
                "validation" => "",
                "add" => true,
                "modify" => true,
                "value" => ""
            ]
        ]
    ];

    class MySuperTable extends SuperTable {



        private function create_color_image($items, $insert_id) {

            $im = new Imagick();
            $size = 24;
            $offset = $size / 2;
            $radius = round(($size / 2) * 0.9);

            $im->newImage($size,$size,"transparent","png");

            $draw = new ImagickDraw();
            $draw->setFillColor(new ImagickPixel("#".$items["value"]));
            if ($items["value2"] == "") {
                $draw->ellipse($offset, $offset, $radius, $radius, 0, 360);
            } else {
                $draw->ellipse($offset, $offset, $radius, $radius, 90, 270);
                $draw->setFillColor(new ImagickPixel("#".$items["value2"]));
                $draw->ellipse($offset, $offset, $radius,$radius, 270, 90);

            }
            $im->drawImage($draw);
            $draw->destroy();

            $im->writeImage(CONFIG_WEBSITE_PUBLIC_PATH."images/colors/".$insert_id.".png");
            $im->destroy();
        }


        public function callbackFilterRow($row)
        {
            $row["value"] = "<span style=\"color:#".$row["value"]."\">".$row["value"]."</span>";;
            if ($row["value2"] != "") {
                $row["value2"] = "<span style=\"color:#".$row["value2"]."\">".$row["value2"]."</span>";
            }

            return $row;
        }


        public function callbackAddPost($items,  $foreign_items, $insert_id) {

            $this->create_color_image($items, $insert_id);

        }

        public function callbackModifyPost($items, $foreign_items, $modify_id) {
            $this->create_color_image($items, $modify_id);
        }


        public function callbackDeletePre($delete_id)
        {
            global $DB;

            // We want to make sure that no product is only using this category and nothing else.
            $products = $DB->select("id_product","tb_products_colors_relations", ["id_color","=",$delete_id]);
            foreach($products as $product) {
                if ($DB->getCount("tb_products_colors_relations",[
                        ["id_product","=",$product["id_product"]],
                        "AND",
                        ["id_color","<>",$delete_id]
                    ]) == 0) {
                    die_warning("products_colors.php",T_("This color is already in a product that contains no other color!"));
                }

            }
        }

        /**
         * @param $delete_id id in tb_categories table
         */
        public function callbackDeletePost($delete_id)
        {
            global $DB;

            $relations = $DB->select("*","tb_products_colors_relations",["id_color","=",$delete_id]);
            foreach($relations as $relation) {

                // Remove extra files.
                $root = CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$relation["id_product"]."/".$relation["id_color"]."/";
                $images = ["normal","medium","small","thumbnail"];
                foreach($images as $image) {
                    if (file_exists($root . $image . ".png") == true) {
                        unlink($root . $image . ".png");
                    }
                }
                rmdir($root);

            }
        }
    }

    $st = new MySuperTable("tb_products_colors");
    $st->setPayload($TPL->fetch("payloads/color_picker.tpl"));
    $st->setLabel("title_table", T_("Colors"));
    $st->setLabel("title_add", T_("Add Color"));
    $st->setLabel("button_add", T_("Add Color"));
    $st->setLabel("button_modify", T_("Modify Color"));
    $st->setFields($fields);
    $st->SetSortedColumn("id", "DESC");
    $st->setActions(true, true, true);
    $st->setSearchable(true);
    $page->setContent($st->display());
    $page->show();
}

// Handle user requests
displaySuperTable();