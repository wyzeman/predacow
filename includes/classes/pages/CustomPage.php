<?php


/**
 *
 */
class CustomPage {

    private $menuItems = array();
    private $content = "Undefined";
    private $menuPosition = 0;
    private $subMenuPosition = 0;
    private $title = "";
    private $minimal = false;
    private $cancel_url = "";

    /**
     * Object constructor
     */
    function __construct($requiredUserLevel=-1,$cancel_url = "index.php", $minimal = false) {

        global $TPL;

        $currentUserLevel = -1;
        if (isset($_SESSION[SI]["user"])) {
            $currentUserLevel = $_SESSION[SI]["user"]["user_level"];
        }

        if ($currentUserLevel < $requiredUserLevel) die(header("Location: $cancel_url"));

        $this->minimal = $minimal;
        
        $TPL->assign("current_userlevel",$currentUserLevel);
    }


    /**
     * Set menu for this custom page.
     *
     * Each menu item is an array in this form:
     * array('label'=>'Logoff','img'=>'', 'url'='index.php?logoff', 'user_level'=>0);
     *
     * The menu items array is not sorted.
     *
     * @param <Array> $menuItems An array of menu items.
     */
    function setMenu($menuItems) {

        global $INPUT;

        $this->menuItems = $menuItems;

        $filename = explode("/",$INPUT->server->noTags("PHP_SELF"));
        $filename = $filename[count($filename)-1];
        // Auto-detect selection!
        $user_level = $_SESSION[SI]["user"]["user_level"];

        $count = 0;
        for($i=0;$i<count($menuItems);$i++) {

            if ($menuItems[$i]["user_level"] <= $user_level) {

                if ($menuItems[$i]["url"] == $filename) {
                    $this->setMenuPosition($count);
                    return;
                }

                if (isset($menuItems[$i]["sub_items"])) {
                    $count2 = 0;
                    foreach($menuItems[$i]["sub_items"] as $subItem) {
                        if ($subItem["url"] == $filename) {
                            $this->setMenuPosition($count);
                            $this->setSubMenuPosition($count2);
                        }
                        $count2++;
                    }
                }
                $count++;
            }
        }


    }


    function setTitle($title) {
        $this->title = $title;
    }

    /**
     *
     * @param <type> $content
     */
    function setContent($content) {
        $this->content = $content;
    }

    function setMenuPosition($position) {
        $this->menuPosition = $position;
    }


    function setSubMenuPosition($position) {
        $this->subMenuPosition = $position;
    }

    function setMenuSelected($position) {

        for ($i=0;$i<count($this->menuItems);$i++) {
            if ($position == $i)
                $this->menuItems[$i]["selected"] = true;
            else
                $this->menuItems[$i]["selected"] = false;
        }
    }

    /**
     *
     */
    function show($tpl_name = "page_custom.tpl", $minimal = "page_custom_minimal.tpl") {

        global $INPUT, $TPL;

        $script_name = explode("/",str_replace("\\","/",$INPUT->server->getRaw("SCRIPT_NAME")));
        $script_name = $script_name[count($script_name)-1];
        $TPL->assign("current_script", $script_name);
        $TPL->assign("content",$this->content);
        $TPL->assign("title",$this->title);


        $TPL->assign("menu_items",$this->menuItems);
        $TPL->assign("menu_position", $this->menuPosition);
        $TPL->assign("submenu_position", $this->subMenuPosition);

        if ($this->minimal == false)
            $TPL->display($tpl_name);
        else
            $TPL->display($minimal);


    }

}
