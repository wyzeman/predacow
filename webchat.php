<?php

require_once("includes/init.php");
require_once("includes/classes/pages/CustomPage.php");
//security_check(false, "index.php");

// Handle toggling
if ($INPUT->post->keyExists("toggle") == true) {
    $opened = $INPUT->post->getInt("toggle");
    $DB->update("tb_webchat", array("opened" => $opened), array("id_user", "=", $_SESSION[SESSION_IDENTIFIER]["user"]["id"]));
    die("SUCCESS");
}

// Handle open chat room
if ($INPUT->post->keyExists("open_chatroom")) {

    $chatroom = $INPUT->post->getInt("open_chatroom");
    $real_name = $INPUT->post->noTags("real_name");

    if ($DB->getCount("tb_webchat_chatrooms", array(array("id_user", "=", $_SESSION[SESSION_IDENTIFIER]["user"]["id"]), "AND", array("chatroom_id", "=", $chatroom))) == 0) {

        $DB->insert("tb_webchat_chatrooms", array("id_user" => $_SESSION[SESSION_IDENTIFIER]["user"]["id"], "chatroom_id" => $chatroom, "name" => $real_name));
    }

    die("SUCCESS");
}

// Handle close chat room
if ($INPUT->post->keyExists("close_chatroom")) {

    $chatroom = $INPUT->post->getInt("close_chatroom");
    $DB->delete("tb_webchat_chatrooms", array(array("id_user", "=", $_SESSION[SI]["user"]["id"]), "AND", array("chatroom_id", "=", $chatroom)));

    die("SUCCESS");
}

// Handle send
if ($INPUT->post->keyExists("send_chatroom")) {
    
    $chatroom = $INPUT->post->getInt("send_chatroom");
    $message = $INPUT->post->noTags("message");
    $timestamp = time();

    if ($message != "") {
        $items = array();
        $items["timestamp"] = $timestamp;
        $items["username"] = $_SESSION[SI]["user"]["username"];
        $items["message"] = $message;
        $items["channel"] = $chatroom;

        $DB->insert("tb_chat", $items);
        
        // Create unseen entries
        $users = $DB->select("id","tb_users", array("deleted","=",0));

        foreach($users as $user) {

             if ($user["id"] == $_SESSION[SESSION_IDENTIFIER]["user"]["id"]) {
                 continue;
             }

             $DB->insert("tb_chat_unseens", array("channel"=>$chatroom, "id_user"=>$user["id"],"timestamp"=>$timestamp));
         }

 
    }
}

// Handle refresh
if ($INPUT->post->keyExists("refresh") == true) {

    $output = array();
    $output["result"] = "SUCCESS";


    $time_expiration = time() - CONFIG_SESSION_IDLE_TIME;
    $output["users_connected"] = $DB->getCount("tb_sessions", array(array("id_user", "!=", $_SESSION[SESSION_IDENTIFIER]["user"]["id"]), "AND", array("timestamp_last_activity", ">=", $time_expiration)));

    $table = build_webchat_users_table();
    $output["total_unseens"] = $table["total_unseens"];
    $output["table_webchat"] = base64_encode($table["output"]);

    $rooms = $DB->select("*", "tb_webchat_chatrooms", array("id_user", "=", $_SESSION[SESSION_IDENTIFIER]["user"]["id"]));
    foreach ($rooms as $key => $room) {

        // Fetch chat!
        $items = $DB->select("*", "tb_chat", array("channel", "=", $rooms[$key]["chatroom_id"]), array("id DESC"), "LIMIT 0,20");
        $outputMessages = "";
        $items = array_reverse($items);

        foreach ($items as $item) {

            if ($item["username"] == $_SESSION[SESSION_IDENTIFIER]["user"]["username"]) {
 
                $elapsed_time = elapsed_time(time()-$item["timestamp"], true); 
                $outputMessages .= "<div class=\"div_webchat_message_from_you speechbubble_me ui-corner-all\"><span style=\"font-size:10px;color:#666;float:right\">".$elapsed_time."</span>" . $item["message"] . "</div>";
 
                } else {
                
                    $elapsed_time = elapsed_time(time()-$item["timestamp"], true);
 
                if ($rooms[$key]["chatroom_id"] < 0) {
                    $item["real_name"] = $DB->getScalar("real_name", "tb_users", array("username", "=", $item["username"]));
                    $item["message"] = "<B style=\"color:#339\">" . $item["real_name"] . "</B><hr style=\"margin-bottom:5px;margin-top:2px;border-color:#666;border:0;border-top:1px solid #666;\" />" . $item["message"];
                }
                $outputMessages .= "<div class=\"div_webchat_message_to_you speechbubble_you ui-corner-all\"><span style=\"font-size:10px;color:#666;float:right\">".$elapsed_time."</span>" . $item["message"] . "</div>";
            }
        }
        $DB->delete("tb_chat_unseens", 
                    array(
                        array("channel","=",$rooms[$key]["chatroom_id"]),
                        "AND",
                        array("id_user","=",$_SESSION[SESSION_IDENTIFIER]["user"]["id"])
                        )
                    );

        $rooms[$key]["count"] = count($items);
        $rooms[$key]["content"] = $outputMessages;
    }
    $output["chatrooms"] = $rooms;
    die(json_encode($output));
}


die("ERROR");



