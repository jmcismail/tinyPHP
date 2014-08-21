<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
/**
 *
 * Filters Helper
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

    use \tinyPHP\Classes\Libraries\Hooks;
    
    /**
     * Parses a string into variables to be stored in an array.
     *
     * Uses {@link http://www.php.net/parse_str parse_str()}
     *
     * @since 1.0.0
     * @param string $string The string to be parsed.
     * @param array $array Variables will be stored in this array.
     */
    function tp_parse_str( $string, &$array ) {
        parse_str( $string, $array );
        /**
         * Filter the array of variables derived from a parsed string.
         *
         * @since 1.0.0
         * @param array $array The array populated with variables.
         */
        $array = Hooks::apply_filter( 'tp_parse_str', $array );
    }
    
    function get_user_avatar($email, $s = 80, $class = '', $d = 'mm', $r = 'g', $img = false) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=200&d=$d&r=$r";
        $avatarsize = getimagesize($url);
        $avatar = '<img src="' . $url . '" ' . imgResize($avatarsize[1],  $avatarsize[1], $s) . ' class="'.$class .'" />';
        return Hooks::apply_filter('user_avatar', $avatar, $email, $s);
    }