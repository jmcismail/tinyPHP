<?php namespace tinyPHP\Classes\Models;
use \tinyPHP\Classes\Core\DB;
use \tinyPHP\Classes\Libraries\Util;
/**
 *
 * Permission Model
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

class PermissionModel {

	public function __construct() {}
	
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
    
    public function editSaveDeletePerm($data) {
        $permID = $data['permID'];
        $permName = $data['permName'];
        $permKey = Util::_trim($data['permKey']);
        
        if (isset($data['savePerm'])) {
            $strSQL = sprintf("REPLACE INTO `permission` SET `ID` = %u, `permName` = '%s', `permKey` = '%s'",$permID,$permName,$permKey);
            DB::inst()->query($strSQL);
        } elseif (isset($data['delPerm'])) {
            $strSQL = sprintf("DELETE FROM `permission` WHERE `ID` = %u LIMIT 1",$permID);
            DB::inst()->query($strSQL);
        }
        redirect(BASE_URL . 'permission/');
    }
	
	public function __destruct() {
		DB::inst()->close();
	}

}