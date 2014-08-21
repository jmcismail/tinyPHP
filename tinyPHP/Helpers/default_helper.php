<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
use \tinyPHP\Classes\Core\DB;
/**
 *
 * Default Helper
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

 	if( !function_exists('imgResize') ) {
 		
		function imgResize($width, $height, $target) {
			//takes the larger size of the width and height and applies the formula. Your function is designed to work with any image in any size.
			if ($width > $height) {
				$percentage = ($target / $width);
			} else {
				$percentage = ($target / $height);
			}
	
			//gets the new value and applies the percentage, then rounds the value
			$width = round($width * $percentage);
			$height = round($height * $percentage);
			//returns the new sizes in html image tag format...this is so you can plug this function inside an image tag so that it will set the image to the correct size, without putting a whole script into the tag.
			return "width=\"$width\" height=\"$height\"";
		}
	
	}
	
	// An alternative function of using the echo command.
	if( !function_exists('_e') ) {
		
		function _e($string) {
			echo $string;
		}
	
	}

	if( !function_exists('clickableLink') ) {
		
		function clickableLink($text = '') {
			$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
			$ret = ' ' . $text;
			$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
			
			$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
			$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
			$ret = substr($ret, 1);
			return $ret;
		}
	
	}

	/**
 	* Outputs the html checked attribute.
 	*
 	* Compares the first two arguments and if identical marks as checked
 	*
 	*
 	* @param mixed $checked One of the values to compare
 	* @param mixed $current (true) The other value to compare if not just true
 	* @param bool $echo Whether to echo or just return the string
 	* @return string html attribute or empty string
 	*/
 	if( !function_exists('checked') ) {
 		
	 	function checked( $checked, $current = true, $echo = true ) {
			return checked_selected_helper( $checked, $current, $echo, 'checked' );
		}
	
	}

	/**
 	* Outputs the html selected attribute.
 	*
 	* Compares the first two arguments and if identical marks as selected
 	*
 	*
 	* @param mixed $selected One of the values to compare
 	* @param mixed $current (true) The other value to compare if not just true
 	* @param bool $echo Whether to echo or just return the string
 	* @return string html attribute or empty string
 	*/
 	if( !function_exists('selected') ) {
 		
	 	function selected( $selected, $current = true, $echo = true ) {
			return checked_selected_helper( $selected, $current, $echo, 'selected' );
		}
	
	}

	/**
 	* Outputs the html disabled attribute.
 	*
 	* Compares the first two arguments and if identical marks as disabled
 	*
 	*
 	* @param mixed $disabled One of the values to compare
 	* @param mixed $current (true) The other value to compare if not just true
 	* @param bool $echo Whether to echo or just return the string
 	* @return string html attribute or empty string
 	*/
 	if( !function_exists('disabled') ) {
 		
		function disabled( $disabled, $current = true, $echo = true ) {
			return checked_selected_helper( $disabled, $current, $echo, 'disabled' );
		}
	
	}

	/**
 	* Private helper function for checked, selected, and disabled.
 	*
 	* Compares the first two arguments and if identical marks as $type
 	*
 	* @access private
 	*
 	* @param any $helper One of the values to compare
 	* @param any $current (true) The other value to compare if not just true
 	* @param bool $echo Whether to echo or just return the string
 	* @param string $type The type of checked|selected|disabled we are doing
 	* @return string html attribute or empty string
 	*/
 	if( !function_exists('checked_selected_helper') ) {
 		
	 	function checked_selected_helper( $helper, $current, $echo, $type ) {
			if ( (string) $helper === (string) $current )
				$result = " $type='$type'";
			else
				$result = '';
	
			if ( $echo )
				echo $result;
	
			return $result;
		}
	
	}
	 
	 /**
	 * Return the full URL to a location on this site
	 *
	 * @param string $path to use or FALSE for current path
	 * @param array $params to append to URL
	 * @return string
	 */
	if( !function_exists('site_url') ) {
		
		function site_url($path = NULL, array $args = NULL) {
			return DOMAIN . ($path ? '/'. trim($path, '/') : PATH)
				. ($args ? '?'. str_replace('+', '%20', http_build_query($args, TRUE, '&')) : '');
		}
	
	}
	
	
	/**
	 * Return the current URL with path and query params
	 *
	 * @return string
	 */
	if( !function_exists('current_url') ) {
		
		function current_url() {
			return DOMAIN . getenv('REQUEST_URI');
		}
	
	}
    
    /**
     * Return variable if set
     *
     * @return mixed
     */
    if( !function_exists('isGetSet') ) {
        
        function isGetSet($caller) {
            if(isset($_GET[$caller])) {
                return $_GET[$caller];
            }
        }
    
    }
    
    /**
     * Return variable if set
     *
     * @return mixed
     */
    if( !function_exists('isPostSet') ) {
        
        function isPostSet($caller) {
            if(isset($_POST[$caller])) {
                return $_POST[$caller];
            }
        }
    
    }
    
    /**
    * Redirects to another page.
    *
    * @since 1.0.0
    * @param string $location The path to redirect to
    * @param int $status Status code to use
    * @return bool False if $location is not set
    */
    if( !function_exists('redirect') ) {
        
        function redirect($location, $status = 302) {
            if ( !$location )
                return false;
            header("Location: $location", true, $status);
        }
        
    }