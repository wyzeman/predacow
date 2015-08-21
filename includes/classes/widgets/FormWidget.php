<?php


class FormWidget {

    const FORM_METHOD_GET = 0;
    const FORM_METHOD_POST = 1;
    const FORM_METHOD_AJAX = 2;

    const FORM_ITEM_INPUT = 0;
    const FORM_ITEM_TEXTAREA = 1;
    const FORM_ITEM_CHECKBOX = 2;
    const FORM_ITEM_LABEL = 3;
    const FORM_ITEM_SELECT = 4;
    const FORM_ITEM_PASSWORD = 5;
    const FORM_ITEM_READONLY = 6;
    const FORM_ITEM_NOTICE = 7;
    const FORM_ITEM_HIDDEN = 8;
    const FORM_ITEM_FILE = 9;
    const FORM_ITEM_AUTOCOMPLETE = 10;
    const FORM_ITEM_WIDGET = 11;
    const FORM_ITEM_PHONENUMBER = 12;
    const FORM_ITEM_SEPARATOR = 13;
    const FORM_ITEM_CHECKGROUP = 14;

    const FORM_BUTTON_SUBMIT = 0;
    const FORM_BUTTON_RESET = 1;
    const FORM_BUTTON_LINK = 2;
    const FORM_BUTTON_DUMMY = 3;
    const FORM_BUTTON_JAVASCRIPT = 4;
    

    private $title = "";
    private $url = "";
    private $method = "";
    public $form_id = "";
    private $label_width = 0;
    private $label_align = "left";
    private $label_color = "black";
    private $ajax_validation = false;

    function __construct($title = "", $url = "", $method = FormWidget::FORM_METHOD_GET, $label_width = 0, $label_align="left", $label_color = "#666", $ajax_validation = false)
    {
        $this->title = $title;
        $this->url = $url;
        $this->label_align = $label_align;
        $this->label_width = $label_width;
        $this->label_color = $label_color;
        $this->ajax_validation = $ajax_validation;

        if (($method < FormWidget::FORM_METHOD_GET) || ($method > FormWidget::FORM_METHOD_AJAX)) die(trigger_error(T_("Invalid form method!")));
        $this->method = $method;
        $this->form_id = uniqid();

    }
 
    
    function generate($items = array(), $buttons = array())
    {

        // Handle autocomplete
        global $INPUT;
        if ($INPUT->get->keyExists("autocomplete") && ($INPUT->get->keyExists("term"))) {
            $term = $INPUT->get->noTags("term");
            $item_name = $INPUT->get->noTags("autocomplete");


            foreach ($items as $item) {

                if ($item["type"] == FormWidget::FORM_ITEM_AUTOCOMPLETE) {

                    if ($item["name"] == $item_name) {
                        die(json_encode(call_user_func($item["value"]["source"], $term)));
                    }
                }

            }
            die(json_encode([T_("*** Invalid request ***")]));
        }

        $TPL = new Smarty();
        $TPL->muteExpectedErrors();
        $TPL->addPluginsDir("includes/smarty_plugins/");

        $TPL->template_dir = "templates/";
        $TPL->compile_dir = "templates_c/";

        $TPL->assign("label_width", $this->label_width);
        $TPL->assign("label_align", $this->label_align);
        $TPL->assign("label_color", $this->label_color);
        $TPL->assign("form_title", $this->title);
        $TPL->assign("ajax_validation", $this->ajax_validation);
        $TPL->assign("form_url", $this->url);
        $form_url_ajax = $this->url;
        if (strlen($form_url_ajax) > 0) {
            if ($form_url_ajax[strlen($form_url_ajax) - 1] != '&') {
                $form_url_ajax  .= '&validate_' . $this->form_id;
            } else {
                $form_url_ajax  .= '?validate_' . $this->form_id;

            }
        }
        $TPL->assign("form_url_ajax",$form_url_ajax);
        $TPL->assign("form_id",$this->form_id);
        $TPL->assign("form_method",($this->method == FormWidget::FORM_METHOD_GET?"GET":"POST"));

        foreach($items as $key => $item) {

            if ($item["type"] == FormWidget::FORM_ITEM_WIDGET) {

                $value = $item["value"]->display();
                $items[$key]["value"] = $value;
            }
        }

        $TPL->assign("items", $items);
        $TPL->assign("buttons",$buttons);
        return $TPL->fetch("widget_form.tpl");
    }
}



