<?php namespace tinyPHP\Classes\Models;
/**
 *
 * Login Model
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
 * @since tinyPHP(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

use \tinyPHP\Classes\Core\Session as Sess;
class LoginModel {
	
	private $db;
	
	public function __construct() {
		$this->db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->db->conn();
	}
	
	public function run() {
		
		$user = $this->db->escape( $_POST['login'] );
		$pass = $this->db->escape( $_POST['password'] );
		
		$tp_hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
		
		$q = $this->db->query("SELECT id, role, password FROM " . TP . "users WHERE 
				login = '$user'");
		$r = $q->fetch_array();
		
		if ($tp_hasher->CheckPassword($pass, $r['password'])) {
			// login
			Sess::init();
			Sess::set('role', $r['role']);
			Sess::set('loggedIn', true);
			header('location: ../dashboard');
		} else {
			header('location: ../login');
		}
		
	}
	
	public function __destruct() {
		$this->db->disconnect();
	}
	
}