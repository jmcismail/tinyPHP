<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * Auth Library
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
use \tinyPHP\Classes\Libraries\Auth as Access;

class Auth {
	
	private $db;
	
    public function __construct() {
    	$this->db = new \tinyPHP\Classes\Core\MySQLiDriver();
		$this->db->conn();
    }
	
	/**
	 * The is_user_logged_in method selects a user
	 * from the database based on if a hashed token
	 * cookie is present on the user's computer. If so,
	 * then we use the pm_check_password function to check
	 * the plaintext username against the hashed cookie name
	 * and the unique (int) user_id against the hashed cookie id.
	 * If it comes back true, then the user will be loggedIn in
	 * automatically.
	 */
	public static function is_logged_in() {
		$cookie_name = isset($_COOKIE['tp_cookname']);
			$cookie_name = str_replace('tpname_', '', $cookie_name);
		$cookie_id = isset($_COOKIE['tp_cookid']);
			$cookie_id = str_replace('tpid_', '', $cookie_id);
		
		$results = $this->db->get_row( "SELECT user_id, username, auth_token FROM " . TP . "users WHERE auth_token = '" . $cookie_id . "'" );
		
		if( !Sess::set('loggedIn', true) ) {
			if(isset($_COOKIE['tp_cookname']) && isset($_COOKIE['tp_cookid'])) {
				if(!Access::tp_authenticate_cookie($results->username, $cookie_name, $results->user_id) && 
					!Access::tp_authenticate_cookie($results->user_id, $cookie_id, $results->user_id)) {
					unset( Sess::get('loggedIn') );
	  				unset( Sess::get('username') );
        			unset( Sess::get('userID') );
					header("Location: " . BASE_URL . LOGIN_SLUG);
				} else {
					Sess::set('loggedIn', true);
					Sess::set('username', $results->username);
					Sess::set('userID', $results->user_id);
					header("Location: " . BASE_URL . ADMIN_SLUG);
				}
			}
		}

   		/* Username and user_id have been set and not null */
      	if(Sess::get('username') && Sess::get('userID') && Sess::get('username') != '') {
      		return Sess::get('loggedIn');
			header("Location: " . BASE_URL . ADMIN_SLUG);
	  	} else {
	  		unset(Sess::get('loggedIn'));
	  		unset(Sess::get('username'));
        	unset(Sess::get('userID'));
			header("Location: " . BASE_URL . LOGIN_SLUG);
	  	}
	}
	
	/**
	 * Logs in user and sets the session and cookie.
	 *
	 * @since 1.0
	 * @uses apply_filter() Calls 'login' filter.
	 * @param string $username Username entered by the user
	 * @param string $password Password entered by the user
	 * @param string $remember Remember sets longer cookie session (optional)
	 * @return bool True if $username and $password exist
	 * 
	 */
	public static function tp_login($username, $password, $remember = '') {
		$user = strtolower($this->db->escape($username));
		$pass = $this->db->escape($password);
		
		/* Use to set cookie session for domain. */
        $cookiedomain = $_SERVER['SERVER_NAME']; 
        $cookiedomain = str_replace('www.', '', $cookiedomain);
		
		$results = $this->db->get_row( "SELECT user_id, username, password, auth_token FROM ". TP ."users WHERE username = '$user' AND active = '1'" );
		
		if(tp_check_password( $pass, $results->password, $results->user_id )) {

			if(isset($remember)) {
				/* Insert the auth_token into the database based on user_id. */
				$this->db->update( TP . 'users', array( 'auth_token' => Access::tp_hash_cookie($results->user_id) ), array( 'username', $results->username ) );
				
				/* Select the auth_token after it has been inserted for the user. */
				$sql = $this->db->select( TP . 'users', 'auth_token', 'username = "' . $results->username . '"', null );
				$result = $sql->fetch_object();
				
				/* Now we can set login our cookies. */
      			setcookie("tp_cookname", 'tpname_' . Access::tp_hash_cookie($results->username), time()+COOKIE_EXPIRE, COOKIE_PATH, $cookiedomain);
      			setcookie("tp_cookid", 'tpid_' . $result->auth_token, time()+COOKIE_EXPIRE, COOKIE_PATH, $cookiedomain);
   			}
			
			Sess::set('loggedIn', true); // Sets the loggedIn in session.
			Sess::set('username', $results->username); // Sets the username session.
			Sess::set('userID', $results->user_id); // Sets the user_id session.
			
			header("Location: " . BASE_URL . ADMIN_SLUG);
			
		}
		
	}
	
	/**
	 * Adds error to the css class of the
	 * login fields.
	 */
	public static function login_error() {
		
		$error = \tinyPHP\Classes\Libraries\Messages::notice(37);
		_e( $error );
		
	}

	public static function tp_logout() {
		if(isset($_COOKIE['tp_cookname']) && isset($_COOKIE['tp_cookid'])){
        	setcookie("tp_cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
         	setcookie("tp_cookid", "", 	 time()-COOKIE_EXPIRE, COOKIE_PATH);
			$this->db->update( TP . 'users', array( 'auth_token' => '' ), array( 'username', Sess::get('username') ) );
      	}
				
		Sess::destroy();
		header("Location: " . BASE_URL . LOGIN_SLUG);
	}
	
	public static function tp_hash_cookie($cookie) {
		// By default, use the portable hash from phpass
		$ck_hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, TRUE);

			return $ck_hasher->HashPassword($cookie);
	}
	 
	public static function tp_authenticate_cookie($cookie, $cookiehash, $user_id = '') {

		$ck_hasher = new \tinyPHP\Classes\Libraries\PasswordHash(8, TRUE);

		$check = $ck_hasher->CheckPassword($cookie, $cookiehash);
		
	}
}