<?php namespace tinyPHP\Classes\Libraries;
use \tinyPHP\Classes\Core\DB;
/**
 *
 * ACL Library
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

class ACL {
    
    /**
     * Stores the permissions for the user
     *
     * @access public
     * @var array
     */     
    public $perms = array();
    
    /**
     * Stores the ID of the current user
     *
     * @access public
     * @var integer
     */
    public $id = 0;
    
    /**
     * Stores the roles of the current user
     *
     * @access public
     * @var array
     */
    public $userRoles = array();
    
    private $_auth;
    
    private $_db;
    
    public function __construct($id = '') {
        $this->_auth = new \tinyPHP\Classes\Libraries\Cookies();
        
        if ($id != '') {  
            $this->id = floatval($id);  
        } else {  
            $this->id = floatval($this->_auth->getUserField('userID')); 
        }  
        $this->userRoles = $this->getUserRoles('ids');  
        $this->buildACL();
    }
    
    public function ACL($id='')  {  
        $this->__construct($id);  
    }
    
    public function buildACL() {
        //first, get the rules for the user's role
        if (count($this->userRoles) > 0) {
            $this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
        }
        //then, get the individual user permissions
        $this->perms = array_merge($this->perms,$this->getUserPerms($this->id));
    }
    
    public function getPermKeyFromID($permID) {
        $strSQL = "SELECT `permKey` FROM `permission` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
        $data = DB::inst()->query($strSQL);
        $row = $data->fetch();
        return $row[0];
    }
    
    public function getPermNameFromID($permID) {
        $strSQL = "SELECT `permName` FROM `permission` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
        $data = DB::inst()->query($strSQL);
        $row = $data->fetch();
        return $row[0];
    }
    
    public function getRoleNameFromID($roleID) {
        $strSQL = "SELECT `roleName` FROM `role` WHERE `ID` = " . floatval($roleID) . " LIMIT 1";
        $data = DB::inst()->query($strSQL);
        $row = $data->fetch();
        return $row[0];
    }
    
    public function getUserRoles() {
        $strSQL = "SELECT * FROM `user_roles` WHERE `userID` = " . floatval($this->id) . " ORDER BY `addDate` ASC";
        $data = DB::inst()->query($strSQL);
        $resp = array();
        while($row = $data->fetch())
        {
            $resp[] = $row['roleID'];
        }
        return $resp;
    }
    
    public function getAllRoles($format='ids') {
        $format = strtolower($format);
        $strSQL = "SELECT * FROM `role` ORDER BY `roleName` ASC";
        $data = DB::inst()->query($strSQL);
        $resp = array();
        while($row = $data->fetch())
        {
            if ($format == 'full')
            {
                $resp[] = array("ID" => $row['ID'],"Name" => $row['roleName']);
            } else {
                $resp[] = $row['ID'];
            }
        }
        return $resp;
    }
    
    public function getAllPerms($format='ids') {        
        $format = strtolower($format);
        $strSQL = "SELECT * FROM `permission` ORDER BY `permName` ASC";
        $data = DB::inst()->query($strSQL);
        $resp = array();
        while($row = $data->fetch()) {
            if ($format == 'full') {
                $resp[$row['permKey']] = array('ID' => $row['ID'], 'Name' => $row['permName'], 'Key' => $row['permKey']);
            } else {
                $resp[] = $row['ID'];
            }
        }
        return $resp;
    }

    public function getRolePerms($role) {
        if (is_array($role)) {
            $roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
        } else {
            $roleSQL = "SELECT * FROM `role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";
        }
        $data = DB::inst()->query($roleSQL);
        $perms = array();
        while($row = $data->fetch()) {
            $pK = strtolower($this->getPermKeyFromID($row['permID']));
            if ($pK == '') { continue; }
            if ($row['value'] === '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
        }
        return $perms;
    }
    
    public function getUserPerms($id) {
        $strSQL = "SELECT * FROM `user_perms` WHERE `userID` = " . floatval($id) . " ORDER BY `LastUpdate` ASC";
        $data = DB::inst()->query($strSQL);
        $perms = array();
        while($row = $data->fetch()) {
            $pK = strtolower($this->getPermKeyFromID($row['permID']));
            if ($pK == '') { continue; }
            if ($row['value'] == '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['permID']),'ID' => $row['permID']);
        }
        return $perms;
    }
    
    public function userHasRole($roleID) {
        foreach($this->userRoles as $k => $v) {
            if (floatval($v) === floatval($roleID)) {
                return true;
            }
        }
        return false;
    }
    
    public function hasPermission($permKey) {
        $bind = [ ":perm" => "%$permKey%",":id" => $this->_auth->getUserField('userID') ];
        $q1 = DB::inst()->query( "SELECT 
                        a.ID 
                    FROM 
                        role a 
                    LEFT JOIN 
                        user_roles b 
                    ON 
                        a.ID = b.roleID 
                    WHERE 
                        a.permission LIKE :perm 
                    AND 
                        b.userID = :id",
                    $bind 
        );
        $q2 = DB::inst()->select('user_perms','permission LIKE :perm AND userID = :id','','ID',$bind);
        if(count($q1) > 0) {
            return true;
        } elseif(count($q2) > 0) {
            return true;
        }
		return false;
    }
    
    public function getUsername($id) {
        $strSQL = DB::inst()->select( 'user', 'userID = "' . floatval($id) . '"', null, 'login LIMIT 1' );
        $row = $strSQL->fetch();
        return $row[0];
    }
}