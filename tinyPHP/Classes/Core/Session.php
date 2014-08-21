<?php namespace tinyPHP\Classes\Core;
/**
 *
 * Session
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

class Session {
    
    public function __construct() {}
    
    public static function init()
    {
        if(session_id() == '')
        {
            session_start();
        }
    }
    
    /**
     * sets a specific value to a specific key of the session
     * @param mixed $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * gets/returns the value of a specific key of the session
     * @param mixed $key Usually a string, right ?
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
    }
    
    /**
     * Sets error message array().
     */
    public static function error()
    {
        if (self::get('error_message'))
        {
            foreach (self::get('error_message') as $error)
            {
                return '<div class="errormsg">'.$error.'</div>';
            }
        }
    }
    
    /**
     * Deletes the sessions
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }
    
}