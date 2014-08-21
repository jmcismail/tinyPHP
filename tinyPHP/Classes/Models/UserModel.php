<?php namespace tinyPHP\Classes\Models;
use \tinyPHP\Classes\Core\DB;
/**
 *
 * User Model
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

class UserModel {
	
	private $_auth;
	
	public function __construct() {
		$this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
	}

	public function userList() {
	    $array = [];
		$q = DB::inst()->select('user');
		foreach($q as $r) {
			$array[] = $r;
		}
		return $array;
	}
	
	public function userSingleList($id) {
	    $array = [];
        $bind = [ ":id" => $id ];	
		$q = DB::inst()->select('user','userID=:id','userID','userID,login,fname,lname',$bind);
		foreach($q as $r) {
			$array[] = $r;
		}
		return $array;
	}
	
	public function create($data) {
	    $bind = [ 
	               "login" => $data['login'],
	               "fname" => $data['fname'],
	               "lname" => $data['lname'],
	               "password" => tp_hash_password($data['password'])
                ];
		
		$q = DB::inst()->insert('user',$bind);
	}
	
	public function editSave($data) {
	    $update = [ 
	               "login" => $data['login'],
	               "fname" => $data['fname'],
                   "lname" => $data['lname']
                  ];
		$bind = [ ":id" => $data['userID'] ];
        $q = DB::inst()->update('user',$update,'userID=:id',$bind);
		if(!empty($data['password'])) {
			$update = [ "password" => tp_hash_password($data['password'])  ];
			$q = DB::inst()->update('user',$update,'userID=:id',$bind);
		}
	}
	
	public function rolePerm($id) {
        $array = [];
        $bind = array( ":id" => $id );
        $q = DB::inst()->select( "user","userID = :id","","userID",$bind );
        foreach($q as $r) {
            $array[] = $r;
        }
        return $array;
    }
    
    public function runRolePerm($data) {
        $userID = $data['userID'];      
        
        if (isset($_POST['action'])) {
            switch($_POST['action']) {
                case 'saveRoles':
                    foreach ($_POST as $k => $v) {
                        if (substr($k,0,5) == "role_") {
                            $roleID = str_replace("role_","",$k);
                            if ($v == '0' || $v == 'x') {
                                $strSQL = sprintf("DELETE FROM `user_roles` WHERE `userID` = %u AND `roleID` = %u",$userID,$roleID);
                            } else {
                                $strSQL = sprintf("REPLACE INTO `user_roles` SET `userID` = %u, `roleID` = %u, `addDate` = '%s'",$userID,$roleID,date ("Y-m-d H:i:s"));
                            }
                            DB::inst()->query($strSQL);
                        }
                    }
                    
                break;
                case 'savePerms':
                    foreach ($_POST as $k => $v) {
                        if (substr($k,0,5) == "perm_") {
                            $permID = str_replace("perm_","",$k);
                            if ($v == 'x') {
                                $strSQL = sprintf("DELETE FROM `user_perms` WHERE `userID` = %u AND `permID` = %u",$userID,$permID);
                            } else {
                                $strSQL = sprintf("REPLACE INTO `user_perms` SET `userID` = %u, `permID` = %u, `value` = %u, `addDate` = '%s'",$userID,$permID,$v,date ("Y-m-d H:i:s"));
                            }
                            DB::inst()->query($strSQL);
                        }
                    }
                break;
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
	
	public function runUserPerm($data) {
		if(count($data['permission']) > 0) {
			$q = DB::inst()->query( sprintf("REPLACE INTO user_perms SET `userID` = %u, `permission` = '%s'",$data['userID'],Hooks::maybe_serialize($data['permission'])) );
		} else {
			$q = DB::inst()->query( sprintf("DELETE FROM user_perms WHERE `userID` = %u",$data['userID']) );
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function delete($id) {
	    if($id == $this->_auth->getUserField('userID'))
            return false;
	    $bind = [ ":id" => $id ];
	    $q = DB::inst()->delete('user','userID=:id',$bind);
	}
	
	public function __destruct() {
        DB::inst()->close();
    }
	
}