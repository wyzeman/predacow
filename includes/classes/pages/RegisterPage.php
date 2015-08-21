<?php

$FORM_REGISTER_FIELDS = array(

    "username" => array("label"=>T_("Username"), "type"=>"text","maxlength"=>75, "optional" => false),
    "password" => array("label"=>T_("Password"), "type"=>"password","maxlength"=>255, "optional" => false),
    "email_address"    => array("label"=>T_("Email address"), "type"=>"email", "maxlength"=>255, "optional" => false),
    "country"    => array("label"=>T_("Country"), "type"=>"text", "maxlength"=>255, "optional" => false)

);

class RegisterPage {

    private $unique_fields = array();

    /**
     *
     */
    function __construct()
    {
        $this->unique_fields = array(
                "username"=>T_("Username already in use!"),
                "email_address"=>T_("Email address already in use!")
                );


    }


    /**
     * 
     */
    function show($complete_url="index.php",$cancel_url="index.php", $unique_fields = array()) {

        global $INPUT, $DB, $TPL, $FORM_REGISTER_FIELDS;
        
        // Redirect to completion URL if the user is already connected

        if (isset($_SESSION[SI]["user"])) {

            die(header("Location: $login_url"));
        }

        if (count($unique_fields) > 0) {
            $this->unique_fields = $unique_fields;
        }

        // If it's a activation link, we hide the registration form and popup a dialog containing
        // activation result (both good and bad), if the user click on the dialog OK button he get
        // redirected to the login page.


        if ($INPUT->get->keyExists("activate")) {
            $TPL->assign("hide_registration_form", true);

            if ($DB->activateUser($INPUT->get->noTags("activate")) == true) {
                $TPL->assign("validation_outcome",T_("Your account we  successfully activated! You can now login into your account."));
            } else {
                $TPL->assign("validation_outcome",T_("Unable to activate your account, the activiation key is invalid!"));

            }
        }

        // Check for AJAX submit, The information is sent via POSTed elements.
        // I need to check if all the required fields have a POSTed counterpart.
        // The tricky part is about password, a password field is represented by two
        // posted values named element_name1 and element_name2. Both elements contains
        // same values, we take the first one and remove the first number to make it fit.
        
        $isAjaxSubmit = true;
        $fields = array();

        reset($FORM_REGISTER_FIELDS);
        while(list($key,$value) = each($FORM_REGISTER_FIELDS)) {

            if ($value["type"] == "password") {
                $key .= "1";
            }
            
            if ($INPUT->post->keyExists($key)) {
                if ($value["type"] == "password") {
                    $fields[substr($key,0,strlen($key)-1)] = sha1($INPUT->post->noTags($key));

                } else {
                    $fields[$key] = $INPUT->post->noTags($key);
                }
            } else {
                $isAjaxSubmit = false;
                break;
            }
        }


        // We have found all elements in our POSTed values. Time to actually
        // register the user. The user get registered and activated except if
        // an email verification is required. In this case, an email is sent to the
        // new user containing a activation link. If the email cannot be sent we
        // rollback our change and delete the newly created user.

        if ($isAjaxSubmit == true) {

            $activation_key = $DB->registerUser($fields, $this->unique_fields);

            if (CONFIG_REGISTRATION_EMAIL_REQUIRED == true) {
                // Send email
                require_once("../shared/includes/thirdparty/class.phpmailer.php");
                $mail = new PHPMailer();

                $MAIL_TPL = new Smarty();
                $MAIL_TPL->assign("website_name",CONFIG_WEBSITE_NAME);
                $MAIL_TPL->assign("website_url", CONFIG_WEBSITE_URL);
                $MAIL_TPL->assign("activation_key",$activation_key);
                $MAIL_TPL->assign("activation_url",CONFIG_WEBSITE_CURRENT_URI);
                $MAIL_TPL->assign("activation_timeout",CONFIG_REGISTRATION_TIMEOUT_DAYS);
                $body = $MAIL_TPL->fetch("email_activate_account.html");

                $mail->IsSMTP();
                $mail->Host = CONFIG_EMAIL_SERVER_HOSTNAME;
                $mail->Port = CONFIG_EMAIL_SERVER_PORT;
                $mail->SMTPAuth = CONFIG_EMAIL_AUTH_ENABLED;
                $mail->Username = CONFIG_EMAIL_AUTH_USERNAME;
                $mail->Password = CONFIG_EMAIL_AUTH_PASSWORD;

                $mail->SetFrom(CONFIG_EMAIL_ADDR_FROM);
                $mail->Subject = T_("Activate your account for site: ") . CONFIG_WEBSITE_NAME;
                $mail->AltBody = T_("To view the message, please use an HTML compatible email viewer!");
                $mail->MsgHTML($body);
                $mail->AddAddress($fields[CONFIG_REGISTRATION_EMAIL_FIELDNAME]);
                if(!$mail->Send()) {

                    // roll back, delete newly created user
                    $DB->UndoUserCreation($activation_key);

                    die();
//                    die(T_("Unable to send your activation email for the following reason: ").str_replace("\n","<br/>",$mail->ErrorInfo));
                }
            }

            // Everything is going fine
            die("TRUE");
        }

        $TPL->assign("complete_url",$complete_url);
        $TPL->assign("cancel_url",$cancel_url);

        $script_name = explode("/",str_replace("\\","/",$INPUT->server->getRaw("SCRIPT_NAME")));
        $script_name = $script_name[count($script_name)-1];
        $TPL->assign("current_script", $script_name);
        $TPL->assign("activation_required",CONFIG_REGISTRATION_EMAIL_REQUIRED);
        // Build elements
        $elements = array();

        reset($FORM_REGISTER_FIELDS);
        while(list($key,$value) = each($FORM_REGISTER_FIELDS)) {

            $element = array();

            if ($value["type"] == "password") {

                $element = array(
                    "label"=>$value["label"],
                    "name" =>$key."1",
                    "type"=>"password","class"=>"required");
                $elements[] = $element;
            
                $element = array(
                    "label"=>$value["label"]. " ".T_("(Again)"),
                    "name" =>$key."2",
                    "type"=>"password","class"=>"required");
                $elements[] = $element;
                continue;

            } else {

                $element = array(
                    "label"=>$value["label"],
                    "name" =>$key);
            }


            $element["type"] = $value["type"];
            $class = "";
            if ($value["type"] == "email")  {

                $class .= "email ";
                $element["type"] = "text";
            }
            if ($value["optional"] == false) $class .= "required ";

            $element["class"] = $class;
            $elements[] = $element;

        }

        $TPL->assign("elements",$elements);

        $TPL->display("page_register_account.tpl");


    }

}

