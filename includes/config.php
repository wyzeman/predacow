<?php

define("CONFIG_CHARSET","utf-8");
define("CONFIG_TIMEZONE","America/Montreal");
define("CONFIG_WEBSITE_NAME","Predacow");
define("CONFIG_WEBSITE_URL","http://localhost/predacow");
if (!isset($_SERVER["HTTP_HOST"])) {
    define("CONFIG_WEBSITE_CURRENT_URI", "");
} else {
    define("CONFIG_WEBSITE_CURRENT_URI", "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
}
define("CONFIG_ROOT_PATH", "/var/www/html/predacow");
define("CONFIG_VERSION_NUMBER","1.0");

define("CONFIG_DB_HOSTNAME", "127.0.0.1");
define("CONFIG_DB_USERNAME", "root");
define("CONFIG_DB_PASSWORD", "");
define("CONFIG_DB_NAME","predacow");


define("CONFIG_EMAIL_SERVER_HOSTNAME","relais.videotron.ca");
define("CONFIG_EMAIL_SERVER_PORT",25);
define("CONFIG_EMAIL_AUTH_ENABLED",false);
define("CONFIG_EMAIL_AUTH_USERNAME","");
define("CONFIG_EMAIL_AUTH_PASSWORD","");
define("CONFIG_EMAIL_ADDR_FROM","predacow@gmail.com");

define("CONFIG_REGISTRATION_EMAIL_REQUIRED", false);
define("CONFIG_REGISTRATION_TIMEOUT_DAYS", 14);
define("CONFIG_REGISTRATION_EMAIL_FIELDNAME","email_address");

define("CONFIG_SESSION_IDENTIFIER","predacow");

define("CONFIG_WEBSITE_PUBLIC_URL","http://localhost/predacow/");
define("CONFIG_WEBSITE_PUBLIC_PATH","/var/www/html/predacow");

define("CONFIG_SESSION_EXPIRATION_TIME", 18000); // 300 minutes
define("CONFIG_SESSION_IDLE_TIME", 180); // 3 minutes


// User levels

class UserLevel {
    const NORMAL = 1;
    const STAFF = 100;
    const ADMIN = 255;
}


