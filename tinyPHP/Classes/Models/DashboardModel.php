<?php namespace tinyPHP\Classes\Models;
use \tinyPHP\Classes\Core\DB;
/**
 *
 * Dashboard Model
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

class DashboardModel {

	private $_auth;
	
	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies;
	}
	
	/**
	 * Logs the user out and unsets cookie and database auth_token
	 *
	 * @since 1.0.0
	 * @return bool True if called
	 * 
	 */
	public function logout() {
		$uname = $this->_auth->getUserField('login');
        $update = array( "auth_token" => 'NULL' );
        $bind = array( ":login" => $uname );
        
        DB::inst()->update( "user", $update, "login = :login", $bind );
		
		$this->_auth->_setcookie("TP_COOKNAME", '', time()-COOKIE_EXPIRE);
      	$this->_auth->_setcookie("TP_COOKID", '', time()-COOKIE_EXPIRE);
		$this->_auth->_setcookie("TP_REMEMBER", '', time()-COOKIE_EXPIRE);
		redirect( BASE_URL );
	}

}