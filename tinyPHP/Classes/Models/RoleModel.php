<?php namespace tinyPHP\Classes\Models;
use \tinyPHP\Classes\Core\DB;
use \tinyPHP\Classes\Libraries\Hooks;
/**
 *
 * Role Model
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

class RoleModel {

	public function role() {
		$bind = [ ":id" => isGetSet('roleID') ];
		$array = [];
		$q = DB::inst()->select('role','ID=:id','','*',$bind);
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
    
    public function editSaveRole($data) {
        $roleid = $data['roleID'];
        $roleName = $data['roleName'];
        
        if (isset($data['action'])) {
            $strSQL = DB::inst()->query( sprintf("REPLACE INTO `role` SET `ID` = %u, `roleName` = '%s'",$roleid,$roleName ) );
            if ($strSQL->rowCount() > 1)
            {
                $roleID = $roleid;
            } else {
                $roleID = DB::inst()->lastInsertId();
            }
            foreach ($_POST as $k => $v)
            {
                if (substr($k,0,5) == "perm_")
                {
                    $permID = str_replace("perm_","",$k);
                    if ($v == 'X')
                    {
                        $strSQL = sprintf("DELETE FROM `role_perms` WHERE `roleID` = %u AND `permID` = %u",$roleID,$permID);
                        DB::inst()->query($strSQL);
                        continue;
                    }
                    $strSQL = sprintf("REPLACE INTO `role_perms` SET `roleID` = %u, `permID` = %u, `value` = %u, `addDate` = '%s'",$roleID,$permID,$v,date ("Y-m-d H:i:s"));
                    DB::inst()->query($strSQL);
                }
            }
        }
        redirect(BASE_URL . 'role/');
    }
	
	public function runRole($data) {
        $roleID = $data['roleID'];
        $roleName = $data['roleName'];
		$rolePerm = Hooks::maybe_serialize($data['permission']);
		
        $strSQL = DB::inst()->query( sprintf("REPLACE INTO `role` SET `ID` = %u, `roleName` = '%s', `permission` = '%s'",$roleID,$roleName,$rolePerm ) );
        redirect(BASE_URL . 'role/');
    }
    
    public function deleteRole($data) {
        $id = $data['roleID'];
        
        if (isset($data['delRole'])) :
            
            $strSQL = sprintf("DELETE FROM `role` WHERE `ID` = '%u' LIMIT 1",$id);
            DB::inst()->query($strSQL);
            $strSQL = sprintf("DELETE FROM `user_roles` WHERE `roleID` = '%u'",$id);
            DB::inst()->query($strSQL);
            $strSQL = sprintf("DELETE FROM `role_perms` WHERE `roleID` = '%u'",$id);
            DB::inst()->query($strSQL);
        endif;
    }
	
	public function __destruct() {
		DB::inst()->close();
	}

}