<?php namespace tinyPHP\Classes\Libraries;
use \tinyPHP\Classes\Core\DB;
use \tinyPHP\Classes\Libraries\Hooks;
/**
 *
 * Cookies Class
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

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Cookies {
    
    public function __construct() {}
    
    /**
     * Cookie Name
     *
     * @since 1.0.0
     * @return bool Returns true if set
     * 
     */ 
    public function getCookieName() {
        if(isset($_COOKIE['TP_COOKNAME'])) {
            return $_COOKIE['TP_COOKNAME'];
        }
    }
    
    /**
     * Cookie ID
     *
     * @since 1.0.0
     * @return bool Returns true if set
     * 
     */ 
    public function getCookieID() {
        if(isset($_COOKIE['TP_COOKID'])) {
            return $_COOKIE['TP_COOKID'];
        }
    }
    
    /**
     * Retrieve user data
     *
     * @since 1.0.0
     * @param string (required) $field User data to print from database.
     * @return mixed
     * 
     */ 
    public function getUserField($field) {
        $vars = array();
        parse_str($this->getCookieName(), $vars);
        
        if(!isset($vars['data'])) {
            return NULL;
        }
        
        $bind = array( ":data" => $vars['data'] );
        
        $sql = DB::inst()->select( "user","login = :data","","*",$bind );
        foreach($sql as $r) {
            return _h($r[$field]);
        }
    }
    
    /**
     * Verify User's Username
     *
     * @since 1.0.0
     * @return bool Returns true if the user's username exists in the database.
     * 
     */
    public function verifyUser() {
        $vars = [];
        parse_str($this->getCookieName(), $vars);
        
        if(!isset($vars['data'])) {
            return NULL;
        }
        
        $bind = array( ":data" => $vars['data'] );
        
        $sql = DB::inst()->select( "user","login = :data","","login",$bind );
        foreach( $sql as $r ) {
            if(_h($r['login']) == $vars['data']) {
                return true;
            }
        }
    }
    
    /**
     * Checks if user is logged in.
     *
     * @since 1.0.0
     * @return mixed Returns true if cookie hashes exist.
     * 
     */ 
    public function isUserLoggedIn() {
        if($this->verifyUser() && $this->getCookieID()) {
            return true;
        } else {
            return false;
        }
        Hooks::add_action('init','isUserLoggedIn');
    }
    
    /**
     * Returns cookie domain
     *
     * @since 1.0.0
     * @return mixed
     * 
     */ 
    public function cookieDomain() {
        /* Use to set cookie session for domain. */
        $parts = explode('.',$_SERVER['SERVER_NAME']);
        $cookiedomain = $_SERVER['SERVER_NAME'];
        $cookiedomain = str_replace('www.', '', $cookiedomain);
        if (count($parts) == 3) {
            if($parts[0] == 'www' || $parts[0] == '') {
                return Hooks::apply_filter('cookie_domain', $cookiedomain);
            }
        }
    }
    
    /**
     * Retrieve requested field from user table 
     * based on user's id.
     *
     * @since 3.0.2
     * @return mixed
     * 
     */
    public function getUserValue($id,$field) {
        $bind = [ ":id" => $id ];
        $q = DB::inst()->select( "user","userID = :id","",$field,$bind );
        foreach($q as $r) {
            return $r[$field];
        }
    }
    
    /**
     * Set the cookie
     *
     * @since 3.0.2
     * @return mixed
     * 
     */ 
    public function _setcookie($name,$value,$expire=COOKIE_EXPIRE,$path=COOKIE_PATH,$domain='',$secure=false,$httponly=false) {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
    
    /**
     * Hash Hmac
     * 
     * @since 3.0.2
     * @return mixed
     * 
     */
    public function hashHmac($login) {
        $cookie = sprintf("data=%s&auth=%s", urlencode($login), urlencode(tp_hash_cookie($login.\tinyPHP\Classes\Libraries\ID::pass(12))));
        $mac = hash_hmac("sha512", $cookie, rand(22,999999*1000000));
        $auth = $cookie . '&digest=' . urlencode($mac);
        return $auth;
    }
    
    /**
     * Switch to a different user
     *
     * @since 3.0.2
     * @return mixed
     * 
     */ 
    public function _switchUserTo($id) {        
        if(isset($_COOKIE['TP_REMEMBER']) && $_COOKIE['TP_REMEMBER'] == 'rememberme') {
            $this->_setcookie("SWITCH_USERBACK", $this->getUserField('userID'));
            $this->_setcookie("SWITCH_USERNAME", $this->getUserField('login'));
        } else {
            $this->_setcookie("SWITCH_USERBACK", $this->getUserField('userID'), time()+86400);
            $this->_setcookie("SWITCH_USERNAME", $this->getUserField('login'), time()+86400);
        }
        
        $auth = $this->hashHmac($this->getUserValue($id,'login'));
        
        /**
         * Delete the old cookies.
         */
        $this->_setcookie("TP_COOKNAME", '', time()-COOKIE_EXPIRE);
        $this->_setcookie("TP_COOKID", '', time()-COOKIE_EXPIRE);
        
        if(isset($_COOKIE['TP_REMEMBER']) && $_COOKIE['TP_REMEMBER'] == 'rememberme') {
            $this->_setcookie("TP_COOKNAME", $auth);
            $this->_setcookie("TP_COOKID", tp_hash_cookie($id));
        } else {
            $this->_setcookie("TP_COOKNAME", $auth, time()+86400);
            $this->_setcookie("TP_COOKID", tp_hash_cookie($id), time()+86400);
        }
    }
    
     /**
     * Switch back to the original user
     *
     * @since 3.0.2
     * @return mixed
     * 
     */ 
    public function _switchUserBack($id) {        
        if(isset($_COOKIE['TP_REMEMBER']) && $_COOKIE['TP_REMEMBER'] == 'rememberme') {
            $this->_setcookie("TP_COOKNAME", '', time()-COOKIE_EXPIRE);
            $this->_setcookie("TP_COOKID", '', time()-COOKIE_EXPIRE);
            $this->_setcookie("SWITCH_USERBACK", '', time()-COOKIE_EXPIRE);
            $this->_setcookie("SWITCH_USERNAME", '', time()-COOKIE_EXPIRE);
        } else {
            $this->_setcookie("TP_COOKNAME", '', time()-86400);
            $this->_setcookie("TP_COOKID", '', time()-86400);
            $this->_setcookie("SWITCH_USERBACK", '', time()-86400);
            $this->_setcookie("SWITCH_USERNAME", '', time()-86400);
        }
        
        $auth = $this->hashHmac($this->getUserValue($id,'login'));
        
        if(isset($_COOKIE['TP_REMEMBER']) && $_COOKIE['TP_REMEMBER'] == 'rememberme') {
            $this->_setcookie("TP_COOKNAME", $auth);
            $this->_setcookie("TP_COOKID", tp_hash_cookie($id));
        } else {
            $this->_setcookie("TP_COOKNAME", $auth, time()+86400);
            $this->_setcookie("TP_COOKID", tp_hash_cookie($id), time()+86400);
        }
    }

}