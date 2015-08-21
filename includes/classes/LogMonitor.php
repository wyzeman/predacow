<?php


class LogMonitor {


	const ACTIVITY_LOGIN = "login";
	const ACTIVITY_LOGIN_FAIL = "login_fail";
	const ACTIVITY_LOGOUT = "logout";
	const ACTIVITY_LOGOUT_TIMEOUT = "logout_timeout";
	const ACTIVITY_TEXT = "text";
    const ACTIVITY_REMOVE_STEP = "remove_step";
    const ACTIVITY_ADD_STEP = "add_step";

	private $db = NULL; 

	function __construct($db) {

		$this->db = $db;

	}

	function logActivity($who, $how, $what, $ref = NULL, $when = NULL)    {

		if ($when == NULL) {
			$when = time();
		}

		$this->db->insert("tb_activities", array("field_who"=>$who,"field_how"=>$how,"field_what"=>$what,"field_reference"=>$ref,"field_when"=>$when));

	}

} 


