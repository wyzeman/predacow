<?php

function build_webchat_users_table() {

    global $DB;

    $user_id = $_SESSION[SI]["user"]["id"];

    $count = 0;
    $count1 = 0;
    $count2 = 0;
    $bgcolor1 = "#e9e9f9";
    $bgcolor2 = "#f0f0ff";
    $bgcolor1_room = "#d9d999";
    $bgcolor2_room = "#e0e09f";
    $bgcolor1_offline = "#b9b9b9";
    $bgcolor2_offline = "#c0c0c0";

    $output = "<table id=\"table_webchat_users\">";

    $total_unseens = 0;
    
    // Public Chat
    $unseens = $DB->getCount("tb_chat_unseens", array(array("id_user","=",$_SESSION[SI]["user"]["id"]),"AND",array("channel","=",-1)));
    if ($unseens > 0) {
        $total_unseens += $unseens;
        $output .= "<tr><td nowrap bgcolor=\"" . ($count++ % 2 == 0 ? $bgcolor1_room : $bgcolor2_room) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_-1\" username=\"".T_("Public Chat")."\"><img class=\"webchat_img\" width=\"16\" height=\"16\" src=\"images/webchat/room_blink.gif\"><b>" . T_("Public Chat") . " (".$unseens . ")</b></a></td></tr>";

    } else {
        $unseens = "";
        $output .= "<tr><td nowrap bgcolor=\"" . ($count++ % 2 == 0 ? $bgcolor1_room : $bgcolor2_room) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_-1\" username=\"".T_("Public Chat")."\"><img class=\"webchat_img\" width=\"16\" height=\"16\"  src=\"images/webchat/room.png\">" . T_("Public Chat")."</a></td></tr>";
    }
    
    
    $chat_groups = $DB->select(array("id", "name"), "tb_groups", array(array("deleted", "=", 0), "AND", array("parent_group", "=", -1)), array("name ASC"));
    $user_group = $DB->getScalar("id_group","tb_groups_users", array("id_user","=", $_SESSION[SI]["user"]["id"]));
    $group_name = $DB->getScalar("name","tb_groups",array("id","=",$user_group));
    foreach ($chat_groups as $item) {

        if ($item["id"] == $user_group || $group_name == "Mindkind") {
            $id = -100 - $item["id"];
            $unseens = $DB->getCount("tb_chat_unseens", array(array("id_user", "=", $_SESSION[SI]["user"]["id"]), "AND", array("channel", "=", $id)));
            if ($unseens > 0) {
                $total_unseens += $unseens;
                $output .= "<tr><td nowrap bgcolor=\"" . ($count++ % 2 == 0 ? $bgcolor1_room : $bgcolor2_room) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_" . $id . "\" username=\"" . $item["name"] . "\"><img class=\"webchat_img\" width=\"16\" height=\"16\"  src=\"images/webchat/room_blink.gif\"><b>" . $item["name"] . " (" . $unseens . ")</b></a></td></tr>";

            } else {
                $unseens = "";
                $output .= "<tr><td nowrap bgcolor=\"" . ($count++ % 2 == 0 ? $bgcolor1_room : $bgcolor2_room) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_" . $id . "\" username=\"" . $item["name"] . "\"><img class=\"webchat_img\" width=\"16\" height=\"16\"  src=\"images/webchat/room.png\">" . $item["name"] . "</a></td></tr>";
            }
        }
    }


    $output1 = "";
    $output2 = "";
    $chat_users = $DB->select(array("id", "username"), "tb_users", array(array("id", "<>", $user_id), "AND", array("deleted", "=", 0), "AND", array("active", "=", 1)), array("username ASC"));
    foreach ($chat_users as $item) {

        $offline = false;
        $sessions = $DB->select("timestamp_last_activity", "tb_sessions", array("id_user", "=", $item["id"]));
        if ($sessions == null) {
            $offline = true;
        } else {
            $offline_count = 0;
            
            foreach($sessions as $session) { 
                $diff = time() - $session["timestamp_last_activity"];
                if ($diff >= CONFIG_SESSION_EXPIRATION_TIME) {
                    $offline_count++;
                }
            }
            
            if (count($sessions) == $offline_count) {
                $offline = true;
            }
        }
        $id = 0;

        if ($item["id"] > $user_id) {
            $id = ($item["id"] * 1000) + $user_id;
        } else {
            $id = ($user_id * 1000) + $item["id"];
        }

        $unseens = $DB->getCount("tb_chat_unseens", array(array("id_user","=",$_SESSION[SI]["user"]["id"]),"AND",array("channel","=",$id)));

        if ($offline == true) {
            if ($unseens > 0) {
                $total_unseens += $unseens;
                $output2 .= "<tr><td nowrap bgcolor=\"" . ($count1++ % 2 == 0 ? $bgcolor1_offline : $bgcolor2_offline) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_" . $id . "\" username=\"". $item["username"]."\"><img class=\"webchat_img\" width=\"16\" height=\"16\"  src=\"images/webchat/person_blink.gif\"><b>" . $item["username"] . " (".$unseens.")</b></a></td></tr>";
            } else {
                $output2 .= "<tr><td nowrap bgcolor=\"" . ($count1++ % 2 == 0 ? $bgcolor1_offline : $bgcolor2_offline) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_" . $id . "\" username=\"". $item["username"]."\"><img class=\"webchat_img\" width=\"16\" height=\"16\"  src=\"images/webchat/person.png\">" . $item["username"] . "</a></td></tr>";
            }
        } else {
            if ($unseens > 0) {
                $total_unseens += $unseens;
                $output1 .= "<tr><td nowrap bgcolor=\"" . ($count2++ % 2 == 0 ? $bgcolor1 : $bgcolor2) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_" . $id . "\" username=\"". $item["username"]."\"><img class=\"webchat_img\" width=\"16\" height=\"16\" src=\"images/webchat/person_blink.gif\"><b>" . $item["username"] . " (".$unseens.")</b></a></td></tr>";
            } else {
                $output1 .= "<tr><td nowrap bgcolor=\"" . ($count2++ % 2 == 0 ? $bgcolor1 : $bgcolor2) . "\"><a href=\"#\" class=\"link_webchat_users\" id=\"button_chatroom_" . $id . "\" username=\"". $item["username"]."\"><img class=\"webchat_img\" width=\"16\" height=\"16\" src=\"images/webchat/person.png\">" . $item["username"] . "</a></td></tr>";
                
            }
        }
    }
    $output .= $output1 . $output2;

    $output .= "</table>";
    return array("output"=>$output,"total_unseens"=>$total_unseens);
}

// Handle webchat
$webchat_opened = $DB->getScalar("opened", "tb_webchat", array("id_user", "=", $_SESSION[SI]["user"]["id"]));
if ($webchat_opened == null) {
    $webchat_opened = 0;
    $DB->insert("tb_webchat", array("opened" => 0, "id_user" => $_SESSION[SI]["user"]["id"]));
}

$time_expiration = time() - CONFIG_SESSION_IDLE_TIME;
$TPL->assign("webchat_opened", $webchat_opened);
$TPL->assign("users_connected", $DB->getCount("tb_sessions", array(array("id_user", "!=", $_SESSION[SI]["user"]["id"]), "AND", array("timestamp_last_activity", ">=", $time_expiration)))
);

$rooms = $DB->select("*", "tb_webchat_chatrooms", array("id_user", "=", $_SESSION[SI]["user"]["id"]));
foreach ($rooms as $key => $room) {

    // Fetch chat!
    $items = $DB->select("*","tb_chat", array("channel","=",$rooms[$key]["chatroom_id"]),array("id DESC"), "LIMIT 0,20");
    $output = "";
    $items = array_reverse($items);
    
    foreach($items as $item) {
        
        if ($item["username"] == $_SESSION[SI]["user"]["username"]) {
            
            $elapsed_time = elapsed_time(time()-$item["timestamp"], true);
            $output .= "<div class=\"div_webchat_message_from_you speechbubble_me ui-corner-all\"><span style=\"font-size:10px;color:#666;float:right\">".$elapsed_time."</span>".$item["message"]."</div>";
            
        } else {

            $elapsed_time = elapsed_time(time()-$item["timestamp"], true);
            
            if ($rooms[$key]["chatroom_id"] < 0) {
                $item["username"] = $DB->getScalar("username","tb_users", array("username","=",$item["username"]));
                $item["message"] = "<B style=\"color:#339\">".$item["username"]."</B><hr style=\"margin-bottom:5px;margin-top:2px;border-color:#666;border:0;border-top:1px solid #666;\" />".$item["message"];
            }

            $DB->delete("tb_chat_unseens", 
                    array(
                        array("channel","=",$rooms[$key]["chatroom_id"]),
                        "AND",
                        array("id_user","=",$_SESSION[SI]["user"]["id"])
                        )
                    );

            
            $output .= "<div class=\"div_webchat_message_to_you speechbubble_you ui-corner-all\"><span style=\"font-size:10px;color:#666;float:right\">".$elapsed_time."</span>".$item["message"]."</div>";
            
        }
    }
    $rooms[$key]["count"] = count($items);
    $rooms[$key]["content"] = $output;
}

$TPL->assign("chatrooms", $rooms);
$TPL->assign("table_webchat", build_webchat_users_table());
