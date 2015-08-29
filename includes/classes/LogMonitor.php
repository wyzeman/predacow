<?php


class LogMonitor {


	const ACTIVITY_LOGIN = "login";
	const ACTIVITY_LOGIN_FAIL = "login_fail";
	const ACTIVITY_LOGOUT = "logout";
	const ACTIVITY_LOGOUT_TIMEOUT = "logout_timeout";
	const ACTIVITY_TEXT = "text";
    const ACTIVITY_REMOVE_STEP = "remove_step";
    const ACTIVITY_ADD_STEP = "add_step";
	const ACTIVITY_CREATE_USER = "create_user";
	const ACTIVITY_DELETED_USER = "delete_user";
	const ACTIVITY_MODIFY_USER = "modify_user";
	const ACTIVITY_CREATE_GROUP = "create_group";
	const ACTIVITY_DELETED_GROUP = "delete_group";
	const ACTIVITY_MODIFY_GROUP = "modify_group";

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


