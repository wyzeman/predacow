<?php

define("NO_BUTTONS",-1);

class TableWidget {

    private $db_source = "";
    private $buttons = array();
    private $empty_message = "";
    private $actions_width = "190";
    public $table_id = 0;
    private $class = "ui-state-default";
    private $sortable = true;

    
    function __construct($db_source,$empty_message = "No data!",$buttons = null, $class = "ui-state-default") {
        $this->db_source = $db_source;
        $this->empty_message = $empty_message;
        $this->table_id = uniqid();
        $this->class = $class;
        
        if (is_array($buttons) == false) {
            $buttons = array(
                array("id"=>"modify","label"=>"","icon"=>"pencil","tooltip"=>T_("Edit")),
                array("id"=>"delete","label"=>"","icon"=>"trash","tooltip"=>T_("Delete"))
                );
            $this->buttons = $buttons;
        } else {
            if (is_array($buttons)) {
                $this->buttons = $buttons;
            }
        }
    }

    function setSortable($sortable) {
        $this->sortable = $sortable;
    }
    function setActionsWidth($width)
    {
        $this->actions_width = $width;
    }

    function setTableId($id) {
        $this->table_id = $id;
    }

    function generate($columns,$id_name="id",$current_page=-1, $total_pages = -1, $order_by="id",$order_dir="DESC") {

        global $DB;

        $TPL = new Smarty();
        $TPL->muteExpectedErrors();
        $TPL->addPluginsDir("includes/smarty_plugins/");

        $TPL->template_dir = "templates/";
        $TPL->compile_dir = "templates_c/";
        $TPL->assign("columns",$columns);
        $TPL->assign("show_actions",(($this->actions_width > 0) && (count($this->buttons) > 0)));
        $TPL->assign("empty_message",$this->empty_message);
        $TPL->assign("actions_width", $this->actions_width);
        $TPL->assign("table_id", $this->table_id);
        $TPL->assign("current_page",$current_page);
        $TPL->assign("total_pages",$total_pages);
        $TPL->assign("class",$this->class);
        $TPL->assign("sortable", $this->sortable);

        $order = explode(".",$order_by);
        if (count($order) > 1) {
            $order_by = $order[1];
        }
        $TPL->assign("order_by",$order_by);
        
        $TPL->assign("order_dir",$order_dir);
        
        
        $values = array();
        // We build an multi-dimensionnal array containing a row per user with predefined columns
        $data = $this->db_source;
        
        for ($i=0;$i<count($data);$i++) {

            $item = array();
            $editable = array();
            
            for ($j=0;$j<count($columns);$j++) {

                $dbName = $columns[$j]["db_name"];
                $v = "";


                if (is_array($dbName)) {

                    $v = $data[$i][$dbName["table"].".".$dbName["name"]];
                    
                } else {
                    $v = $data[$i][$dbName];
                }

                if (isset($columns[$j]["replace"])) {

                    reset($columns[$j]["replace"]);
                    while(list($key,$value) = each($columns[$j]["replace"])) {
                        if ($key == $v) {
                            $v = $value;
                            break;
                        }

                    }
                }

                if (isset($columns[$j]["replace"])) {

                    $replace = $columns[$j]["replace"];
                    reset($replace);
                    while(list($key,$value) = each($replace)) {
                        if ($key == $v) {
                            $v = str_replace($key,$value,$v);
                            break;
                        }
                    }
                }

                $ed = 0;
                 if (isset($columns[$j]["editable"])) {
                    if ($columns[$j]["editable"] == true) {
                        if (isset($columns[$j]["width"]))
                            $ed = $columns[$j]["width"];
                        else
                            $ed= "100px";
                    }
                }
                if ($ed == 0)
                    if ($v == "")
                        $v = "---";
                
                $item[] = $v;
                $editable[] = $ed;

            }
            

            $payload = array();
            $payload["id"] = $data[$i][$id_name];
            $payload["data"] = $item;
            
            if (isset($data[$i]["background_color"])) {
               $payload["background_color"] = $data[$i]["background_color"];
            }

            for ($z=0;$z<3;$z++) {
                $label = "button".($z+1)."_label";
                if (isset($data[$i][$label])) {
                   $payload[$label] = $data[$i][$label];
                }
            }
            $payload["editable"] = $editable;

            $values[] = $payload;
        }


        
        $TPL->assign("values",$values);
        $TPL->assign("buttons", $this->buttons);
        return $TPL->fetch("widget_table.tpl");

    }
}
