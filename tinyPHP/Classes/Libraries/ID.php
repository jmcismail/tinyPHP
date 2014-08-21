<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * Random ID Generator
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

class ID {
    
    public static function num($length) {
        $characters = "0123456789876543210123456789012345678987654321"; 
        $randomString = "";
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[mt_rand(0, strlen($characters)-1)];
            }
        return $randomString;
    }
    
    public static function pass($length) {
        $characters = "ad$^SSG@448#%&Fds^@@&#FrRS{F467sS6see}"; 
        $randomString = "";
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[mt_rand(0, strlen($characters)-1)];
            }
        return $randomString;
    }
    
    public static function string($length) {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZYXWVUTSRQPONMLKJIHGFEDCBAZ"; 
        $randomString = "";
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[mt_rand(0, strlen($characters)-1)];
            }
        return $randomString;
    }

}