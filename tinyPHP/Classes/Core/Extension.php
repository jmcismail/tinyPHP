<?php namespace tinyPHP\Classes\Core;
/**
 *
 * Extension Helpers
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

class Extension {
	
	/**
	 * List of paths to load helpers from
	 *
	 * @var array
	 */
	protected $helper_paths =	array();
	
	/**
	 * List of loaded helpers
	 *
	 * @var array
	 */
	protected $helpers = array();
	
	public function __construct() {}
	
	/**
	 * Load Helper
	 *
	 * This function loads the specified helper file.
	 *
	 * @param mixed
	 * @return void
	*/
	public function helper($helpers = array()) {
		foreach ($this->prep_filename($helpers, '_helper') as $helper) {
			if(isset($this->helpers[$helper])) {
				continue;
			}
	
			$ext_helper = APP_PATH . 'Helpers/ext_'.$helper.'.php';
			$base_helper = SYS_PATH . 'Helpers/'.$helper.'.php';
	
			// Is this a helper extension request?
			if (file_exists($ext_helper)) {
			
				if ( !file_exists($ext_helper)) {
					echo 'Unable to load the requested file: ' . APP_PATH . 'Helpers/ext_'.$helper.'.php';
				}
		
				include_once($ext_helper);
			
				$this->helpers[$helper] = TRUE;
					continue;
			} else
			// Is this a base helper request?
			if (file_exists($base_helper)) {
				if ( !file_exists($base_helper)) {
					echo 'Unable to load the requested file: ' . SYS_PATH . 'Helpers/'.$helper.'.php';
				}
				
				include_once($base_helper);
			
				$this->helpers[$helper] = TRUE;
					continue;
			} 
				
	
			// Try to load the helper
			foreach ($this->helper_paths as $path) {
				if (file_exists($path.'Helpers/'.$helper.'.php')) {
				include_once($path.'Helpers/'.$helper.'.php');
				
				$this->helpers[$helper] = TRUE;
				break;
				}
			}
	
			// unable to load the helper
			if ( !isset($this->helpers[$helper])) {
			echo 'Unable to load the requested file: ' . SYS_PATH . 'Helpers/'.$helper.'.php';
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Load Helpers
	*
	* This is simply an alias to the above function in case the
	* user has written the plural form of this function.
	*
	* @param array
	* @return void
	*/
	public function helpers($helpers = array()) {
		$this->helper($helpers);
	}
	
	/**
	 * Prep filename
	 *
	 * This function preps the name of various items to make loading them more reliable.
	 *
	 * @param mixed
	 * @param string
	 * @return array
	 */
	protected function prep_filename($filename, $extension) {
		if ( ! is_array($filename)) {
			return array(strtolower(str_replace(array($extension, '.php'), '', $filename).$extension));
		} else {
			foreach ($filename as $key => $val) {
			$filename[$key] = strtolower(str_replace(array($extension, '.php'), '', $val).$extension);
		}
		
		return $filename;
		}
	}
	
}