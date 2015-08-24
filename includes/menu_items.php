<?php
$MENU_ITEMS = [
    [
        "label" => T_("System Summary"),
        "url" => "mainpage.php",
        "user_level" => UserLevel::STAFF
        ,"sub_items"=>[
            [
                "label" => T_("Dashboard"),
                "url" => "mainpage.php",

            ],
            [
                "label" => T_("Activity Log"),
                "url" => "activity_log.php",

            ],
        ]

    ], [
        "label" => T_("Users"),
        "url" => "users.php",
        "user_level" => UserLevel::ADMIN
    ], [
        "label" => T_("Exit"),
        "url" => "logoff.php",
        "user_level" => UserLevel::STAFF
    ],
];

