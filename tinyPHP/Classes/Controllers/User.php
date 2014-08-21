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
 * @since tinyPHP(tm) v 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class User extends \tinyPHP\Classes\Core\Controller {
	
	private $_auth;

	public function __construct() {
		parent::__construct();
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
        if(!$this->_auth->isUserLoggedIn()) { redirect( BASE_URL ); }
	}
	
	public function index() {
		if(!hasPermission('manage_users')) { redirect( BASE_URL . 'dashboard/' ); }
	    $this->view->title = [ _t('User List') ];
		$this->view->userList = $this->model->userList();
		$this->view->render('user/index');
	}
	
	public function create() {
		if(!hasPermission('create_user')) { redirect( BASE_URL . 'dashboard/' ); }
		$data = [];
		$data['login'] = isPostSet('login');
        $data['fname'] = isPostSet('fname');
        $data['lname'] = isPostSet('lname');
		$data['password'] = isPostSet('password');
		$this->model->create($data);
		redirect( BASE_URL . 'user/' );
	}
	
	public function edit($id) {
		if(!hasPermission('edit_user')) { redirect( BASE_URL . 'dashboard/' ); }
	    $this->view->title = [ _t('Edit User') ];
		$this->view->user = $this->model->userSingleList($id);
		$this->view->render('user/edit');
	}
	
	public function role($id) {
        if(!hasPermission('manage_user_roles')) { redirect( BASE_URL . 'dashboard/' ); }
		$this->view->title = array(_t('User Roles'));
        $this->view->role = $this->model->rolePerm($id);
        if(empty($this->view->role)) {
            redirect( BASE_URL . 'error/' );
        }
        $this->view->render('user/role');
    }
	
	public function perm($id) {
        if(!hasPermission('manage_user_permissions')) { redirect( BASE_URL . 'dashboard/' ); }
		$this->view->title = array(_t('User Permissions'));
        $this->view->perms = $this->model->rolePerm($id);
        if(empty($this->view->perms)) {
            redirect( BASE_URL . 'error/' );
        }
        $this->view->render('user/perm');
    }
	
	public function editSave() {
		if(!hasPermission('edit_user')) { redirect( BASE_URL . 'dashboard/' ); }
		$data = [];
		$data['userID'] = isPostSet('userID');
		$data['login'] = isPostSet('login');
		$data['fname'] = isPostSet('fname');
		$data['lname'] = isPostSet('lname');
		$data['password'] = isPostSet('password');
		$this->model->editSave($data);
		redirect( BASE_URL . 'user/' );
	}
	
	public function runRolePerm() {
        if(!hasPermission('manage_user_roles')) { redirect( BASE_URL . 'dashboard/' ); }
        $data = array();
        $data['userID'] = isPostSet('userID');
        $this->model->runRolePerm($data);       
    }
	
	public function runUserPerm() {
		if(!hasPermission('manage_user_permissions')) { redirect( BASE_URL . 'dashboard/' ); }
        $data = array();
        $data['userID'] = isPostSet('userID');
        $data['permission'] = isPostSet('permission');
        $this->model->runUserPerm($data);
    }
	
	public function delete($id) {
		if(!hasPermission('delete_user')) { redirect( BASE_URL . 'dashboard/' ); }
		$this->model->delete($id);
		redirect( BASE_URL . 'user/' );
	}
}