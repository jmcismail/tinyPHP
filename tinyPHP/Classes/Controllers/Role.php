<?php namespace tinyPHP\Classes\Controllers;
use \tinyPHP\Classes\Libraries\Cookies;
/**
 *
 * Role Controller
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

class Role extends \tinyPHP\Classes\Core\Controller {
    
    private $_auth;

	public function __construct() {
		parent::__construct();
        $this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
        if(!hasPermission('manage_roles')) { redirect( BASE_URL . 'dashboard/' ); }
	}
	
	public function index() {
        $this->view->title = array(_t('Manage Roles'));
        $this->view->render('role/index');
    }
    
    public function add() {
        $this->view->title = array(_t('Add Role'));
        $this->view->render('role/add');
    }
    
    public function view() {
        $this->view->title = array(_t('View Role'));
		$this->view->role = $this->model->role();
		if(empty($this->view->role)) {
            redirect( BASE_URL . 'error/' );
        }
        $this->view->render('role/view');
    }
    
    public function runRolePerm() {
        $data = array();
        $data['userID'] = isPostSet('userID');
        $this->model->runRolePerm($data);       
    }
    
	public function runRole() {
        $data = array();
        $data['roleID'] = isPostSet('roleID');
        $data['roleName'] = isPostSet('roleName');
        $data['permission'] = isPostSet('permission');
        $this->model->runRole($data);
    }
	
    public function editSaveRole() {
        $data = array();
        $data['roleID'] = isPostSet('roleID');
        $data['roleName'] = isPostSet('roleName');
        $data['action'] = isPostSet('action');
        $this->model->editSaveRole($data);
    }

}