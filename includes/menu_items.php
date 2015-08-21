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
        "label" => T_("Categories"),
        "url" => "categories.php",
        "user_level" => UserLevel::STAFF
    ], [
        "label" => T_("Products"),
        "url" => "products.php",
        "user_level" => UserLevel::STAFF,
        "sub_items" => [
            [
                 "label" => T_("Product Catalog"),
                 "url" => "products.php"
            ],
            [
                "label" => T_("Colors"),
                "url" => "products_colors.php"
            ],
            [
            "label" => T_("Options"),
            "url" => "products_options.php"
        ]
        ]
    ], [
        "label" => T_("Exit"),
        "url" => "logoff.php",
        "user_level" => UserLevel::STAFF
    ],
];

