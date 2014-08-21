<?php namespace tinyPHP\Classes\Controllers;
use \tinyPHP\Classes\Libraries\Cookies;
/**
 *
 * Dashboard Controller
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

class Dashboard extends \tinyPHP\Classes\Core\Controller {
    
    private $_auth;

	public function __construct() {
		parent::__construct();
        $this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
        if(!$this->_auth->isUserLoggedIn()) { redirect( BASE_URL ); }
	}
	
	public function index() {
	    $this->view->title = [ _t('Dashboard') ];
		$this->view->msg = _t('Welcome <b>') . $this->_auth->getUserField('login') . _t( '</b> to the dashboard. Unfortunately, there is not much to see here.');
		$this->view->render('dashboard/index');
	}
	
	public function logout() {
		$this->model->logout();
	}

}