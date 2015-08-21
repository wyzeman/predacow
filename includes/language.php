<?php

// define languages availables
$LANGUAGES = array();
$LANGUAGES[] = array("gettext"=>"en_US","name"=>"English");
$LANGUAGES[] = array("gettext"=>"fr_CA","name"=>"French");

if (session_id() == "") {
    die("This script need to be called after session initialization!");
}


// verify is language is already initialized
if (!isset($_SESSION[SI]["LANG"])) {


    $_SESSION[SI]["LANG"] = "en_US";
    $lang = $INPUT->server->noTags("HTTP_ACCEPT_LANGUAGE");
    $lang = explode(",", $lang);
    if (count($lang) > 0) {
        $lang = $lang[0];
        $lang = explode("-", $lang);
        if (count($lang) == 2) {
            $lang = $lang[0]."_".strtoupper($lang[1]);
            for ($i=0;$i<count($LANGUAGES);$i++) {
                if ($LANGUAGES[$i]["gettext"] == $lang) {
                    $_SESSION[SI]["LANG"] = $lang;
                }
            }
        }
    }



}


// set current language
$lang = "";
if ($INPUT->get->keyExists("LANG")) $lang = $INPUT->get->getRaw("LANG");
if ($INPUT->post->keyExists("LANG")) $lang = $INPUT->post->getRaw("LANG");

if ($lang != "") {

    $found = false;
    for ($i=0;$i<count($LANGUAGES);$i++) {

            if ($lang == $LANGUAGES[$i]["gettext"]) {
                    $found = true;
                    break;

            }

    }

    if ($found == false) die("Invalid language specified: ".$lang);
    $_SESSION[SI]["LANG"] = $lang;

}

// set gettext

if (!defined('LC_MESSAGES')) define('LC_MESSAGES', 5);
// gettext setup
setlocale(LC_MESSAGES, $_SESSION[SI]["LANG"]);
if (!defined("LANGUAGE_DOMAIN")) define("LANGUAGE_DOMAIN","messages");


$locales_dir = realpath("../shared/includes/locale/");

bindtextdomain(LANGUAGE_DOMAIN, $locales_dir);
bind_textdomain_codeset(LANGUAGE_DOMAIN, CONFIG_CHARSET);
textdomain(LANGUAGE_DOMAIN);

function T_($v) {
    return gettext($v);
}

