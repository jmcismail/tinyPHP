<?php namespace tinyPHP\Classes\Controllers;
use \tinyPHP\Classes\Libraries\Cookies;
/**
 *
 * Permission Controller
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

class Permission extends \tinyPHP\Classes\Core\Controller {
    
    private $_auth;

	public function __construct() {
		parent::__construct();
        $this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
        if(!hasPermission('manage_permissions')) { redirect( BASE_URL . 'dashboard/' ); }
	}
	
	public function index() {
        $this->view->title = array(_t('Manage Permissions'));
        $this->view->render('permission/index');
    }
	
	public function add() {
        $this->view->staticTitle = array(_t('Add Permission'));
        $this->view->render('permission/add');
    }
    
    public function view() {
        $this->view->staticTitle = array(_t('View Permission'));
        $this->view->render('permission/view');
    }
    
    public function runRolePerm() {
        $data = array();
        $data['userID'] = isPostSet('userID');
        $this->model->runRolePerm($data);       
    }
    
    public function editSaveDeletePerm() {
        $data = array();
        $data['permID'] = isPostSet('permID');
        $data['permName'] = isPostSet('permName');
        $data['permKey'] = isPostSet('permKey');
        $data['savePerm'] = isPostSet('savePerm');
        $data['delPerm'] = isPostSet('delPerm');
        $this->model->editSaveDeletePerm($data);
    }

}