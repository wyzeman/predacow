<?php


interface FormWidgetInterface
{
    public function display();
    public function load($id);
    public function callbackAddPre($items, $foreign_items);
    public function callbackAddPost($items, $foreign_items, $insert_id);
    public function callbackModifyPre($items, $foreign_items);
    public function callbackModifyPost($items, $foreign_items, $insert_id);

}