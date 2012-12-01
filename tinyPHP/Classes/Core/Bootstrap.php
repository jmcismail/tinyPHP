<?php namespace tinyPHP\Classes\Core;
/**
 *
 * Bootstrap
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

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

class Bootstrap {

	public function __construct() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);
		
		if (empty($url[0])) {
			$controller = new \tinyPHP\Classes\Controllers\Index();
			$controller->index();
			return false;
		}

		$file = SYS_PATH . 'Classes' . DS . 'Controllers' . DS . ucfirst($url[0]) . '.php';
		if (file_exists($file)) {
			require $file;
		} else {
			$this->error();
		}
		
		$loadController = "\\tinyPHP\\Classes\\Controllers\\".$url[0];
		$name = $url[0];
		$controller = new $loadController;
		$controller->loadModel($name);
		
		$length = count($url);
        
        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($controller, $url[1])) {
                $this->error();
            }
        }
        
        // Determine what to load
        switch ($length) {
            case 5:
                $controller->{$url[1]}($url[2], $url[3], $url[4]);
                break;
            
            case 4:
                $controller->{$url[1]}($url[2], $url[3]);
                break;
            
            case 3:
                $controller->{$url[1]}($url[2]);
                break;
            
            case 2:
                $controller->{$url[1]}();
                break;
            
            default:
                $controller->index();
                break;
        }	
	}
	
	public function error() {
		$controller = new \tinyPHP\Classes\Controllers\Error();
		$controller->index();
		return false;
	}

}