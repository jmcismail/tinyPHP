<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * Index Controller
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

class Index extends \tinyPHP\Classes\Core\Controller {
    
    private $_auth;

	public function __construct() {
		parent::__construct();
        $this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
        if($this->_auth->isUserLoggedIn()) { redirect( BASE_URL . 'dashboard/' ); }
	}
	
	public function index() {
	    $this->view->title = [ _t('Main') ];
		$this->view->render('index/index');
	}
	
}