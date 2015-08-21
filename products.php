<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");

$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("Products"));
$page->setMenu($MENU_ITEMS);



/**
 * @param $category_id
 * @param $image_source
 */
function createProductImages($product_id, $color_id, $image_index, $image_source) {

    error_log("Create product images: " .$product_id."/".$color_id."/".$image_index."/".$image_source);
    $imgSource = imagecreatefrompng($image_source);

    $imgOut1 = imagecreatetruecolor(32,32);
    $imgOut2 = imagecreatetruecolor(160,160);
    $imgOut3 = imagecreatetruecolor(200,200);
    $imgOut4 = imagecreatetruecolor(400,400);

    imagealphablending($imgOut1, false );
    imagesavealpha($imgOut1, true );
    imagealphablending($imgOut2, false );
    imagesavealpha($imgOut2, true );
    imagealphablending($imgOut3, false );
    imagesavealpha($imgOut3, true );
    imagealphablending($imgOut4, false );
    imagesavealpha($imgOut4, true );

    imagecopyresampled($imgOut1,$imgSource,0,0,0,0,32,32,imagesx($imgSource), imagesy($imgSource));
    imagecopyresampled($imgOut2,$imgSource,0,0,0,0,160,160,imagesx($imgSource), imagesy($imgSource));
    imagecopyresampled($imgOut3,$imgSource,0,0,0,0,200,200,imagesx($imgSource), imagesy($imgSource));
    imagecopyresampled($imgOut4,$imgSource,0,0,0,0,400,400,imagesx($imgSource), imagesy($imgSource));

    $path = CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$product_id."/";

    if (file_exists($path) == false) {
        mkdir($path, 0755);
    }

    $path .= $color_id."/";

    if (file_exists($path) == false) {
        mkdir($path, 0755);
    }

    imagepng($imgOut1,$path."/".$image_index."_thumbnail.png");
    imagepng($imgOut2,$path."/".$image_index."_small.png");
    imagepng($imgOut3,$path."/".$image_index."_medium.png");
    imagepng($imgOut4,$path."/".$image_index."_normal.png");

    imagedestroy($imgSource);
    imagedestroy($imgOut1);
    imagedestroy($imgOut2);
    imagedestroy($imgOut3);
    imagedestroy($imgOut4);

}


/**
 *
 */
function displaySuperTable() {

    global $page, $DB;

    require_once("includes/classes/SuperTable.php");
    require_once("includes/classes/widgets/form/ProductRatesWidget.php");

    $value_categories = [];
    $parent_categories = $DB->select("*","tb_categories", ["parent","=",-1], ["label_en_US ASC"]);
    foreach($parent_categories as $parent) {

        $value_categories[] = [
            "id" => $parent["id"],
            "name" => "category_" . $parent["id"],
            "label" => $parent["label_en_US"],
            "value" => false
        ];

        $categories = $DB->select("*","tb_categories", ["parent","=",$parent["id"]], ["label_en_US ASC"]);

        foreach($categories as $category) {
            $value_categories[] = [
                "id" => $category["id"],
                "name" => "category_" . $category["id"],
                "label" => $parent["label_en_US"]." &#65515; ".$category["label_en_US"],
                "value" => false
            ];
        }
    }


    $value_colors = [];
    $colors = $DB->select("*","tb_products_colors", [], ["label_en_US ASC"]);
    foreach($colors as $color) {
        $value_colors[] = [
            "id" => $color["id"],
            "name" => "color_" . $color["id"],
            "label" => "<span style=\"color:#".$color["value"]."\">".$color["label_en_US"]."</span>",
            "value" => false
        ];
    }

    $value_options = [];
    $options = $DB->select("*","tb_products_options", [], ["label_en_US ASC"]);
    foreach($options as $option) {
        $value_options[] = [
            "id" => $option["id"],
            "name" => "option_" . $option["id"],
            "label" => $option["label_en_US"],
            "value" => false
        ];
    }

    $fields =
        [
            [
                "label" => T_("Image"),
                "column" => "@image",
                "table" => [
                    "width" => "60px"
                ]
            ],
            [
                "label" => T_("Creation Date"),
                "column" => "date_created",
                "table" => [
                    "width" => "100px",
                ],
            ],
            [
                "label" => T_("Code"),
                "column" => "code",
                "table" => [
                    "width" => "100px",
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
                    "width" => "50px",
                    "replace" => [0=>'<span style="color:red">'.T_("No").'</span>',1=>'<span style="color:green">'.T_("Yes").'</span>']
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKBOX,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => false
                ]
            ],
            [
                "label" => T_("Featured"),
                "column" => "featured",
                "table" => [
                    "width" => "50px",
                    "replace" => [0=>'<span style="color:red">'.T_("No").'</span>',1=>'<span style="color:green">'.T_("Yes").'</span>']
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKBOX,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => false
                ]
            ],

            [
                "label" => T_("Customizable"),
                "column" => "customizable",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKBOX,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => true
                ]
            ],
            [
                "label" => T_("In stock"),
                "column" => "qty_instock",
                "table" => [
                    "width" => "80px",
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => 0
                ]
            ],
            [
                "label" => T_("Weight (LBS)"),
                "column" => "weight",
                "table" => [
                    "width" => "80px",
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "width" => "100px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => 0
                ]
            ],
            [
                "label" => T_("Quantity per box"),
                "column" => "qty_per_box",
                "table" => [
                    "width" => "80px",
                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_INPUT,
                    "width" => "100px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => 0
                ]
            ],            [
                "label" => T_("English"),
                "column" => "",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_SEPARATOR,
                    "width" => "300px",
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "value" => ""
                ]
            ],
            [
                "label" => T_("Label"),
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
                "label" => T_("Description (Short)"),
                "column" => "description_short_en_US",
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
                "label" => T_("Description (Full)"),
                "column" => "description_long_en_US",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_TEXTAREA,
                    "width" => "520px",
                    "height" => "160px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => ""
                ]
            ],
            [
                "label" => T_("French"),
                "column" => "",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_SEPARATOR,
                    "width" => "300px",
                    "validation" => "",
                    "add" => true,
                    "modify" => true,
                    "value" => ""
                ]
            ],
            [
                "label" => T_("Label"),
                "column" => "label_fr_CA",
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
                "label" => T_("Description (Short)"),
                "column" => "description_short_fr_CA",
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
                "label" => T_("Description (Full)"),
                "column" => "description_long_fr_CA",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_TEXTAREA,
                    "width" => "520px",
                    "height" => "160px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => ""
                ]
            ],
            [
                "label" => T_("Categories"),
                "column" => "",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKGROUP,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" =>$value_categories
                ]
            ],
            [
                "label" => T_("Colors"),
                "column" => "",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKGROUP,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" =>$value_colors
                ]
            ],
            [
                "label" => T_("Options"),
                "column" => "",
                "form" => [
                    "type" => FormWidget::FORM_ITEM_CHECKGROUP,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" =>$value_options
                ]
            ],            [
                "label" => "Price Range",
                "column" => "",
                "form" => ["type"=>FormWidget::FORM_ITEM_SEPARATOR,"validation"=>"","add"=>true,"modify"=>true, "value"=>""]
            ],
            [
                "label" => "",
                "column" => "",
                "form" => ["type"=>FormWidget::FORM_ITEM_WIDGET,"validation"=>"","add"=>true,"modify"=>true,"value"=>new ProductRatesWidget()]
            ],

        ];


    class MySuperTable extends SuperTable
    {

        public function callbackAddValidate($items, $foreign_items)
        {

            global $DB,$INPUT;

            if (strlen($items["code"]) > 0) {
                // Check if the code is already exists
                if ($DB->getCount("tb_products", [
                        ["code", "=", $items["code"]],
                    ]) > 0
                ) {
                    return ["result" => false, "error" => T_("This code is already in use!")];
                }
            }

            if (strlen($items["label_en_US"]) > 0) {
                // Check if the internal name already exists
                if ($DB->getCount("tb_products", [
                        ["label_en_US", "=", $items["label_en_US"]],
                        "OR",
                        ["label_fr_CA", "=", $items["label_fr_CA"]],
                    ]) > 0
                ) {
                    return ["result" => false, "error" => T_("This name is already in use!")];
                }
            }

            // Check if at least one category is selected
            $categories = $DB->select("id","tb_categories");
            $category_found = false;
            foreach($categories as $category) {
                if ($INPUT->post->keyExists("category_".$category["id"]) == true) {
                    $category_found = true;
                    break;
                }
            }

            if ($category_found == false) {
                return ["result" => false, "error" => T_("You need to select at least one category!")];
            }

            // Check if at least one color is selected
            $colors = $DB->select("id","tb_products_colors");
            $color_found = false;
            foreach($colors as $color) {
                if ($INPUT->post->keyExists("color_".$color["id"]) == true) {
                    $color_found = true;
                    break;
                }
            }

            if ($color_found == false) {
                return ["result" => false, "error" => T_("You need to select at least one color!")];
            }

            return ["result" => true, "error" => ""];
        }

        public function callbackModifyValidate($items, $foreign_items, $modify_id)
        {

            global $DB,$INPUT;

            // Check if the code already exists
            if (strlen($items["code"]) > 0) {
                if ($DB->getCount("tb_products", [
                        [
                            ["code", "=", $items["code"]],
                        ],
                        "AND",
                        ["id", "<>", $modify_id]
                    ]) > 0
                ) {
                    return ["result" => false, "error" => T_("This name is already in use!")];
                }
            }

            // Check if the internal name already exists
            if (strlen($items["label_en_US"]) > 0) {
                if ($DB->getCount("tb_products", [
                        [
                            ["label_en_US", "=", $items["label_en_US"]],
                            "OR",
                            ["label_fr_CA", "=", $items["label_fr_CA"]],
                        ],
                        "AND",
                        ["id", "<>", $modify_id]
                    ]) > 0
                ) {
                    return ["result" => false, "error" => T_("This name is already in use!")];
                }
            }

            // Check if at least one category is selected
            $categories = $DB->select("id","tb_categories");
            $category_found = false;
            foreach($categories as $category) {
                if ($INPUT->post->keyExists("category_".$category["id"]) == true) {
                    $category_found = true;
                    break;
                }
            }

            if ($category_found == false) {
                return ["result" => false, "error" => T_("You need to select at least one category!")];
            }

            // Check if at least one color is selected
            $colors = $DB->select("id","tb_products_colors");
            $color_found = false;
            foreach($colors as $color) {
                if ($INPUT->post->keyExists("color_".$color["id"]) == true) {
                    $color_found = true;
                    break;
                }
            }

            if ($color_found == false) {
                return ["result" => false, "error" => T_("You need to select at least one color!")];
            }

            return ["result" => true, "error" => ""];
        }

        public function callbackFilterRow($row)
        {
            global $DB;

            $row["date_created"] = date("m/d/y", $row["date_created"]);
            if ($row["qty_instock"] <= 20) {
                $row["qty_instock"] = '<span style="color:red">' . number_format($row["qty_instock"]) . '</span>';
            } else {
                $row["qty_instock"] = number_format($row["qty_instock"]);
            }

            $id_color = $DB->getScalar("id_color", "tb_products_colors_relations", ["id_product", "=", $row["id"]], ["id ASC"]);
            if ($id_color == null) {
                $row["@image"] = "";
            } else {
                if (file_exists(CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$row["id"]."/".$id_color."/0_thumbnail.png")) {
                    $row["@image"] = '<img src="' . CONFIG_WEBSITE_PUBLIC_URL . 'images/products/' . $row["id"] . '/' . $id_color . '/0_thumbnail.png?' .time() . '">';
                } else {
                    $row["@image"] = '<img src="' . CONFIG_WEBSITE_PUBLIC_URL.'images/deleted.png">';
                }
            }
            return $row;
        }


        /**
         * @param $items
         * @param $insert_id
         */
        public function callbackAddPost($items, $foreign_items, $insert_id)
        {
            global $DB,$INPUT;

            // We link categories
            $categories = $DB->select("*","tb_categories", [], ["label_en_US ASC"]);
            foreach($categories as $category) {
                if ($INPUT->post->keyExists("category_".$category["id"])) {
                    $DB->insert("tb_products_categories", ["id_product"=>$insert_id,"id_category"=>$category["id"]]);
                }
            }

            // We link colors
            $colors = $DB->select("*","tb_products_colors",[], ["label_en_US ASC"]);
            foreach($colors as $color) {
                if ($INPUT->post->keyExists("color_".$color["id"])) {
                    $DB->insert("tb_products_colors_relations",["id_product"=>$insert_id,"id_color"=>$color["id"]]);
                    // We generate custom images
 //                   for ($i=0;$i<1;$i++) {
                        createProductImages($insert_id, $color["id"], 0, CONFIG_WEBSITE_PUBLIC_PATH . "images/products/no_image.png");
   //                 }


                }
            }

            // We link options
            $options = $DB->select("*","tb_products_options",[], ["label_en_US ASC"]);
            foreach($options as $option) {
                if ($INPUT->post->keyExists("option_".$option["id"])) {
                    $DB->insert("tb_products_options_relations",["id_product"=>$insert_id,"id_option"=>$option["id"]]);
                }
            }
        }

        /**
         *
         */
        public function callbackModifyPost($items, $foreign_items, $modify_id) {

            global $INPUT, $DB;

            $DB->delete("tb_products_categories", ["id_product","=",$modify_id]);
            // We link categories
            $categories = $DB->select("*","tb_categories", [], ["label_en_US ASC"]);
            foreach($categories as $category) {
                if ($INPUT->post->keyExists("category_".$category["id"])) {
                    $DB->insert("tb_products_categories", ["id_product"=>$modify_id,"id_category"=>$category["id"]]);
                }
            }

            // We link options
            $DB->delete("tb_products_options_relations", ["id_product","=",$modify_id]);
            // We link categories
            $options = $DB->select("*","tb_products_options", [], ["label_en_US ASC"]);
            foreach($options as $option) {
                if ($INPUT->post->keyExists("option_".$option["id"])) {
                    $DB->insert("tb_products_options_relations", ["id_product"=>$modify_id,"id_option"=>$option["id"]]);
                }
            }

            // We link colors
            $previous_colors = $DB->select("id_color","tb_products_colors_relations", ["id_product","=",$modify_id]);
            $DB->delete("tb_products_colors_relations", ["id_product","=",$modify_id]);
            // We link categories
            $colors = $DB->select("*","tb_products_colors", [], ["label_en_US ASC"]);
            $colors_found = [];
            foreach($colors as $color) {
                if ($INPUT->post->keyExists("color_".$color["id"])) {
                    $colors_found[] = $color["id"];
                    $DB->insert("tb_products_colors_relations", ["id_product"=>$modify_id,"id_color"=>$color["id"]]);

                    $found = false;
                    foreach($previous_colors as $previous) {
                        if ($previous["id_color"] == $color["id"]) {
                            $found = true;
                            break;
                        }
                    }
                    if ($found == false) {
                        for ($i=0;$i<6;$i++) {
                            createProductImages($modify_id, $color["id"], $i, CONFIG_WEBSITE_PUBLIC_PATH . "images/products/no_image.png");
                        }
                    }

                }
            }

            // Remove extra files.
            $root = CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$modify_id."/";
            if (file_exists($root)) {
                $dir = opendir($root);
                while ($file = readdir($dir)) {
                    if ($file[0] == ".") {
                        continue;
                    }

                    $found = false;

                    foreach($colors_found as $color) {
                        if ($color == $file) {
                            $found = true;
                            break;
                        }
                    }

                    if ($found == false) {
                        if (is_dir($root . $file) == true) {
                            for ($i=0;$i<6;$i++) {
                                $images = [$i."_normal", $i."_medium", $i."_small", $i."_thumbnail"];
                                foreach ($images as $image) {
                                    if (file_exists($root . $file . "/" . $image . ".png") == true) {
                                        unlink($root . $file . "/" . $image . ".png");
                                    }
                                }
                                recursive_rmdir($root.$file);
                            }
                        }
                    }
                }
                closedir($dir);
            }
        }

        public function callbackDeletePre($delete_id)
        {
            global $DB;
            if ($DB->getCount("tb_orders_products",["id_product","=",$delete_id]) > 0) {
                die_warning("products.php",T_("This product is already in at least one order!"));
            }
        }

        /**
         * @param $delete_id id in tb_categories table
         */
        public function callbackDeletePost($delete_id)
        {
            global $DB;

            $DB->delete("tb_products_categories", ["id_product","=",$delete_id]);
            $DB->delete("tb_products_options_relations", ["id_product","=",$delete_id]);
            $DB->delete("tb_products_colors_relations", ["id_product","=",$delete_id]);

            $root = CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$delete_id."/";
            recursive_rmdir($root);
        }

        /**
         * @param $form_items
         * @param $id
         */
        public function callbackFilterModifyItems($form_items, $id) {

            global $DB;

            for ($i=0;$i<count($form_items);$i++) {
                if ($form_items[$i]["label"] == T_("Categories")) {
                    for ($j=0;$j<count($form_items[$i]["value"]);$j++) {
                        if ($DB->getCount("tb_products_categories",[["id_product","=",$id],"AND",["id_category","=",$form_items[$i]["value"][$j]["id"]]]) > 0) {
                            $form_items[$i]["value"][$j]["value"] = true;
                        } else {
                            $form_items[$i]["value"][$j]["value"] = false;
                        }
                    }
                }
                if ($form_items[$i]["label"] == T_("Colors")) {
                    for ($j=0;$j<count($form_items[$i]["value"]);$j++) {
                        if ($DB->getCount("tb_products_colors_relations",[["id_product","=",$id],"AND",["id_color","=",$form_items[$i]["value"][$j]["id"]]]) > 0) {
                            $form_items[$i]["value"][$j]["value"] = true;
                        } else {
                            $form_items[$i]["value"][$j]["value"] = false;
                        }
                    }
                }
                if ($form_items[$i]["label"] == T_("Options")) {
                    for ($j=0;$j<count($form_items[$i]["value"]);$j++) {
                        if ($DB->getCount("tb_products_options_relations",[["id_product","=",$id],"AND",["id_option","=",$form_items[$i]["value"][$j]["id"]]]) > 0) {
                            $form_items[$i]["value"][$j]["value"] = true;
                        } else {
                            $form_items[$i]["value"][$j]["value"] = false;
                        }
                    }
                }
            }

            return $form_items;
        }
    }

    $buttons = [];
    $buttons[] = ["id" => "images_entry", "label" => "", "icon" => "photo", "tooltip" => T_("Images"), "confirm" => false, "before" => true];


    $st = new MySuperTable("tb_products");
    $st->setLabel("title_table", T_("Products"));
    $st->setLabel("title_add", T_("Add Product"));
    $st->setLabel("button_add",T_("Add Product"));
    $st->setLabel("button_modify",T_("Modify Product"));
    $st->setFields($fields);
    $st->SetSortedColumn("id", "DESC");
    $st->setActions(true, true, true, $buttons);
    $st->setSearchable(true);
    $page->setContent($st->display());
    $page->show();
}


/**
 * @param $id
 */
function displayImagesForm($id) {

    global $DB, $page;

    require_once("includes/classes/widgets/FormWidget.php");
    $form = new FormWidget(T_("Product Images"),"",FormWidget::FORM_METHOD_POST,"320px","right");

    $items = [];
    $colors = $DB->select("*","tb_products_colors_relations", ["id_product","=",$id],["id ASC"]);
    foreach($colors as $color) {
        $color_name = $DB->getScalar("label_en_US","tb_products_colors",["id","=",$color["id_color"]]);

        $items[] = ["name" => "", "label" => $color_name, "type" => FormWidget::FORM_ITEM_SEPARATOR, "validation" => "", "value" => ''];

        $images = [];

        for ($i=0;$i<6;$i++) {

            $filename = CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$id."/".$color["id_color"]."/".$i."_medium.png";
            if (file_exists($filename)) {
                $images[] = CONFIG_WEBSITE_PUBLIC_URL . "images/products/" . $id . "/".$color["id_color"]. "/".$i."_medium.png?" . time();
            } else {
                $images[] = CONFIG_WEBSITE_PUBLIC_URL . "images/deleted.png";
            }

        }

        $items[] = ["name" => "", "label" => T_("Image #1 (160x160)"), "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "", "value" => '<img style="vertical-align:middle" src="' . $images[0] . '"><br/>'];
        $items[] = ["name" => "color_".$color["id_color"]."_image_0", "label" => T_("Original Image (400x400)"), "type" => FormWidget::FORM_ITEM_FILE, "validation" => "", "value" => ""];
        $items[] = ["name" => "", "value" => "<input type=\"button\" value=\"".T_("Delete Image")."\" onclick=\"if (confirm('".T_("Are you sure?")."')) window.location='products.php?images_entry=".$id."&image_delete=0&color=".$color["id_color"]."'\">", "label"=>"", "type" => FormWidget::FORM_ITEM_LABEL];
        $items[] = ["name" => "", "label" => "", "type" => FormWidget::FORM_ITEM_SEPARATOR];

        $items[] = ["name" => "", "label" => T_("Image #2 (160x160)"), "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "", "value" => '<img style="vertical-align:middle" src="' . $images[1] . '"><br/>'];
        $items[] = ["name" => "color_".$color["id_color"]."_image_1", "label" => T_("Original Image (400x400)"), "type" => FormWidget::FORM_ITEM_FILE, "validation" => "", "value" => ""];
        $items[] = ["name" => "", "value" => "<input type=\"button\" value=\"".T_("Delete Image")."\" onclick=\"if (confirm('".T_("Are you sure?")."')) window.location='products.php?images_entry=".$id."&image_delete=1&color=".$color["id_color"]."'\">", "label"=>"", "type" => FormWidget::FORM_ITEM_LABEL];
        $items[] = ["name" => "", "label" => "", "type" => FormWidget::FORM_ITEM_SEPARATOR];

        $items[] = ["name" => "", "label" => T_("Image #3 (160x160)"), "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "", "value" => '<img style="vertical-align:middle" src="' . $images[2] . '"><br/>'];
        $items[] = ["name" => "color_".$color["id_color"]."_image_2", "label" => T_("Original Image (400x400)"), "type" => FormWidget::FORM_ITEM_FILE, "validation" => "", "value" => ""];
        $items[] = ["name" => "", "value" => "<input type=\"button\" value=\"".T_("Delete Image")."\" onclick=\"if (confirm('".T_("Are you sure?")."')) window.location='products.php?images_entry=".$id."&image_delete=2&color=".$color["id_color"]."'\">", "label"=>"", "type" => FormWidget::FORM_ITEM_LABEL];
        $items[] = ["name" => "", "label" => "", "type" => FormWidget::FORM_ITEM_SEPARATOR];

        $items[] = ["name" => "", "label" => T_("Image #4 (160x160)"), "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "", "value" => '<img style="vertical-align:middle" src="' . $images[3] . '"><br/>'];
        $items[] = ["name" => "color_".$color["id_color"]."_image_3", "label" => T_("Original Image (400x400)"), "type" => FormWidget::FORM_ITEM_FILE, "validation" => "", "value" => ""];
        $items[] = ["name" => "", "value" => "<input type=\"button\" value=\"".T_("Delete Image")."\" onclick=\"if (confirm('".T_("Are you sure?")."')) window.location='products.php?images_entry=".$id."&image_delete=3&color=".$color["id_color"]."'\">", "label"=>"", "type" => FormWidget::FORM_ITEM_LABEL];
        $items[] = ["name" => "", "label" => "", "type" => FormWidget::FORM_ITEM_SEPARATOR];

        $items[] = ["name" => "", "label" => T_("Image #5 (160x160)"), "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "", "value" => '<img style="vertical-align:middle" src="' . $images[4] . '"><br/>'];
        $items[] = ["name" => "color_".$color["id_color"]."_image_4", "label" => T_("Original Image (400x400)"), "type" => FormWidget::FORM_ITEM_FILE, "validation" => "", "value" => ""];
        $items[] = ["name" => "", "value" => "<input type=\"button\" value=\"".T_("Delete Image")."\" onclick=\"if (confirm('".T_("Are you sure?")."')) window.location='products.php?images_entry=".$id."&image_delete=4&color=".$color["id_color"]."'\">", "label"=>"", "type" => FormWidget::FORM_ITEM_LABEL];
        $items[] = ["name" => "", "label" => "", "type" => FormWidget::FORM_ITEM_SEPARATOR];

        $items[] = ["name" => "", "label" => T_("Image #6 (160x160)"), "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "", "value" => '<img style="vertical-align:middle" src="' . $images[5] . '"><br/>'];
        $items[] = ["name" => "color_".$color["id_color"]."_image_5", "label" => T_("Original Image (400x400)"), "type" => FormWidget::FORM_ITEM_FILE, "validation" => "", "value" => ""];
        $items[] = ["name" => "", "value" => "<input type=\"button\" value=\"".T_("Delete Image")."\" onclick=\"if (confirm('".T_("Are you sure?")."')) window.location='products.php?images_entry=".$id."&image_delete=5&color=".$color["id_color"]."'\">", "label"=>"", "type" => FormWidget::FORM_ITEM_LABEL];
        $items[] = ["name" => "", "label" => "", "type" => FormWidget::FORM_ITEM_SEPARATOR];
    }

    $buttons = [
        ["name" => "add", "icon" => "check", "label" => T_("Save Changes"), "type" => FormWidget::FORM_BUTTON_SUBMIT],
        ["name" => "cancel", "icon" => "cancel", "label" => T_("Cancel"), "type" => FormWidget::FORM_BUTTON_LINK, "url" => "products.php"],
    ];

    $page->setContent($form->generate($items,$buttons));
    $page->show();

    die();
}

function handleImageUpload($id, $color_id, $image_index, $file) {

    if ($file["size"] == 0) {
        return false;
    }

    if ($file["type"] != "image/png") {
        die_notice("products.php?images_entry=".$id,T_("Invalid image type, please use a PNG file."));
    }

    if ($file["error"] != 0) {
        die_notice("products.php?images_entry=".$id,T_("An error happened while uploading the file:")." ".$file["error"]);
    }

    createProductImages($id, $color_id, $image_index, $file["tmp_name"]);
    return true;
}


// Handle user request
if ($INPUT->get->keyExists("images_entry")) {
    $id = $INPUT->get->noTags("images_entry");

    // Handle image removal
    if ($INPUT->get->keyExists("image_delete")) {
        $color = $INPUT->get->getInt("color");
        $img = $INPUT->get->getInt("image_delete");

        @unlink(CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$id."/".$color."/".$img."_medium.png");
        @unlink(CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$id."/".$color."/".$img."_normal.png");
        @unlink(CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$id."/".$color."/".$img."_small.png");
        @unlink(CONFIG_WEBSITE_PUBLIC_PATH."images/products/".$id."/".$color."/".$img."_thumbnail.png");
        die_notice("products.php?images_entry=".$id,T_("Image removed"));
    }

    // Handle image upload
    $colors = $DB->select("*","tb_products_colors_relations", ["id_product","=",$id],["id ASC"]);
    $uploaded_images = false;

    foreach($colors as $color) {
        for ($i=0;$i<6;$i++) {
            $key = "color_" . $color["id_color"] . "_image_".$i;
            if ($INPUT->files->keyExists($key)) {
                $added = handleImageUpload($id, $color["id_color"], $i, $INPUT->files->getValue($key));
                if ($added == true) {
                    $uploaded_images = true;
                }
            }
        }
    }

    if ($uploaded_images == true) {
        die_notice("products.php?images_entry=" . $id, T_("The image file was successfully uploaded."));
    }

    displayImagesForm($id);
}

displaySuperTable();



