<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * Messages Library
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

class Messages {
    
    private $_cookie;
    
    public function __construct() {
        $this->_cookie = new \tinyPHP\Classes\Libraries\Cookies;
    }
    
    public function init($name,$value) {
        /** Set the session values */
        $this->_cookie->_setcookie($name, $value);
    }
    
    public function flashMessage() {
        // get the message (they are arrays, to make multiple positive/negative messages possible)
        $success_message[] = $_COOKIE['success_message'];
        $error_message[] = $_COOKIE['error_message'];
        
        // echo out positive messages
        if (isset($_COOKIE['success_message'])) {
            foreach ($success_message as $message) {
                $this->_cookie->_setcookie('success_message', '', time()-COOKIE_EXPIRE);
                return '<section class="panel success-panel"><div class="alert alert-success center">'.$message.'</div></section>';
            }
        }
        
        // echo out negative messages
        if (isset($_COOKIE['error_message'])) {
            foreach ($error_message as $message) {
                $this->_cookie->_setcookie('error_message', '', time()-COOKIE_EXPIRE);
                return '<section class="panel error-panel"><div class="alert alert-error center">'.$message.'</div></section>';
            }
        }
    }
    
    public function notice($num) {
        $msg[1] = _t('The user\'s profile was updated successfully');
        $msg[2] = _t('There was an error with updating the user\'s profile. Please try again. If the problem persists, contact your system administrator.');
        return $msg[$num];
    }

}