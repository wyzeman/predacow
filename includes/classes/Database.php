<?php

/**
 * This class provides a gateway between your application and a MySQL database
 * and contains several useful functions such as user login, user registration and
 * activation.
 */
class Database {

    private $transaction_started = false;
    private $mysqli = null;
    public $last_query = "";

    public static $EVENT_NORMAL = 0;
    public static $EVENT_WARNING = 1;
    public static $EVENT_IMPORTANT = 2;
    
    /**
     * Database object constructor
     *
     * We open a MySQL connection.
     *
     * If the connection fail, the script die with a error message.
     *
     * @param <String> $hostname Hostname to use for MySQL connection
     * @param <String> $username Username to use for MySQL connection
     * @param <String> $password Password to use for MySQL connection
     * @param <String> $name Database name
     */
    function __construct($hostname, $username, $password, $database) {

        $this->mysqli = new mysqli($hostname, $username, $password, $database);
        if (!$this->mysqli->set_charset("utf8")) {
            die("Unable to set charset for database!");
        }

    }




    /**
     * Object destructor, close the MySQL server connection
     */
    function __destruct() {

        $this->mysqli->close();
        unset($this->mysqli);
    }


    /**
     *
     */
    function beginTransaction() {
        if ($this->transaction_started == true) {
            return;
        }
        $this->transaction_started = true;

        $this->mysqli->autocommit(false);
    }

    /**
     *
     */
    function endTransaction() {
        if ($this->transaction_started == false) return;
        $this->transaction_started = false;
        $this->mysqli->commit();
        $this->mysqli->autocommit(true);
    }


    /**
     *
     */
    function cleanupSessions() {
        $time_expiration = time() - CONFIG_SESSION_EXPIRATION_TIME;

        $query = "DELETE FROM tb_sessions WHERE UNIX_TIMESTAMP(update_datetime) <= $time_expiration";
        $this->last_query = $query;
        if ($this->mysqli->query($query) == FALSE) die(($this->mysqli->error." (".$query.")"));

    }



    /**
     *
     */
    function getSessionsCount($game_id) {
        return $this->getCount("tb_sessions", array("game_id","=",$game_id));
    }



    /**
     * Login to the system using username and password submitted by user.
     * If it's a valid login we register a $_SESSION[SI]["user"] array containing the id field
     * of the connected user. the $_SESSION[SI]["user"] array must be used by the system
     * afterward to determine if the current user is a logged one or not and also to check
     * which user it is.
     *
     * @param <String> $username Username to use for login
     * @param <String> $password Password to use for login
     * @return <Boolean> True on success, false otherwise
     */
    function login($username, $password) {

        global $INPUT;

        $query = "SELECT * FROM tb_users WHERE username='".addslashes($username)."' AND password='".$this->hashPassword($password)."' AND user_level >= " . UserLevel::NORMAL;
        $this->last_query = $query;
        $result = $this->mysqli->query($query);

        if ($result == FALSE) return false;
        if ($result->num_rows == 0) return false;
        $values = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION[SI]["user"] = $values;

        $hostname = addslashes($INPUT->server->noTags("REMOTE_ADDR"));
        
        // Update hostname and time
        $query = "UPDATE tb_users SET last_visit_hostname='".$hostname."', last_visit_datetime=FROM_UNIXTIME(".time().") WHERE id=".$values["id"];
        $this->last_query = $query;
        if (!$this->mysqli->query($query)) {
            error_log($this->mysqli->error." = ".$query);
        }


        $id_user = intval($values["id"]);

        // Delete previous session
        $query = "DELETE FROM tb_sessions WHERE id_user=".$id_user;
        $this->last_query = $query;
        if (!$this->mysqli->query($query)) {
            error_log($this->mysqli->error." = ".$query);
        }

        // Spawn a new session
        $query = "INSERT INTO tb_sessions (id_user, timestamp_created,timestamp_last_activity,hostname,url_last_activity) VALUES ($id_user,".time().",".time().",'$hostname','')";
       // error_log($query);
        $this->last_query = $query;
        if (!$this->mysqli->query($query)) {
            error_log($this->mysqli->error." = ".$query);
        }

        return true;


    }

    function hashPassword($plaintext){
        $corehash = crypt($plaintext,'$5$');
        return $corehash;
    }


    /**
     * Login to the system using user_id submitted by user.
     * If it's a valid login we register a $_SESSION[SI]["user"] array containing the id field
     * of the connected user. the $_SESSION[SI]["user"] array must be used by the system
     * afterward to determine if the current user is a logged one or not and also to check
     * which user it is.
     *
     * @param <String> $username Username to use for login
     * @param <String> $password Password to use for login
     * @return <Boolean> True on success, false otherwise
     */
    function autoLogin($user_id, $SI = SI) {

        global $INPUT;

        $query = "SELECT * FROM tb_users WHERE id='".addslashes($user_id)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == FALSE) return false;
        if ($result->num_rows == 0) return false;
        $values = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION[$SI]["user"] = $values;

        // Update hostname and time
        $query = "UPDATE tb_users SET last_visit_hostname='".addslashes($INPUT->server->noTags("REMOTE_ADDR"))."', last_visit_datetime=FROM_UNIXTIME(".time().") WHERE id=".$values["id"];
        $this->last_query = $query;
        $this->mysqli->query($query);

        $hostname = addslashes($INPUT->server->noTags("REMOTE_ADDR"));

        // Delete previous session
        $query = "DELETE FROM tb_sessions WHERE id_user=".$user_id;
        $this->last_query = $query;
        $this->mysqli->query($query);

        // Spawn a new session
        $timeNow = time();
        $query = "INSERT INTO tb_sessions (id_user, timestamp_created,timestamp_last_activity,hostname,url_last_activity) VALUES ($user_id, $timeNow, $timeNow, '$hostname','')";
        $this->last_query = $query;
        if (!$this->mysqli->query($query)) {
            die("MySQL error: " . $this->mysqli->error);
        }

        return true;

    }


    /**
     * Perform a log off for a specific user
     * @param <type> $user_id  User identification number
     */
    function logoff($user_id) {
        $query = "DELETE FROM tb_sessions WHERE id_user=".intval($user_id);
        $this->last_query = $query;
        $this->mysqli->query($query);
    }

    /**
     *
     * Reset user password based on his email address. We actually generate a 10 characters
     * password using random printable values. This is a two part process involving another
     * class member function named updatePassword.
     *
     * This function only check for valid email and return new password
     *
     * @see updatePassword
     * @param <String> $email_address Email address of the user
     * @return <Mixed> The new password as a string on success, false otherwise
     */
    function resetPassword($email_address) {

        $query = "SELECT * FROM tb_users WHERE email_address='".addslashes($email_address)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == FALSE) return false;
        if ($result->num_rows == 0) return false;

        // Generate a new password
        $keyspace = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $new_password = "";
        for ($i=0;$i<10;$i++) {
            $new_password .= $keyspace[rand(0,strlen($keyspace)-1)];
        }

        return $new_password;
    }

    /**
     * Update password account for real based on a valid email adress and a new
     * password to use.
     *
     * @see resetPassword
     * @param <String> $email_address Email address of the user
     * @param <String> $new_password New password to use
     * @return <Boolean> True on sucess, false otherwise
     */
    function updatePassword($email_address, $new_password) {
        $query = "SELECT * FROM tb_users WHERE email_address='".addslashes($email_address)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == FALSE) return false;
        if ($result->num_rows == 0) return false;
        $values = $result->fetch_array(MYSQLI_ASSOC);

        $query = "UPDATE tb_users SET password='".$this->hashPassword($new_password)."' WHERE id=".$values["id"];
        $this->last_query = $query;
        $this->mysqli->query($query);

        return true;
    }


    /**
     * Register a user into the system using required fields provided by the user.
     * Since our system support dynamic set of fields we have to build a dynamic
     * query on the fly.
     *
     * The $unique_fields array contains fields values which needs to be unique
     * in the database like username and email address.
     *
     * @param <Array> $fields A array of fields stored as key=value pairs.
     * @param <Array> $unique_fields A array of fields stored as key=value pairs.
     * @return <String> Activation key if needed, empty otherwise
     */
    function registerUser($fields, $unique_fields) {

        $keys = "";
        $values = "";
        reset($fields);
        while(list($key,$value) = each($fields)) {

            reset($unique_fields);
            while(list($k,$v) = each($unique_fields)) {
                if ($k == $key) {
                    // Verify if the field is already in use
                    $query = "SELECT * FROM tb_users WHERE $k='$value'";
                    $r = $this->mysqli->query($query);
                    if ($r == false) die(T_($v));
                    if ($r->num_rows > 0) die(T_($v));
                }
            }

            $keys .= addslashes($key).",";
            $values .= "'".addslashes($value)."',";
        }

        if ($keys[strlen($keys)-1] == ",") $keys = substr($keys, 0, strlen($keys)-1);
        if ($values[strlen($values)-1] == ",") $values = substr($values, 0, strlen($values)-1);

        $active = 1;
        $activation_key = "";

        if (CONFIG_REGISTRATION_EMAIL_REQUIRED == true) {
            $active = 0;
            $activation_key = sha1(microtime() . $keys . $values); // Create semi-random activation key
        }

        $query = "INSERT INTO tb_users (active, activation_key, creation_datetime,$keys) VALUES('$active','$activation_key',CURRENT_TIMESTAMP(),$values)";

        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if  ($result == false) die(T_("Internal error!"));


        return $activation_key;

    }

    /**
     * Usually called when sending activation email failed.
     * Remove the user entry from database.
     *
     * @param <String> $activation_key Activation key for the user
     */
    function undoUserCreation($activation_key) {

        $query = "DELETE FROM tb_users WHERE activation_key = '".addslashes($activation_key)."'";
        $this->last_query = $query;
        $this->mysqli->query($query);
    }


    /**
     * Activate user based on two conditions which are:
     * The activation key must match and the user have to be unactivated.
     *
     * @param <String> $activation_key Activation key for the user
     * @return <Boolean> True on success, false otherwise.
     */
    function activateUser($activation_key) {
        $query = "SELECT * FROM tb_users WHERE active='0' AND activation_key='".addslashes($activation_key)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == false) return false;
        if ($result->num_rows == 0) return false;

        $query = "UPDATE tb_users SET active='1' WHERE active='0' AND activation_key='".addslashes($activation_key)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == false) return false;

        return true;
    }



    /**
     *
     * @param <type> $table
     * @param <type> $items
     */
    function insert($table, $items) {

        $item_keys = "";
        $item_values = "";

        reset($items);
        $count = 0;
        while(list($key,$value) = each($items)) {
            $item_keys .= $this->mysqli->escape_string($key);
            $value = $this->mysqli->escape_string($value);
            if (is_numeric($value) == false) {
                if (strlen($value) > 0) {

                    if ($value[0] == "@") {
                        $value = substr($value,1);
                    } else {
                        $value = "'".$value."'";

                    }

                } else {
                    $value = "''";
                }
            }
            $item_values .= $value;

            if ($count < (count($items)-1)) {
                $item_keys .=",";
                $item_values .= ",";
            }
            $count++;
        }

        $query = "INSERT INTO $table ($item_keys) VALUES($item_values)";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == false) die("Unable to insert: ".$this->mysqli->error.", Query: ".$query);

        return $this->mysqli->insert_id;
    }


    /**
     * Verify if a user exists based on his email address
     * @param <String> $email email address to use
     * @return <Boolean> True on success, false otherwhise
     */
    function userExists($email) {

        $query = "SELECT * FROM tb_users WHERE email='".$this->mysqli->escape_string($email)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == false) die(($this->mysqli->error.", Query: ".$query));
        if ($result->num_rows == 0) return false; else return true;
    }


    /**
     * Update the password of a user based on his username
     *
     * @param <String> $username Username to use
     * @param <String> $password Password to use
     * @return <Boolean> True on success, false otherwise
     */
    function updateUserPassword($username, $password) {

        $query = "UPDATE tb_users SET password='".$this->hashPassword($password)."' WHERE username='".$this->mysqli->escape_string($username)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == false) die(($this->mysqli->error.", Query: ".$query));
        return true;
    }


    /**
     * Rename username of an existing user
     *
     * @param <String> $username_orig Old username
     * @param <String> $username_new New username
     * @return <Boolean> True on success, false otherwise
     */
    function renameUser($username_orig, $username_new) {
        $query = "UPDATE tb_users SET username='".$this->mysqli->escape_string($username_new)."' WHERE username='".$this->mysqli->escape_string($username_orig)."'";
        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        if ($result == false) die(($this->mysqli->error.", Query: ".$query));
        return true;

    }

    /**
     *
     * @param <type> $item
     * @return <type>
     */
    private function recurseQuery($item) {

        $str_where = "";

        for ($i=0;$i<count($item);$i++) {
            if (is_array($item[$i])) {
                if (count($item[$i]) == 3) {

                    if (is_array($item[$i][0])) {
                        $str_where .= "(";
                        $str_where .= $this->recurseQuery($item[$i]);
                        $str_where .= ")";
                    } else {
                        $key = $this->mysqli->escape_string($item[$i][0]);
                        $operation = strtoupper($item[$i][1]);
                        $valid_operations = array("=",">","<",">=","<=","LIKE","NOT LIKE","IS NOT","IS","<>","!=");
                        if (is_numeric($item[$i][2])) {
                            $value = $item[$i][2];
                        } else {
                            $value = $this->mysqli->escape_string($item[$i][2]);
                        }

                        if (in_array($operation, $valid_operations)) {

                            if (($value != "") && ($value[0] == "@")) {

                                $value = substr($value,1);

                            } else {
                                if (is_numeric($value) == false) {

                                    if (($operation == "LIKE") || ($operation == "NOT LIKE")) {
                                        $value = "%".$value."%";
                                    }
//                                    if (strpos($value,"(") === false) {
                                        $value = "'".$value."'";
  //                                  }
                                }
                            }

                            $key = str_replace(".","`.`", $key);
                            $str_where .= "`".$key."` ".$operation." ".$value." ";

                        } else {

                            throw new Exception("Invalid operation: " . $operation);
                        }
                    }

                } else {
                    $str_where .= "(";
                    $str_where .= $this->recurseQuery($item[$i]);
                    $str_where .= ")";
                }

            } else {

                $separator = strtoupper($item[$i]);
                $valid_separators = array("AND","OR","BETWEEN");
                if (in_array($separator, $valid_separators)) {
                    $str_where .= $item[$i]." ";
                } else {
                    throw new Exception("Invalid separator: " . $separator);
                }

            }
        }

        return $str_where;
    }



    /**
     *
     * @param <type> $table
     * @param <type> $items
     * @param <type> $where
     */
    function update($table, $items, $where) {


        $str_items = "";
        reset($items);
        $count = 0;
        while(list($key,$value) = each($items)) {

            $special = false;
            if (strlen($value) > 0) {
                if ($value[0] == "@") {
                    $special = true;
                    $value = substr($value,1);
                }
            }

            if ((is_string($value) == true) && ($special == false)) {
                $value = "'".$this->mysqli->escape_string($value)."'";
            }
            
            if ($value == "") {
                $str_items .= $key."='".$value."'";
            } else {
                $str_items .= $key."=".$value;
            }

            if ($count++ < (count($items)-1)) {
                $str_items .= ",";
            }
        }

        $str_where = "";

        if ((count($where) == 3) && (is_array($where[0]) == false)) {

            $key = $where[0];
            $operation = $where[1];
            $value = $where[2];


            $valid_operations = array("=",">","<",">=","<=","LIKE","NOT LIKE","<>","!=");
            if (!in_array($operation,$valid_operations)) {
                die(("Invalid operation: " .$operation));
            }
            $key = str_replace(".","`.`", $key);

            if (is_numeric($value) == false) {
                $str_where = "`".$key . "` ".$operation." '".$this->mysqli->escape_string($value)."'";
            } else {
                $str_where = "`".$key . "` ".$operation." ".$this->mysqli->escape_string($value);

            }

        } else {

            for ($i=0;$i<count($where);$i++) {


                if (is_array($where[$i])) {

                    $key = $where[$i][0];
                    $operation = strtoupper($where[$i][1]);
                    $value = $where[$i][2];


                    $valid_operations = array("=",">","<",">=","<=","LIKE","NOT LIKE","<>","!=");
                    if (!in_array($operation,$valid_operations)) {
                        die(("Invalid operation: " .$operation));
                    }

                    $key = str_replace(".","`.`", $key);

                    if (is_numeric($value) == false) {
                        $str_where .= "`".$key . "` ".$operation." '".$this->mysqli->escape_string($value)."'";
                    } else {
                        $str_where .= "`".$key . "` ".$operation." ".$this->mysqli->escape_string($value);
                    }

                } else {
                    $separator = strtoupper($where[$i]);
                    $separators = array("AND","OR");
                    if (in_array($separator,$separators)) {
                        $str_where .= " ". $separator . " ";
                    } else {
                        die(("Malformed query, invalid separator: ".$separator));
                    }
                }

            }

        }

        $query = "UPDATE ".$table." SET $str_items WHERE $str_where";
        $this->last_query = $query;
        if ($this->mysqli->query($query) == false) {
            die(("Update failed: ".$this->mysqli->error.", Query: $query"));
        }

    }



    /**
     *
     * @param <type> $table
     * @param <type> $items
     * @param <type> $where
     */
    function delete($table, $where) {

        $str_where = "";

        if ((count($where) == 3) && (is_array($where[0]) == false)) {

            $key = $where[0];
            $operation = $where[1];
            $value = $where[2];

            $valid_operations = array("=",">","<",">=","<=","LIKE","NOT LIKE","<>","!=");
            if (!in_array($operation,$valid_operations)) {
                die(("Invalid operation: " .$operation));
            }
            $key = str_replace(".","`.`", $key);

            if (is_numeric($value) == false) {
                $str_where = "`".$key . "` " . $operation . " '" . $this->mysqli->escape_string($value)."'";
            } else {
                $str_where = "`".$key . "` " . $operation . " " . $this->mysqli->escape_string($value);
            }

        } else {

            for ($i=0;$i<count($where);$i++) {


                if (is_array($where[$i])) {

                    $key = $where[$i][0];
                    $operation = strtoupper($where[$i][1]);
                    $value = $where[$i][2];

                    if (is_numeric($value) == false) {
                        $value = "'".$value."'";
                    }

                    $valid_operations = array("=",">","<",">=","<=","LIKE","NOT LIKE","<>","!=");
                    if (!in_array($operation,$valid_operations)) {
                        die(("Invalid operation: " .$operation));
                    }

                    $str_where .= $key . " ".$operation." ".$this->mysqli->escape_string($value);


                } else {
                    $separator = strtoupper($where[$i]);
                    $separators = array("AND","OR");
                    if (in_array($separator,$separators)) {
                        $str_where .= " ". $separator . " ";
                    } else {
                        die(("Malformed query, invalid separator: ".$separator));
                    }
                }

            }

        }


        $query = "DELETE FROM ".$table." WHERE $str_where";
        $this->last_query = $query;

        if ($this->mysqli->query($query) == false) {
            die(("Updata failed: ".$this->mysqli->error.", Query: ".$query));
        }

    }


    /**
     * Retrieve total items count based on where clauses
     *
     * @param <type> $table Table name
     * @param <type> $where Where clauses
     */
    function getCount($table, $where = array(), $join = "") {
        $rows = $this->select("COUNT(*)",$table, $where, array(),"",$join);
        if (count($rows) == 0) return 0;

        return $rows[0]["COUNT(*)"];
    }

    /**
     *
     * @param <type> $fields
     * @param <type> $table
     * @param <type> $where
     * @param <type> $order_by
     */
    function select($fields, $tables, $where = array(), $order_by = array(), $extra = "", $join = "") {

        $str_fields = "";
        $str_tables = "";
        $str_where = "";
        $str_orderby = "";

        // Parsing fields

        if (is_array($fields)) {

            if (count($fields) == 0) die(("Empty fields set!"));
            for ($i=0;$i<count($fields);$i++) {
                if (strpos($fields[$i],",") !== false) die(("Unsafe behavior, please use an array to store fields"));
                $str_fields .= $this->mysqli->escape_string($fields[$i]);
                if ($i < (count($fields)-1)) {
                    $str_fields .=",";
                }
            }

        } else {
            if ($fields == "") die(("Empty fields set!"));
            if (strpos($fields,",") !== false) die(("Unsafe behavior, please use an array to store fields"));

            $str_fields = $this->mysqli->escape_string($fields);

        }

        // Parsing tables
        if (is_array($tables)) {

            if (count($tables) == 0) die(("Empty tables set!"));
            for ($i=0;$i<count($tables);$i++) {
                if (strpos($tables[$i],",") !== false) die(("Unsafe behavior, please use an array to store tables"));
                $str_tables .= $this->mysqli->escape_string($tables[$i]);
                if ($i < (count($tables)-1)) {
                    $str_tables .=",";
                }
            }

        } else {
            if ($tables == "") die(("Empty tables set!"));
            if (strpos($tables,",") !== false) die(("Unsafe behavior, please use an array to store tables"));
            $str_tables = $this->mysqli->escape_string($tables);
        }

        // Parsing where
        if (!is_array($where)) {
            die(("Where clauses needs to be in an array!"));
        }

        if (
        (count($where) == 3) &&
                (is_array($where[0]) == false) &&
                (is_array($where[1]) == false) &&
                (is_array($where[2]) == false)
        ) {

            $key = $this->mysqli->escape_string($where[0]);
            $operation = strtoupper($where[1]);
            $valid_operations = array("=",">","<",">=","<=","LIKE","NOT LIKE","IS","IS NOT", "<>","!=");
            if (is_numeric($where[2])) {
                $value = $where[2];
            } else {
                $value = $this->mysqli->escape_string($where[2]);
            }

            if (($operation == "LIKE") || ($operation == "NOT LIKE")) {
                $value = "%".$value."%";
            }

            if (in_array($operation, $valid_operations)) {

                if (is_numeric($value) == false) {

                    if (($value != "") && ($value[0] == "@")) {
                        $value = substr($value,1);
                    } else {
                        $value = "'".$value."'";
                    }
                }

                $key = str_replace(".","`.`", $key);
                $str_where = "`".$key."` ".$operation." ".$value." ";
            } else {

                die(("Invalid operation: ".$operation));
            }

        } else {
            $str_where = $this->recurseQuery($where);
        }

        // Parsing orderby
        for ($i=0;$i<count($order_by);$i++) {
            $str_orderby .= $this->mysqli->escape_string($order_by[$i]);
            if ($i < (count($order_by)-1)) {
                $str_orderby .= ",";
            }
        }

        $query = "SELECT $str_fields FROM $str_tables";
        if ($join != "") $query .= " ".$join;
        if ($str_where != "") $query .= " WHERE ".$str_where;
        if ($str_orderby != "") $query .= " ORDER BY ".$str_orderby;
        if ($extra != "") $query .= " ".$extra;

        $this->last_query = $query;
        //error_log($query);
        
        $result = $this->mysqli->query($query);
        if ($result == false) {
            die(("Database Error: ".$this->mysqli->error.", Query: ".$query));
        }

        
        if ($result->num_rows == 0) return array();

        $output = array();
        for ($i=0;$i<$result->num_rows;$i++) {

            $output[] = $result->fetch_array(MYSQLI_ASSOC);

        }

        return $output;
    }

    
    
    /**
     *
     * @param <type> $query
     */
    function rawSelect($query) {

        $this->last_query = $query;
        $result = $this->mysqli->query($query);
        
        if ($result == false) {
            throw new Exception("Database Error: ".$this->mysqli->error.", Query: ".$query);
        }
        if ($result->num_rows == 0) return array();

        $output = array();
        for ($i=0;$i<$result->num_rows;$i++) {

            $output[] = $result->fetch_array(MYSQLI_ASSOC);

        }

        return $output;
    }


    /**
     *
     * @param <type> $field
     * @param <type> $table
     * @param <type> $where
     */
    function getScalar($field, $table, $where = array(), $order_by = array()) {
        
        $rows = $this->select($field, $table, $where, $order_by);
        if (count($rows) == 0) return null;
        return $rows[0][$field];
    }

    /**
     * Retrieve list of tables
     * @return <Array> list of tables retrieved
     */
    function getTables() {
        $tables = array();

        $result = $this->mysqli->query("SHOW TABLES");

        for ($i=0;$i<$result->num_rows;$i++) {
            $row = $result->fetch_array(MYSQLI_BOTH);
            $tables[] = $row[0];
        }

        return $tables;
    }


    /**
     * Dump database table to string
     * @param <String> $table Table to dump
     * @return <String> String representation of the table structure and content
     */
    function dumpTable($table,$dump_content_too = true) {

        $query_create = "DROP TABLE IF EXISTS $table\r\n";
        $query_create .= "CREATE TABLE $table (";
        $result =  $this->mysqli->query("desc $table");
        for ($i=0;$i<$result->num_rows;$i++) {

            $row = $result->fetch_array(MYSQLI_ASSOC);

            $field = $row["Field"];
            $type = strtoupper($row["Type"]);
            $null = $row["Null"];
            $key = $row["Key"];
            $default = $row["Default"];
            $extra = strtoupper($row["Extra"]);

            $query_create .= "$field $type";
            if ($null == "NO") $query_create .= " NOT NULL";
            if ($extra != "") $query_create .= " ".$extra;
            if ($key == "PRI") $query_create .= " PRIMARY KEY";

            if ($i < ($result->num_rows-1)) {
                $query_create .= ",";
            }
        }

        $query_create .= ");\r\n";

        if ($dump_content_too == true) {
            $rows = $this->select("*",$table);

            foreach($rows as $row) {
                $insert_fields = "";
                $insert_values = "";

                while(list($key,$value) = each($row)) {
                    $insert_fields .= $key.",";
                    $insert_values .= "'".$value."',";
                }

                if ($insert_fields != "") $insert_fields = substr($insert_fields, 0, strlen($insert_fields)-1);
                if ($insert_values != "") $insert_values = substr($insert_values, 0, strlen($insert_values)-1);

                $insert_query = "INSERT INTO $table ($insert_fields) VALUES($insert_values);\r\n";
                $query_create .= $insert_query;

            }
        }

        $query_create .= "\r\n";
        return $query_create;
    }


    /**
     *
     */
    function backup() {
        $timestamp = date("m/d/y h:i:s");
        $items = "--- Backup done on ".$timestamp."\r\n\r\n";
        $tables = $this->getTables();

        for($i=0;$i<count($tables);$i++) {
            $items .= $this->dumpTable($tables[$i]);
        }

        return $items;
    }


    /**
     *
     * @param <type> $data
     */
    function restore($data) {


        for ($i=0;$i<count($data);$i++) {
            $query = $data[$i];
            $query = str_replace("\n","",$query);
            $query = str_replace("\r","",$query);

            if ($query == "") continue;
            if ($query[0] == "-") continue;

            $result = $this->mysqli->query($query);
            if ($result == false) return false;
        }

        return true;

    }

}