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

use \tinyPHP\Classes\Core\DB;
use \tinyPHP\Classes\Libraries\Cookies;
class LoginModel {
    
    private $_auth;
	
	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
	}
	
	public function run($data) {
	    $array = [];
        $bind = [ ":login" => $data['user'] ];
		
		$q = DB::inst()->select("user","login=:login","","*",$bind);
		foreach($q as $r) {
		    $array[] = $r;
		}
        
        $cookie = sprintf("data=%s&auth=%s", urlencode($data['user']), urlencode(tp_hash_cookie($data['user'].$data['pass'])));
        $mac = hash_hmac("sha512", $cookie, rand(22,999999*1000000));
        $auth = $cookie . '&digest=' . urlencode($mac);
		
		if(tp_check_password($data['pass'], $r['password'], $r['userID'])) {
			if($data['rememberme']) {            
                /* Now we can set our login cookies. */
                $this->_auth->_setcookie("TP_COOKNAME", $auth);
                $this->_auth->_setcookie("TP_COOKID", tp_hash_cookie($r['userID']));
                $this->_auth->_setcookie("TP_REMEMBER", 'rememberme');
            } else {                
                /* Now we can set our login cookies. */
                $this->_auth->_setcookie("TP_COOKNAME", $auth, time()+86400);
                $this->_auth->_setcookie("TP_COOKID", tp_hash_cookie($r['userID']), time()+86400);
            }
            redirect( BASE_URL . 'dashboard/' );
		} else {
			redirect( BASE_URL );
		}
		
	}
	
	public function __destruct() {
        DB::inst()->close();
    }
	
}