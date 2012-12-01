<?php namespace tinyPHP\Classes\Models;
/**
 *
 * User Model
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

class UserModel {
	
	private $db;
	
	public function __construct() {
		$this->db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->db->conn();
	}

	public function userList() {
		$q = $this->db->select(TP . 'users', 'id,login,role', null, null);
		while($r = $q->fetch_assoc()) {
			$array[] = $r;
		}
		return $array;
	}
	
	public function userSingleList($id) {		
		$q = $this->db->select(TP . "users", "id,login,role", "id = '$id'", null);
		while($r = $q->fetch_assoc()) {
			$array[] = $r;
		}
		return $array;
	}
	
	public function create($data) {
		$tp_hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
		
		$this->db->insert(TP . 'users', array(
			$this->db->escape( $data['login'] ),
			$tp_hasher->HashPassword( $this->db->escape( $data['password'] ) ),
			$this->db->escape( $data['role'] )
			),
			'login,
			password,
			role');
	}
	
	public function editSave($data) {
		$tp_hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, FALSE);
		$pass = $this->db->escape($data['password']);
		
		$login = $this->db->escape( $data['login'] );
		$password = $tp_hasher->HashPassword( $pass );
		$role = $this->db->escape( $data['role'] );
		$id = $data['id'];
		
		$this->db->query( "UPDATE " . TP . "users SET login='$login',password='$password',role='$role' WHERE id = '$id' ");
	}
	
	public function delete($id) {
		$q = $this->db->query("SELECT role FROM " . TP . "users WHERE id = '$id'");
		$r = $q->fetch_array();

		if ($r['role'] == 'owner')
		return false;
		
		$this->db->delete(TP . 'users', "id = '$id'");
	}
	
	public function __destruct() {
		$this->db->disconnect();
	}
	
}