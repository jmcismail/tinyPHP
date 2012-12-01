<?php namespace tinyPHP\Classes\Core;
/**
 *
 * View
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

class View {

	public function __construct() {}

	public function render($name, $include = false) {
		if ($include == true) {
			require( APP_PATH . 'Views' . DS . $name . '.php' );	
		}
		else {
			require( APP_PATH . 'Views' . DS . 'header.php' );
			require( APP_PATH . 'Views' . DS . $name . '.php' );
			require( APP_PATH . 'Views' . DS . 'footer.php' );	
		}
	}

}