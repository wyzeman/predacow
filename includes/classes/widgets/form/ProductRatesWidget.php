<?php

require_once("FormWidgetInterface.php");

class ProductRatesWidget implements FormWidgetInterface {


    public function __construct() {
        $_SESSION[SI]["product_rates"] = [];
        for ($i=1;$i<=10;$i++) {
            $qty = "rate_quantity_" . $i;
            $price = "rate_price_" . $i;

            $_SESSION[SI]["product_rates"][$qty] = 0;
            $_SESSION[SI]["product_rates"][$price] = 0;

        }
    }

    public function display()
    {
        $tpl = new Smarty();

        for ($i=1;$i<=10;$i++) {
            $qty = "rate_quantity_".$i;
            $price = "rate_price_".$i;

            $tpl->assign($qty, $_SESSION[SI]["product_rates"][$qty]);
            $tpl->assign($price, $_SESSION[SI]["product_rates"][$price]);
        }


        return $tpl->fetch("widget_product_rates.tpl");

    }

    public function load($id)
    {
        global $DB;
        $fields = [];
        for ($i=1;$i<=10;$i++) {
            $fields[] = "rate_quantity_".$i;
            $fields[] = "rate_price_".$i;
        }
        $items = $DB->select($fields,"tb_products", ["id","=",$id]);
        $_SESSION[SI]["product_rates"] = $items[0];
    }

    public function callbackAddPre($items, $foreign_items)
    {
    }

    public function callbackAddPost($items, $foreign_items, $insert_id)
    {
        global $INPUT,$DB;

        $fields = [];
        for ($i=1;$i<=10;$i++) {
            $fields["rate_quantity_".$i] = $INPUT->post->noTags("rate_quantity_".$i);
            $fields["rate_price_".$i] = $INPUT->post->noTags("rate_price_".$i);
        }
        $DB->update("tb_products", $fields, ["id","=",$insert_id]);

    }

    public function callbackModifyPre($items, $foreign_items)
    {
    }

    public function callbackModifyPost($items, $foreign_items, $insert_id)
    {
        global $INPUT,$DB;

        $fields = [];
        for ($i=1;$i<=10;$i++) {
            $fields["rate_quantity_".$i] = $INPUT->post->noTags("rate_quantity_".$i);
            $fields["rate_price_".$i] = $INPUT->post->noTags("rate_price_".$i);
        }

        $DB->update("tb_products", $fields, ["id","=",$insert_id]);
    }
}