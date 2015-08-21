<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");

$page = new CustomPage(UserLevel::STAFF);
$page->setTitle(T_("Categories"));
$page->setMenu($MENU_ITEMS);

/**
 * @param $id
 */
function displayImagesForm($id) {

    global $page;

    require_once("includes/classes/widgets/FormWidget.php");
    $form = new FormWidget(T_("Category Images"),"",FormWidget::FORM_METHOD_POST,"320px","right");

    $fileImage1 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/big.png?".time(); // 100x100
    $fileImage2 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/big_active.png?".time();
    $fileImage3 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/normal.png?".time(); // 64x64
    $fileImage4 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/small.png?".time();  // 48x48
    $fileImage5 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/small_active.png?".time();
    $fileImage6 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/bg_left.png?".time();
    $fileImage7 = CONFIG_WEBSITE_PUBLIC_URL."images/categories/".$id."/top.png?".time();

    $items = [];
    $items[] = ["name" => "", "label" => T_("Big Image (100x100)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" src="'.$fileImage1.'"><br/>'];
    $items[] = ["name" => "", "label" => T_("Big/Active Image (100x100)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" src="'.$fileImage2.'"><br/>'];
    $items[] = ["name" => "", "label" => T_("Image (64x64)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" src="'.$fileImage3.'"><br/>'];
    $items[] = ["name" => "", "label" => T_("Small Image (48x48)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" src="'.$fileImage4.'"><br/>'];
    $items[] = ["name" => "", "label" => T_("Small/Active Image (48x48)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" src="'.$fileImage5.'"><br/><br/>'];
    $items[] = ["name" => "", "label" => T_("Background Image (900x1200)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" width="300" height="400" src="'.$fileImage6.'"><br/><br/>'];
    $items[] = ["name" => "", "label" => T_("Top Image (960x230)"),  "type" => FormWidget::FORM_ITEM_LABEL, "validation" => "","value"=>'<img style="vertical-align:middle" width="480" height=115" src="'.$fileImage7.'"><br/><br/>'];
    $items[] = ["name" => "image", "label" => T_("Original Image (100x100)"),  "type" => FormWidget::FORM_ITEM_FILE, "validation" => "","value"=>""];
    $items[] = ["name" => "image_hover", "label" => T_("Hover Image (100x100)"),  "type" => FormWidget::FORM_ITEM_FILE, "validation" => "","value"=>""];
    $items[] = ["name" => "image_background", "label" => T_("Background Image (900x1200)"),  "type" => FormWidget::FORM_ITEM_FILE, "validation" => "","value"=>""];
    $items[] = ["name" => "image_top", "label" => T_("Top Image (960x230)"),  "type" => FormWidget::FORM_ITEM_FILE, "validation" => "","value"=>""];


    $buttons = [
        ["name" => "add", "icon" => "check", "label" => T_("Upload Images"), "type" => FormWidget::FORM_BUTTON_SUBMIT],
        ["name" => "cancel", "icon" => "cancel", "label" => T_("Cancel"), "type" => FormWidget::FORM_BUTTON_LINK, "url" => "categories.php"],
    ];

    $page->setContent($form->generate($items,$buttons));
    $page->show();

    die();
}

function handleImageUpload($id, $file, $file2, $file3, $file4) {

    if ($file["size"] == 0) {
        $file = null;
    } else {

        if ($file["type"] != "image/png") {
            die_notice("categories.php?images_entry=" . $id, T_("Invalid image type, please use a PNG file."));
        }

        if ($file["error"] != 0) {
            die_notice("categories.php?images_entry=" . $id, T_("An error happened while uploading the file:") . " " . $file["error"]);
        }
        $file = $file["tmp_name"];
    }

    if ($file2["size"] == 0) {
        $file2 = null;
    } else {

        if ($file2["type"] != "image/png") {
            die_notice("categories.php?images_entry=" . $id, T_("Invalid image type, please use a PNG file."));
        }

        if ($file2["error"] != 0) {
            die_notice("categories.php?images_entry=" . $id, T_("An error happened while uploading the file:") . " " . $file2["error"]);
        }
        $file2 = $file2["tmp_name"];
    }


    if ($file3["size"] == 0) {
        $file3 = null;
    } else {

        if ($file3["type"] != "image/png") {
            die_notice("categories.php?images_entry=" . $id, T_("Invalid image type, please use a PNG file."));
        }

        if ($file3["error"] != 0) {
            die_notice("categories.php?images_entry=" . $id, T_("An error happened while uploading the file:") . " " . $file3["error"]);
        }
        $file3 = $file3["tmp_name"];
    }

    if ($file4["size"] == 0) {
        $file4 = null;
    } else {

        if ($file4["type"] != "image/png") {
            die_notice("categories.php?images_entry=" . $id, T_("Invalid image type, please use a PNG file."));
        }

        if ($file4["error"] != 0) {
            die_notice("categories.php?images_entry=" . $id, T_("An error happened while uploading the file:") . " " . $file4["error"]);
        }
        $file4 = $file4["tmp_name"];
    }

    createCategoryImages($id, $file, $file2, $file3, $file4);
    die_notice("categories.php?images_entry=".$id,T_("The image file was successfully uploaded."));
}

/**
 * @param $category_id
 * @param $image_source
 */
function createCategoryImages($category_id, $image_source, $image_hover, $image_background, $image_top) {

    $imgOut4 = imagecreatetruecolor(48,48); // tinted
    $imgOut7 = imagecreatetruecolor(100,100);
    imagealphablending($imgOut4, false );
    imagesavealpha($imgOut4, true );
    imagealphablending($imgOut7, false );
    imagesavealpha($imgOut7, true );

    if ($image_source != null) {
        $imgSource = imagecreatefrompng($image_source);
        $imgOut1 = imagecreatetruecolor(100,100);
        $imgOut2 = imagecreatetruecolor(64,64);
        $imgOut3 = imagecreatetruecolor(48,48);

        imagefilter($imgSource, IMG_FILTER_GRAYSCALE);
        imagealphablending($imgOut1, false );
        imagesavealpha($imgOut1, true );
        imagealphablending($imgOut2, false );
        imagesavealpha($imgOut2, true );
        imagealphablending($imgOut3, false );
        imagesavealpha($imgOut3, true );
        imagecopyresampled($imgOut1,$imgSource,0,0,0,0,100,100,imagesx($imgSource), imagesy($imgSource));
        imagecopyresampled($imgOut2,$imgSource,0,0,0,0,64,64,imagesx($imgSource), imagesy($imgSource));
        imagecopyresampled($imgOut3,$imgSource,0,0,0,0,48,48,imagesx($imgSource), imagesy($imgSource));

        if ($image_hover == null) {

            // Tint the last one with some red.
            imagecopyresampled($imgOut4,$imgSource,0,0,0,0,48,48,imagesx($imgSource), imagesy($imgSource));
            imagecopyresampled($imgOut7,$imgSource,0,0,0,0,100,100,imagesx($imgSource), imagesy($imgSource));
            imagefilter($imgOut4, IMG_FILTER_COLORIZE, 128, 0, 0);
            imagefilter($imgOut7, IMG_FILTER_COLORIZE, 128, 0, 0);
        }
    }


    if ($image_hover != null) {
        $imgHover = imagecreatefrompng($image_hover);
        imagecopyresampled($imgOut4,$imgHover,0,0,0,0,48,48,imagesx($imgHover), imagesy($imgHover));
        imagecopyresampled($imgOut7,$imgHover,0,0,0,0,100,100,imagesx($imgHover), imagesy($imgHover));
        imagedestroy($imgHover);
    }


    if ($image_background != null) {
        $imgSourceBackground = imagecreatefrompng($image_background);
        $imgOut5 =imagecreatetruecolor(900,1200);
        $imgOut6 =imagecreatetruecolor(900,1200);
        imagealphablending($imgOut5, false );
        imagesavealpha($imgOut5, true );
        imagealphablending($imgOut6, false );
        imagesavealpha($imgOut6, true );
        imagecopyresampled($imgOut5,$imgSourceBackground,0,0,0,0,900,1200,imagesx($imgSourceBackground), imagesy($imgSourceBackground));
        imagecopyresampled($imgOut6,$imgSourceBackground,0,0,0,0,900,1200,imagesx($imgSourceBackground), imagesy($imgSourceBackground));
        imageflip($imgOut6,IMG_FLIP_HORIZONTAL);
    }

    $path = CONFIG_WEBSITE_PUBLIC_PATH."images/categories/".$category_id;

    if (file_exists($path) == false) {
        mkdir($path, 0755);
    }

    if ($image_top != null) {
        $imgSourceTop = imagecreatefrompng($image_top);
        $imgOut =imagecreatetruecolor(960,230);
        imagealphablending($imgOut, false );
        imagesavealpha($imgOut, true );
        imagecopyresampled($imgOut,$imgSourceTop,0,0,0,0,960,230,imagesx($imgSourceTop), imagesy($imgSourceTop));
        imagepng($imgOut, $path . "/top.png");
        imagedestroy($imgSourceTop);
        imagedestroy($imgOut);
    }



    if ($image_source != null) {
        imagepng($imgOut1, $path . "/big.png");
        imagepng($imgOut2, $path . "/normal.png");
        imagepng($imgOut3, $path . "/small.png");
        imagedestroy($imgSource);
        imagedestroy($imgOut1);
        imagedestroy($imgOut2);
        imagedestroy($imgOut3);
    }

    imagepng($imgOut4, $path . "/small_active.png");
    imagepng($imgOut7, $path . "/big_active.png");
    imagedestroy($imgOut4);
    imagedestroy($imgOut7);

    if ($image_background != null) {
        imagepng($imgOut5, $path . "/bg_left.png");
        imagepng($imgOut6, $path . "/bg_right.png");
        imagedestroy($imgSourceBackground);
        imagedestroy($imgOut5);
        imagedestroy($imgOut6);
    }


    if (file_exists($path."/small.png") && file_exists($path."/small_active.png")) {
        $imgOutput = imagecreatetruecolor(96,48);
        imagealphablending($imgOutput, false );
        imagesavealpha($imgOutput, true );

        $imgSmall = imagecreatefrompng($path."/small.png");
        $imgSmallActive = imagecreatefrompng($path."/small_active.png");

        imagecopy($imgOutput,$imgSmall,0,0,0,0,48,48);
        imagecopy($imgOutput,$imgSmallActive,48,0,0,0,48,48);

        imagepng($imgOutput,$path."/button_small.png");

        imagedestroy($imgSmall);
        imagedestroy($imgSmallActive);
        imagedestroy($imgOutput);

    }

    if (file_exists($path."/big.png") && file_exists($path."/big_active.png")) {
        $imgBig = imagecreatefrompng($path."/big.png");
        $imgBigActive = imagecreatefrompng($path."/big_active.png");
        $imgOutput = imagecreatetruecolor(200,100);
        imagealphablending($imgOutput, false );
        imagesavealpha($imgOutput, true );

        imagecopy($imgOutput,$imgBig,0,0,0,0,100,100);
        imagecopy($imgOutput,$imgBigActive,100,0,0,0,100,100);

        imagepng($imgOutput,$path."/button_big.png");

        imagedestroy($imgBig);
        imagedestroy($imgBigActive);
        imagedestroy($imgOutput);
    }

}

/**
 *
 */
function displaySuperTable()
{

    global $page, $DB;

    require_once("includes/classes/SuperTable.php");

    $parent_categories = $DB->select(["id", "label_en_US as name"], "tb_categories", ["parent", "=", -1], ["label_en_US ASC"]);
    $parent_categories = array_merge([["id" => -1, "name" => "---"]], $parent_categories);
    $replace_categories = [];
    $replace_categories[-1] = "---";
    for ($i = 0; $i < count($parent_categories); $i++) {
        $replace_categories[$parent_categories[$i]["id"]] = $parent_categories[$i]["name"];
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
                "label" => T_("Parent Category"),
                "column" => "parent",
                "table" => [
                    "width" => "120px",
                    "replace" => $replace_categories

                ],
                "form" => [
                    "type" => FormWidget::FORM_ITEM_SELECT,
                    "width" => "300px",
                    "validation" => "required",
                    "add" => true,
                    "modify" => true,
                    "value" => [
                        "source" => $parent_categories,
                        "selection" => -1
                    ]
                ]
            ],
            [
                "label" => T_("Name"),
                "column" => "label_en_US",
                "table" => [
                    "width" => "320px",
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
                "label" => T_("Name (French)"),
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
        ];


    class MySuperTable extends SuperTable
    {

        public function callbackAddValidate($items, $foreign_items)
        {

            global $DB;
            // Check if the internal name already exists
            if ($DB->getCount("tb_categories",
                    [
                        ["label_en_US", "=", $items["label_en_US"]],
                        "OR",
                        ["label_fr_CA", "=", $items["label_fr_CA"]]
                    ]) > 0) {
                return ["result" => false, "error" => T_("This name is already in use!")];
            }
            return ["result" => true, "error" => ""];
        }

        public function callbackModifyValidate($items, $foreign_items, $modify_id)
        {

            global $DB;
            // Check if the internal name already exists
            if ($DB->getCount("tb_categories", [
                    [["label_en_US", "=", $items["label_en_US"]],
                    "OR",
                    ["label_fr_CA", "=", $items["label_fr_CA"]]],
                    "AND",
                    ["id", "<>", $modify_id]
                ]) > 0
            ) {
                return ["result" => false, "error" => T_("This name is already in use!")];
            }
            return ["result" => true, "error" => ""];
        }

        public function callbackFilterRow($row)
        {
            $row["@image"] = '<img src="' . CONFIG_WEBSITE_PUBLIC_URL . 'images/categories/' . $row["id"] . '/small.png">';

            return $row;
        }


        /**
         * @param $items
         * @param $insert_id
         */
        public function callbackAddPost($items, $foreign_items, $insert_id)
        {

            // We generate custom images
            createCategoryImages($insert_id, CONFIG_WEBSITE_PUBLIC_PATH . "images/categories/no_image.png",null, CONFIG_WEBSITE_PUBLIC_PATH . "images/categories/no_background.png",CONFIG_WEBSITE_PUBLIC_PATH."images/categories/top_no_background.png");
        }


        /**
         * @param $delete_id id in tb_categories table
         */
        public function callbackDeletePost($delete_id)
        {

            global $DB;

             $files_to_delete = [
                CONFIG_WEBSITE_PUBLIC_PATH . "images/categories/" . $delete_id . "/normal.png",
                CONFIG_WEBSITE_PUBLIC_PATH . "images/categories/" . $delete_id . "/small.png",
                CONFIG_WEBSITE_PUBLIC_PATH . "images/categories/" . $delete_id . "/small_active.png"
            ];

            foreach ($files_to_delete as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $file = CONFIG_WEBSITE_PUBLIC_PATH."images/categories/".$delete_id;
            if (file_exists($file)) {
                recursive_rmdir($file);
            }

        }

    }

    $buttons = [];
    $buttons[] = ["id" => "images_entry", "label" => "", "icon" => "photo", "tooltip" => T_("Images"), "confirm" => false, "before" => true];


    $st = new MySuperTable("tb_categories");
    $st->setLabel("title_table", T_("System Category"));
    $st->setLabel("title_add", T_("Add Category"));
    $st->setLabel("button_add",T_("Add Category"));
    $st->setLabel("button_modify",T_("Modify Category"));

    $st->setFields($fields);
    $st->SetSortedColumn("id", "DESC");
    $st->setActions(true, true, true, $buttons);
    $st->setSearchable(true);
    $st->setFilter(T_("Parent Category"),"parent", $DB->select(["id","label_en_US as name"],"tb_categories", ["parent","=","-1"],["label_en_US ASC"]));
    $page->setContent($st->display());
    $page->show();

}

// Handle user requests

if ($INPUT->get->keyExists("images_entry")) {
    $id = $INPUT->get->noTags("images_entry");
    // Handle image upload
    if ($INPUT->files->keyExists("image")) {
        handleImageUpload($id, $INPUT->files->getValue("image"),$INPUT->files->getValue("image_hover"),$INPUT->files->getValue("image_background"),$INPUT->files->getValue("image_top"));
    }
    displayImagesForm($id);
}


displaySuperTable();

