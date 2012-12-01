<?php namespace tinyPHP\Classes\Controllers;
/**
 *
 * User Controller
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

class User extends \tinyPHP\Classes\Core\Controller {
	
	//public $model = null;

	public function __construct() {
		parent::__construct();
		\tinyPHP\Classes\Core\Session::init();
		$logged = \tinyPHP\Classes\Core\Session::get('loggedIn');
		$role = \tinyPHP\Classes\Core\Session::get('role');
		
		if ($logged == false || $role != 'owner') {
			\tinyPHP\Classes\Core\Session::destroy();
			header('location: ../login');
			exit;
		}
		
	}
	
	public function index() {
		$this->view->userList = $this->model->userList();
		$this->view->render('user/index');
	}
	
	public function create() {
		$data = array();
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];
		$data['role'] = $_POST['role'];
		
		$this->model->create($data);
		header('location: ' . BASE_URL . 'user');
	}
	
	public function edit($id) {
		$this->view->user = $this->model->userSingleList($id);
		$this->view->render('user/edit');
	}
	
	public function editSave($id) {
		$data = array();
		$data['id'] = $id;
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];
		$data['role'] = $_POST['role'];
		
		$this->model->editSave($data);
		header('location: ' . BASE_URL . 'user');
	}
	
	public function delete($id) {
		$this->model->delete($id);
		header('location: ' . BASE_URL . 'user');
	}
}