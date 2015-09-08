<?php

require_once(__DIR__ . "/widgets/TableWidget.php");
require_once(__DIR__ . "/widgets/FormWidget.php");


class SuperTable {

    private $table = "";
    private $fields = [];
    private $action_add = false;
    private $action_modify = false;
    private $action_delete = false;
    private $action_custom = null;
    private $items_per_page = 20;
    private $session;
    private $labels = [];
    private $searchable = false;
    private $filter = null;
    private $payload = "";

    /**
     *
     */
    function  __construct($table) {

        global $INPUT;

        $this->setTable($table);

        if (isset($_SESSION[SI]["super"]) == false) {
            $_SESSION[SI]["super"] = [];
        }

        if (isset($_SESSION[SI]["super"][__FILE__]) == false) {
            $_SESSION[SI]["super"][__FILE__] = ["current_page"=>1];
        }

        if ($INPUT->get->keyExists("initial") == true) {
            $_SESSION[SI]["super"][__FILE__] = ["current_page"=>1];
        }

        if (!isset($_SESSION[SI]["super"][__FILE__]["order_column"])) {
            $_SESSION[SI]["super"][__FILE__]["order_column"] = $this->table.".id";
        }

        if (!isset($_SESSION[SI]["super"][__FILE__]["order_dir"])) {
            $_SESSION[SI]["super"][__FILE__]["order_dir"] = "ASC";
        }

        if (!isset($_SESSION[SI]["super"][__FILE__]["search"])) {
            $_SESSION[SI]["super"][__FILE__]["search"] = "";
        }

        if (!isset($_SESSION[SI]["super"][__FILE__]["filter"])) {
            $_SESSION[SI]["super"][__FILE__]["filter"] = -1;
        }

        $this->session = &$_SESSION[SI]["super"][__FILE__];

        $this->labels["title_table"] = T_("Entries");
        $this->labels["title_add"] = T_("Add Entry");
        $this->labels["title_modify"] = T_("Modify Entry");
        $this->labels["button_add"] = T_("Add Entry");
        $this->labels["button_modify"] = T_("Modify Entry");
        $this->labels["message_modified"] = T_("Entry successfully modified.");
        $this->labels["message_added"] = T_("Entry successfully added.");
    }

    function setItemsPerPage($items_per_page) {
        $this->items_per_page = $items_per_page;
    }

    /**
     * @param $add
     * @param $modify
     * @param $delete
     */
    function setActions($add, $modify, $delete, $custom = null) {
        $this->action_add = $add;
        $this->action_modify = $modify;
        $this->action_delete = $delete;
        $this->action_custom = $custom;
    }

    function setPayload($payload) {
        $this->payload = $payload;
    }

    function setLabel($key, $value) {
        $this->labels[$key] = $value;
    }

    /**
     * @param $table
     */
    function setTable($table) {
        $this->table = $table;
    }

    /**
     * @param $searchable
     */
    public function setSearchable($searchable) {
        $this->searchable = $searchable;
    }

    /**
     * @param $columns
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }

    public function setSortedColumn($sortColumn, $sortOrder) {
        $_SESSION[SI]["super"][__FILE__]["order_column"] = $sortColumn;
        $_SESSION[SI]["super"][__FILE__]["order_dir"] = $sortOrder;
    }

    public function setFilter($filterName, $filterColumn, $source) {

        $this->filter = ["name"=>$filterName,"column"=>$filterColumn,"source"=>$source];
    }


    /**
     * @return mixed
     */
    public function display() {

        $tpl = new Smarty;
        $tpl->muteExpectedErrors();
        $tpl->addPluginsDir("includes/smarty_plugins/");
        $tpl->template_dir = "templates/";
        $tpl->compile_dir = "templates_c/";
        $tpl->assign("payload", $this->payload);
        $tpl->assign("uniqid", uniqid());
        $tpl->assign("searchable",$this->searchable);
        $tpl->assign("table", $this->table);
        $tpl->assign("fields", $this->fields);
        $tpl->assign("labels",$this->labels);
        $tpl->assign("action_add",$this->action_add);
        $tpl->assign("action_modify",$this->action_modify);
        $tpl->assign("action_delete",$this->action_delete);
        return $this->displayTable($tpl);

    }


    /**
     * @param $id
     * @return string
     */
    public function displayModifyForm($form_items, $id) {

        global $DB, $INPUT;

        $form_items = $this->callbackFilterModifyItems($form_items, $id);

        $values = $DB->select("*",$this->table,["id","=",$id]);
        if (count($values) == 0) {
            die_notice($INPUT->server->noTags("SCRIPT_NAME"), T_("Invalid entry selected!"));
        }

        $values = $values[0];


        for ($i=0;$i<count($form_items);$i++) {

            if (array_key_exists($form_items[$i]["name"], $values)) {
                switch($form_items[$i]["type"]) {
                    case FormWidget::FORM_ITEM_AUTOCOMPLETE:
                        $form_items[$i]["value"]["text"] = $values[$form_items[$i]["name"]];
                        break;

                    case FormWidget::FORM_ITEM_SELECT:

                        $selection = $values[$form_items[$i]["name"]];
                        for ($j=0;$j<count($form_items[$i]["value"]);$j++) {
                            if ($form_items[$i]["value"][$j]["id"] == $selection) {
                                $form_items[$i]["value"][$j]["extra"] = "selected";
                            }
                        }
                        break;

                    case FormWidget::FORM_ITEM_CHECKGROUP:

                        $selection = $values[$form_items[$i]["name"]];
                        for ($j=0;$j<count($form_items[$i]["value"]);$j++) {
                            if ($form_items[$i]["value"][$j]["id"] == $selection) {
                                $form_items[$i]["value"][$j]["extra"] = "selected";
                            }
                        }

                        break;

                    default:

                        $form_items[$i]["value"] = $values[$form_items[$i]["name"]];

                }


            } else {

                // Foreign item or separator
                $column = $form_items[$i]["column"];
                if ($column == "") {
                    // separator
                } else {
                    $form_items[$i]["value"] = $DB->getSCalar($column["name"], $column["table"], [$column["key"], "=", $id]);
                }
            }

            if ($form_items[$i]["type"] == FormWidget::FORM_ITEM_WIDGET) {
                $form_items[$i]["value"]->load($id);

            }
        }


        // Creating form
        $formModify = new FormWidget($this->labels["title_modify"]." (#".$id.")", "?modify_entry_confirm=" . $id, FormWidget::FORM_METHOD_POST, "300px", "right","#666", true);
        $formModify->form_id = "modify_entry_".$id;
        $form_buttons = [
            ["name" => "add", "icon" => "check", "label" => $this->labels["button_modify"], "type" => FormWidget::FORM_BUTTON_SUBMIT],
            ["name" => "cancel", "icon" => "cancel", "label" => T_("Cancel"), "type" => FormWidget::FORM_BUTTON_LINK, "url" => "?initial"],
        ];



        return  $this->payload.$formModify->generate($form_items, $form_buttons);
    }

    /**
     * @param $tpl
     * @return mixed
     */
    public function displayTable($tpl) {

        global $DB, $INPUT;

        $fields = [];
        $fields[] = $this->table.".id";
        $table_columns = [];
        $table_columns[] = ["name"=>"id","db_name"=>"id"];
        $form_items_add = [];
        $form_items_modify = [];

        $tables = [$this->table];
        $where = [];

        if ($INPUT->get->keyExists("search")) {
            $this->session["search"] = $INPUT->get->noTags("search");
        }

        if ($INPUT->get->keyExists("filter")) {
            $this->session["filter"] = $INPUT->get->getInt("filter");
        }

        $search = $this->session["search"];

        $tpl->assign("search_keywords",$search);


        foreach($this->fields as $c) {
            if (isset($c["table"]) == true) {
                $item = [];
                $item["name"] = $c["label"];

                $add_to_fields = true;

                if ($c["column"][0] == '@') {
                    //we gently remove the @ from the field name to be ignored (PATCH WYZEMAN)
                    //for the class
                    $this->fields["column"] = substr($c["column"],- (strlen($c["column"]) -1));
                    //for this loop
                    $c["column"] = substr($c["column"],- (strlen($c["column"]) -1));

                    $add_to_fields = false;
                }

                if (is_array($c["column"])) {
                    $tables[] = $c["column"]["table"];
                    $item["db_name"] = $c["column"]["table"].".".$c["column"]["name"];
                    $where[] = [$this->table.".id","=","@".$c["column"]["table"].".".$c["column"]["key"]];
                } else {
                    $item["db_name"] = $this->table.".".$c["column"];
                }

                if ($add_to_fields == true) {
                    $fields[] = $item["db_name"];
                }

                if (isset($c["table"]["width"])) {
                    $item["width"] = $c["table"]["width"];
                }
                if (isset($c["table"]["replace"])) {
                    $item["replace"] = $c["table"]["replace"];
                }

                $table_columns[] = $item;
            }

            if ((isset($c["form"]) == true)) {

                $width = 100;
                $height = 60;


                if (isset($c["form"]["width"])) {
                    $width = $c["form"]["width"];
                }

                if (isset($c["form"]["height"])) {
                    $height = $c["form"]["height"];
                }

                $item = [
                    "width" => $width,"height"=>$height, "name" => $c["column"], "column"=>$c["column"],"label" => $c["label"],  "type" => $c["form"]["type"], "validation" => $c["form"]["validation"]
                ];
                if (is_array($item["name"])) {
                    $item["name"] = $item["name"]["name"];
                }


                if ($item["type"] == FormWidget::FORM_ITEM_SELECT) {
                    $item["value"] = $c["form"]["value"]["source"];

                    for ($i=0;$i<count($item["value"]);$i++) {



                        if ($item["value"][$i]["id"] == $c["form"]["value"]["selection"]) {
                            $item["value"][$i]["extra"] = "selected";
                        } else {
                            $item["value"][$i]["extra"] = "";
                        }
                    }
                    $column_name = "";
                    if (is_array($c["column"])) {
                        $column_name = $c["column"]["name"];
                    } else {
                        $column_name = $c["column"];
                    }

                    if (!isset($this->session[$column_name])) {
                        $this->session[$column_name] = $c["form"]["value"]["selection"];
                    }
                } else {
                    $item["value"] = $c["form"]["value"];
                    $column_name = "";
                    if (is_array($c["column"])) {
                        $column_name = $c["column"]["name"];
                    } else {
                        $column_name = $c["column"];
                    }
                    if (!isset($this->session[$column_name])) {
                        $this->session[$column_name] = $item["value"];
                    }
                }

                if ($c["form"]["add"] == true) {
                    $form_items_add[] = $item;
                }


                if ($c["form"]["modify"] == true) {
                    $form_items_modify[] = $item;
                }

            }
        }


        $buttons = [];
        if ($this->action_modify == true) {
            $buttons[] = ["id" => "modify_entry", "label" => "", "icon" => "pencil", "tooltip" => T_("Edit"),"confirm"=>false];
        }

        if ($this->action_delete == true) {
            $buttons[] = ["id" => "delete_entry", "label" => "", "icon" => "trash", "tooltip" => T_("Delete"), "confirm"=>true];
        }

        if (count($this->action_custom) > 0) {
            foreach($this->action_custom as $custom) {
                if (isset($custom["before"]) && ($custom["before"]==true)) {
                    array_unshift($buttons, $custom);
                } else {
                    $buttons[] = $custom;
                }
            }
        }
        $tpl->assign("callbacks", $buttons);


        // Adding where elements
        if ($search != "") {
            if (count($where) > 0) {
                $where[] = "AND";
            }

            $search_where = [];

            for ($i=0;$i<count($fields);$i++) {

                $search_where[] = [$fields[$i],"LIKE","%".$search."%"];
                if ($i < count($fields)-1) {
                    $search_where[] = "OR";
                }

            }
            $where[] = $search_where;
        }

        for ($i=0;$i<count($this->filter["source"]);$i++) {
            if ($this->filter["source"][$i]["id"] == $this->session["filter"]) {
                $this->filter["source"][$i]["extra"] = "selected";
            } else {
                $this->filter["source"][$i]["extra"] = "";
            }
        }

        if ($this->filter != null) {
            $tpl->assign("filter", $this->filter);
        }

        if ($this->session["filter"] != -1) {

            if (count($where) > 0) {
                $where[] = "AND";
            }
            $where[] = [$this->filter["column"],"=",$this->session["filter"]];
        }

        if ($INPUT->get->keyExists("order_by")) {
            $_SESSION[SI]["super"][__FILE__]["order_column"] = $INPUT->get->noTags("order_by");
        }

        if ($INPUT->get->keyExists("order_dir")) {
            $_SESSION[SI]["super"][__FILE__]["order_dir"] = $INPUT->get->noTags("order_dir");
        }

        $oc = $_SESSION[SI]["super"][__FILE__]["order_column"];
        $od = $_SESSION[SI]["super"][__FILE__]["order_dir"];

        if ($INPUT->get->keyExists("table_page")) {
            $_SESSION[SI]["super"][__FILE__]["current_page"] = $INPUT->get->getInt("table_page");
        }
        $current_page = $_SESSION[SI]["super"][__FILE__]["current_page"];

        $count_total = $DB->getCount($tables, $where, "");
        $tpl->assign("count_total",$count_total);

        $items = $DB->select($fields, $tables, $where, array($oc . " " . $od), "LIMIT ".($this->items_per_page * ($current_page-1)).",".$this->items_per_page);
        $j=0;
        for ($i=0;$i<count($items);$i++) {

            $items[$i]["background_color"] = ($i%2==0?"#e9e9e9":"#f0f0f0");

            $items[$i] = $this->callbackFilterRow($items[$i]);

/*            if ($items[$i] != "skip") {

                $tmp[$j] = $items[$i];
                $j++;

            }*/
        }
/*
        unset($items);
        $items = $tmp;*/

        // Remove tables from columns in table columns
        for ($i=0;$i<count($table_columns);$i++) {
            $v = explode(".", $table_columns[$i]["db_name"]);
            $v = $v[count($v)-1];
            $table_columns[$i]["db_name"] = $v;
        }

        $table = new TableWidget($items, T_("No data!"), $buttons);
        $table->setTableId("supertable_".$this->table);
        $table->setActionsWidth(count($buttons)*20);

        $count_pages = $count_total / $this->items_per_page;

        $tpl->assign("table", $table->generate($table_columns,"id",$current_page,$count_pages,$oc, $od));

        if ($this->action_modify == true) {

            if ($INPUT->get->keyExists("modify_entry")) {

                return $this->displayModifyForm($form_items_modify, $INPUT->get->getInt("modify_entry"));
            }


            if ($INPUT->get->keyExists("modify_entry_confirm")) {

                $this->handleModifyEntry($form_items_modify, $INPUT->get->getInt("modify_entry_confirm"));
            }

        }

        if ($this->action_add == true) {

            if ($INPUT->get->keyExists("add_entry") == true) {
                $this->handleAddEntry($form_items_add);
            }

            // Creating form
            $formAdd = new FormWidget("", "?add_entry", FormWidget::FORM_METHOD_POST, "300px", "right","#666", true);
            $formAdd->form_id = "add_entry";

            $form_buttons = [
                ["name" => "add", "icon" => "check", "label" => $this->labels["button_add"], "type" => FormWidget::FORM_BUTTON_SUBMIT],
                ["name" => "cancel", "icon" => "cancel", "label" => T_("Cancel"), "type" => FormWidget::FORM_BUTTON_LINK, "url" => "?initial"],
            ];

            $tpl->assign("form_add", $formAdd->generate($form_items_add, $form_buttons));
        }

        if ($this->action_delete == true) {
            if ($INPUT->get->keyExists("delete_entry") == true) {

                $item_id = $INPUT->get->noTags("delete_entry");
                $this->callbackDeletePre($item_id);
                $this->handleDeleteEntry($item_id);
                $this->callbackDeletePost($item_id);

                die_notice($INPUT->server->noTags("SCRIPT_NAME"),T_("Entry successfully deleted"));
            }
        }

        return $tpl->fetch("super_table.tpl");
    }


    /**
     * @param $form_items
     */
    public function handleAddEntry($form_items) {

        global $DB,$INPUT;

        $insert_items = [];
        $objects_items = [];
        $foreign_items = [];
        foreach($form_items as $key => $item) {

            // Separator
            if (($item["column"] != "") && is_array($item["column"])) {
                if ($item["type"] == FormWidget::FORM_ITEM_CHECKBOX) {
                    $foreign_items[$key] = $INPUT->post->keyExists($item["name"]);
                } else if ($item["type"] == FormWidget::FORM_ITEM_CHECKGROUP) {
                    $foreign_items[$key] = $INPUT->post->keyExists($item["name"]);
                } else if ($item["type"] == FormWidget::FORM_ITEM_PHONENUMBER) {
                    $value = $INPUT->post->noTags($item["name"]);
                    $value = str_replace("(", "", $value);
                    $value = str_replace(")", "", $value);
                    $value = str_replace("-", "", $value);
                    $value = str_replace(" ", "", $value);
                    $foreign_items[$key] = $value;
                } else {
                    $foreign_items[$key] = $INPUT->post->noTags($item["name"]);
                }

            } else {

                if (($item["column"] == "") && $item["type"] == FormWidget::FORM_ITEM_WIDGET) {
                    $objects_items[] = $item["value"];
                } else if (($item["column"] != "") && $item["type"] == FormWidget::FORM_ITEM_CHECKBOX) {
                    $insert_items[$item["name"]] = $INPUT->post->keyExists($item["name"]);
                } else if (($item["column"] != "") && $item["type"] == FormWidget::FORM_ITEM_CHECKGROUP) {
                    $insert_items[$item["name"]] = $INPUT->post->keyExists($item["name"]);
                    error_log("mooo");
                } else if (($item["column"] != "") && $item["type"] == FormWidget::FORM_ITEM_PHONENUMBER) {
                    $value = $INPUT->post->noTags($item["name"]);
                    $value = str_replace("(", "", $value);
                    $value = str_replace(")", "", $value);
                    $value = str_replace("-", "", $value);
                    $value = str_replace(" ", "", $value);
                    $insert_items[$item["name"]] = $value;
                } else if ($item["column"] != "") {
                    $insert_items[$item["name"]] = $INPUT->post->noTags($item["name"]);
                }
            }
        }
        error_log("test");

        $validation = $this->callbackAddValidate($insert_items, $foreign_items);
        if ($INPUT->get->keyExists("validate_add_entry")) {
            die(json_encode($validation));
        }

        if ($validation["result"] == false) {
            die("Fatal error: " .$validation["error"]);
        }

        foreach($objects_items as $object) {
            $object->callbackAddPre($insert_items, $foreign_items);
        }
        $insert_items = $this->callbackAddPre($insert_items, $foreign_items);

        $DB->beginTransaction();
        $insert_id = $DB->insert($this->table, $insert_items);

        // Update foreign items
        $foreign_tables = [];
        foreach($foreign_items as $key => $value) {

            $item = $form_items[$key];
            $column = $item["column"];

            if (isset($foreign_tables[$column["table"]])) {

                $foreign_tables[$column["table"]]["fields"][$column["name"]] = $value;

            } else {
                $foreign_tables[$column["table"]] = [

                    "fields" => [
                        $column["key"] => $insert_id,
                        $column["name"] => $value,
                    ],
                ];
            }
        }

        foreach($foreign_tables as $key => $value) {

            $DB->insert($key, $value["fields"]);
        }

        foreach($objects_items as $object) {
            $object->callbackAddPost($insert_items, $foreign_items, $insert_id);
        }

        $this->callbackAddPost($insert_items, $foreign_items, $insert_id);

        $DB->endTransaction();
        die_notice($INPUT->server->noTags("SCRIPT_NAME"),$this->labels["message_added"]);
    }


    /**
     * @param $id
     */
    public function handleModifyEntry($form_items, $id) {
        global $DB,$INPUT;

        $update_items = [];
        $objects_items = [];
        $foreign_items = [];

        foreach($form_items as $key => $item) {

            if (($item["column"] != "") && is_array($item["column"])) {
                if ($item["type"] == FormWidget::FORM_ITEM_CHECKBOX) {
                    $foreign_items[$key] = $INPUT->post->keyExists($item["name"]);
                } else if ($item["type"] == FormWidget::FORM_ITEM_CHECKGROUP) {
                    $foreign_items[$key] = $INPUT->post->keyExists($item["name"]);
                } else {
                    $foreign_items[$key] = $INPUT->post->noTags($item["name"]);
                }

            } else {
                if (($item["column"] == "") && $item["type"] == FormWidget::FORM_ITEM_WIDGET) {
                    $objects_items[] = $item["value"];
                } else if (($item["column"] != "") && $item["type"] == FormWidget::FORM_ITEM_CHECKBOX) {
                    $update_items[$item["name"]] = $INPUT->post->keyExists($item["name"]);
                } else if (($item["column"] != "") && $item["type"] == FormWidget::FORM_ITEM_CHECKGROUP) {
                    $update_items[$item["name"]] = $INPUT->post->keyExists($item["name"]);
                } else if ($item["column"] != "") {
                    $update_items[$item["name"]] = $INPUT->post->noTags($item["name"]);
                }
            }
        }


        $validation = $this->callbackModifyValidate($update_items, $foreign_items, $id);
        if ($INPUT->get->keyExists("validate_modify_entry_".$id)) {

            die(json_encode($validation));

        }

        if ($validation["result"] == false) {
            die("Fatal error: " .$validation["error"]);
        }

        foreach($objects_items as $object) {
            $object->callbackModifyPre($update_items, $foreign_items);
        }
        $update_items = $this->callbackModifyPre($update_items, $foreign_items, $id);

        $DB->update($this->table, $update_items, ["id","=",$id]);
        foreach($objects_items as $object) {
            $object->callbackModifyPost($update_items,$foreign_items, $id);
        }

        // Update foreign items
        foreach($foreign_items as $key => $value) {

            $item = $form_items[$key];
            $table = $item["column"]["table"];
            $values = [$item["column"]["name"]=>$value];
            $where = [$item["column"]["table"].".".$item["column"]["key"],"=",$id];

            $DB->update($table, $values,$where);
        }

        $this->callbackModifyPost($update_items, $foreign_items, $id);

        die_notice($INPUT->server->noTags("SCRIPT_NAME"),$this->labels["message_modified"]);

    }

    /**
     *
     */
    public function handleDeleteEntry($item_id) {
        global $DB;
        $DB->delete($this->table, array("id","=",$item_id));
    }


    public function callbackAddValidate($items, $foreign_items) {

        return ["result"=>true, "error"=>""];
    }

    /**
     *
     */
    public function callbackAddPre($items, $foreign_items) {
        return $items;
    }

    /**
     *
     */
    public function callbackAddPost($items,  $foreign_items, $insert_id) {
    }


    /**
     *
     */
    public function callbackModifyValidate($items, $foreign_items, $modify_id) {

        return ["result"=>true, "error"=>""];
    }

    /**
     *
     */
    public function callbackModifyPre($items, $foreign_items, $modify_id) {

        return $items;
    }

    /**
     *
     */
    public function callbackModifyPost($items, $foreign_items, $modify_id) {
    }

    /**
     *
     */
    public function callbackDeletePre($delete_id) {

    }

    /**
     *
     */
    public function callbackDeletePost($delete_id) {
    }

    /**
     *
     */
    public function callbackFilterRow($row) {
        return $row;
    }

    /**
     *
     */
    public function callbackFilterModifyItems($form_items, $id) {
        return $form_items;
    }

}
