<?php namespace tinyPHP\Classes\Controllers;
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

use \tinyPHP\Classes\Core\Session as Sess;
class Dashboard extends \tinyPHP\Classes\Core\Controller {

	public function __construct() {
		parent::__construct();
		Sess::init();
		$logged = Sess::get('loggedIn');
		if ($logged == false) {
			Sess::destroy();
			header('location: ../login');
			exit;
		}
		
	}
	
	public function index() {
		$this->view->msg = _t('Welcome to the dashboard. Unfortunately, there is not much to see here.');
		$this->view->render('dashboard/index');
	}
	
	public function logout() {
		Sess::destroy();
		header('location: ' . BASE_URL .  'login');
		exit;
	}

}