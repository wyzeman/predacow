<?php


// Include configuration
require_once(__DIR__ . "/config.php");

if (!defined("SI"))
    define("SI", CONFIG_SESSION_IDENTIFIER);

// Verify if the system is sane
$init_phpVersion = phpversion();
if ((strlen($init_phpVersion) == 0) || ($init_phpVersion[0] != '5')) {
    die("This script will not work with your PHP version, at least PHP 5 is required. (Current version: $init_phpVersion)");
}
if (ini_get("register_globals") == 1) {
    die("Disable register_globals PHP Directive!");
}
set_time_limit(30);

// Enable output buffering
ob_start();

// Initialize session
session_start();

if (!isset($_SESSION[SI])) {
    
    $_SESSION[SI] = array();
}


// Set UTF8 encoding
header("Content-Type: text/html; charset=" . CONFIG_CHARSET);

// Set timezone
date_default_timezone_set(CONFIG_TIMEZONE);

require_once(__DIR__ . "/thirdparties/autoload.php");
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use Inspekt\Inspekt;

//require_once(__DIR__."/thirdparties/funkatron/inspekt/Inspekt.php");


//require_once(__DIR__."/thirdparties/funkatron/inspekt/Inspekt.php");
// Initialize inspekt
$INPUT = Inspekt::makeSuperCage();

// Include base classes
require_once("classes/Database.php");

// Include logging system classes 
require_once("classes/LogMonitor.php");

// Initialize language
require_once("language.php");

// Include menu items
require_once("menu_items.php");

// Initialize template engine
$TPL = new Smarty();
$TPL->muteExpectedErrors();
$TPL->addPluginsDir("includes/smarty_plugins/");

$TPL->assign("website_name", CONFIG_WEBSITE_NAME);
$TPL->assign("website_url", CONFIG_WEBSITE_URL);
$TPL->assign("version_number", CONFIG_VERSION_NUMBER);
$TPL->assign("languages", $LANGUAGES);

$lang = "en_US";
if (isset($_SESSION[SI]) && isset($_SESSION[SI]["LANG"])) {
    $lang = $_SESSION[SI]["LANG"];
}
$TPL->assign("language", $lang);

if ($INPUT->get->keyExists("notice") == true) {
    $notice_data = base64_decode($INPUT->get->getAlnum("notice"));
    $TPL->assign("notice", $notice_data);
}

if ($INPUT->get->keyExists("warning") == true) {
    $warning_data = base64_decode($INPUT->get->getAlnum("warning"));
    $TPL->assign("warning", $warning_data);
}

// Initialize database engine
$DB = new Database(CONFIG_DB_HOSTNAME, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_NAME);

// Initialize logging system engine
$LOG = new LogMonitor($DB);

//Cleaning the timeout session
$timeout = time() - (60 * 60); // 60 minutes
$time = time();
$sessions = $DB->select("*", "tb_sessions", array("timestamp_last_activity", "<", $timeout));

foreach($sessions as $session) {
     
    // Logging the automatic logout

    $username = $DB->getScalar("username","tb_users", array("id", "=", $session['id_user']));
    $LOG->logActivity($username, LogMonitor::ACTIVITY_LOGOUT_TIMEOUT, "");
    $DB->insert(
        "tb_events_logs",
        array(

            "timestamp" => time(),
            "event_type" => 0,
            "description" => $username." ping timeout!"
        )
    );
    // Delecting the session in the database table tb_sessions
    $DB->delete("tb_sessions", array("id_user", "=", $session['id_user']));
}

require_once("includes/functions.php");


//flushing session if session is timeout
if (isset($_SESSION[SI]) && isset($_SESSION[SI]["user"]) && isset($_SESSION[SI]["user"]["id"])) {

    if ($DB->getCount("tb_sessions", array("id_user", "=", $_SESSION[SI]["user"]["id"])) == 0) {
        // Destroy la session
        session_destroy();

        // Redirige vers la page de login (index.php)
        die(header("location: index.php"));
    } else {
        $DB->update("tb_sessions", array("timestamp_last_activity" => $time, "url_last_activity" => $INPUT->server->noTags("SCRIPT_NAME")), array("id_user", "=", $_SESSION[SI]["user"]["id"]));
        require_once("includes/webchat.php");
        require_once("includes/events.php");
        require_once("includes/alerts.php");

    }

}




