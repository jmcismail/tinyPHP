<?php namespace tinyPHP\Classes\Core;
/**
 *
 * PHP5 PDO Database Class
 *  
 * PHP 5
 *
 * tinyPHP(tm) : Simple & Lightweight MVC Framework (http://tinyphp.us/)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyphp.us/ tinyPHP(tm) Project
 * @since tinyPHP(tm) v 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class DB {
    
    /**
     * The dsn Previx
     *
     * @access private
     * @var constant
     */
    private $dsnPrefix = DSN_PREFIX;
	
	/**
     * The database host
     *
     * @access private
     * @var constant
     */
	private $dbhost = DB_HOST;
	
	/**
     * The database name
     *
     * @access private
     * @var constant
     */
	private $dbname = DB_NAME;
	
	/**
     * The database username
     *
     * @access private
     * @var constant
     */
	private $dbuser = DB_USER;
	
	/**
     * The database password
     *
     * @access private
     * @var constant
     */
	private $dbpass = DB_PASS;
	
	/**
     * The sql query statement
     *
     * @access private
     * @var string
     */
	private $sql;
	
	/**
     * Binds a value to a parameter
     *
     * @access private
     * @var array
     */
	private $bind;
	
	/**
     * The db database object
     *
     * @access private
     * @var object
     */
    private $db;
	
	/**
     * Create instance of the db class
     *
     * @access private
     * @var object
     */
	private static $instance = NULL;
	
	/**
     * Current result set
     *
     * @access private
     * @var object
     */
    private $result;
 
    /**
     * Error Message
     *
     * @access private
     * @var string
     */
    private $error;
    private $errorCallbackFunction;
    private $errorMsgFormat;
	
	public function __construct() {
		try {
    		$this->db = new \PDO("$this->dsnPrefix:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
            //$this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->db->query('SET NAMES utf8');
            $this->db->query('SET CHARACTER SET utf8'); 
		} catch(\PDOException $e) {
    		$this->error = 'ERROR: ' . $e->getMessage();
            return $this->error;
		}
	}
	
	 /**
     * Creates and references the db object.
     *
     * @access public
     * @return object
     */
    public static function inst() {
        if ( !self::$instance )
            self::$instance = new DB();
        return self::$instance;
    }
	
	/**
     * Close active connection to dataase.
     *
     * @access public
     * @return bool Always returns true.
     */
    public function close() {
        if ( $this->db )
            $this->db = null;
        return true;
    }
    
    private function debug() {
        if(!empty($this->errorCallbackFunction)) {
            $error = array("Error" => $this->error);
            if(!empty($this->sql))
                $error["SQL Statement"] = $this->sql;
            if(!empty($this->bind))
                $error["Bind Parameters"] = trim(print_r($this->bind, true));

            $backtrace = debug_backtrace();
            if(!empty($backtrace)) {
                foreach($backtrace as $info) {
                    if($info["file"] != __FILE__)
                        $error["Backtrace"] = $info["file"] . " at line " . $info["line"];  
                }       
            }

            $msg = "";
            if($this->errorMsgFormat == "html") {
                if(!empty($error["Bind Parameters"]))
                    $error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
                $css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
                $msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
                $msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
                foreach($error as $key => $val)
                    $msg .= "\n\t<label>" . $key . ":</label>" . $val;
                $msg .= "\n\t</div>\n</div>";
            }
            elseif($this->errorMsgFormat == "text") {
                $msg .= "SQL Error\n" . str_repeat("-", 50);
                foreach($error as $key => $val)
                    $msg .= "\n\n$key:\n$val";
            }

            $func = $this->errorCallbackFunction;
            $func($msg);
        }
    }
    
    private function filter($table, $info) {
        $driver = $this->db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        if($driver == 'sqlite') {
            $sql = "PRAGMA table_info('" . $table . "');";
            $key = "name";
        }
        elseif($driver == 'mysql') {
            $sql = "DESCRIBE " . $table . ";";
            $key = "Field";
        }
        else {  
            $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
            $key = "column_name";
        }   

        if(false !== ($list = $this->init($sql))) {
            $fields = array();
            foreach($list as $record)
                $fields[] = $record[$key];
            return array_values(array_intersect($fields, array_keys($info)));
        }
        return array();
    }
    
    private function cleanup($bind) {
        if(!is_array($bind)) {
            if(!empty($bind))
                $bind = array($bind);
            else
                $bind = array();
        }
        return $bind;
    }
	
	/**
     * Is used by all SQL query methods, but can also be used 
	 * for advanced queries.
     *
     * @access public
     * @param $sql (required) The SQL statement to execute.
	 * @param $bind (optional) values & parameters key/value array
     * @return mixed
     */
	public function init($sql, $bind="") {
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = '';

		try {
			$stmt = $this->db->prepare($this->sql);
			if($stmt->execute($this->bind) !== false) {
				if(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
					return $stmt->fetchAll(\PDO::FETCH_ASSOC);
				elseif(preg_match("/^(" . implode("|", array("delete", "insert", "update")) . ") /i", $this->sql))
					return $stmt->rowCount();
			}
		} catch (\PDOException $e) {
			$this->error = $e->getMessage();
			$this->debug();
			return false;
		}
	}
	
	/**
     * Executes query and returns results.
     *
     * @access public
     * @param $sql (required) The SQL statement to execute.
	 * @param $bind (optional) values & parameters key/value array
     * @return mixed
     */
	public function query($sql, $bind = false) {
        $this->error = '';
        
        try {
            if($bind !== false) {
                return $this->init($sql, $bind);
            } else {
                $this->result = $this->db->query($sql);
                return $this->result;
            }
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            return $this->error;
        }
    }
	
	/**
     * Selects information from the database.
	 * 
     * @param $table (required) the name of the table
     * @param $fields (optional) the columns requested, separated by commas
     * @param $where (optional) column = value as a string
     * @param $order (optional) column DIRECTION as a string
	 * @param $bind (optional) values & parameters key/value array
	 * @return mixed
     */
    public function select($table, $where=NULL, $order=NULL, $fields="*", $bind=NULL) {
        $sql = "SELECT " . $fields . " FROM " . $table;
        if(!empty($where))
                $sql .= " WHERE " . $where;
        if(!empty($order))
                $sql .= " ORDER BY ".$order;
        $sql .= ";";
        return $this->init($sql, $bind);
    }
	
	/**
     * Insert values into the table
	 * 
	 * @access public
     * @param $table (required) the name of the table
     * @param $values (required) the values to be inserted
     * @param $fields (optional) if values don't match the number of fields
	 * @param $bind (optional) values & parameters key/value array
	 * @return mixed
     */
    public function insert($table, $info) {
        $fields = $this->filter($table, $info);
        $sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
        $bind = array();
        foreach($fields as $field)
            $bind[":$field"] = $info[$field];
        return $this->init($sql, $bind);
    }
	
	/**
     * Updates the database with the values sent
	 * 
	 * @access public
     * @param $table (required) the name of the table to be updated
     * @param $fields (required) the rows/values in a key/value array
     * @param $where (required) the row/condition in an array (row,condition)
	 * @param $bind (optional) values & parameters key/value array
	 * @return mixed
     */    
    public function update($table, $info, $where, $bind="") {
        $fields = $this->filter($table, $info);
        $fieldSize = sizeof($fields);

        $sql = "UPDATE " . $table . " SET ";
        for($f = 0; $f < $fieldSize; ++$f) {
            if($f > 0)
                $sql .= ", ";
            $sql .= $fields[$f] . " = :update_" . $fields[$f]; 
        }
        $sql .= " WHERE " . $where . ";";

        $bind = $this->cleanup($bind);
        foreach($fields as $field)
            $bind[":update_$field"] = $info[$field];
        
        return $this->init($sql, $bind);
    }

    /**
     * Deletes table or records where condition is true
	 * 
	 * @access public
     * @param $table (required) the name of the table
     * @param $where (optional) condition [column =  value]
	 * @param $bind (optional) values & parameters key/value array
	 * @return mixed
     */
    public function delete($table,$where = NULL,$bind = NULL) {
        if($where == NULL) {
            $sql = 'DELETE * FROM '.$table;
        } else {
            $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
            return $this->init($sql, $bind);
        }
    }
    
    public function lastInsertId($name = NULL) {
        if(!$this->db) {
            throw new \Exception('There is no database connection.');
        }
        return $this->db->lastInsertId($name);
    }
    
    public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat="html") {
        //Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
        if(in_array(strtolower($errorCallbackFunction), array("echo", "print")))
            $errorCallbackFunction = "print_r";

        if(function_exists($errorCallbackFunction)) {
            $this->errorCallbackFunction = $errorCallbackFunction;  
            if(!in_array(strtolower($errorMsgFormat), array("html", "text")))
                $errorMsgFormat = "html";
            $this->errorMsgFormat = $errorMsgFormat;    
        }   
    }
	
	/**
     * Prevents the cloning of the db object.
     *
     * @access private
     * @return void
     */
    private function __clone() {}
	
}