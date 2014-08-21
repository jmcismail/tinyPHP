<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
/**
 *
 * Auth Helper
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
    
    function hasPermission($perm) {
        $auth = new \tinyPHP\Classes\Libraries\Cookies;
        $acl = new \tinyPHP\Classes\Libraries\ACL($auth->getUserField('userID'));
		
		return $acl->hasPermission($perm);
    }
	
	function ae($perm) {
        if(!hasPermission($perm)) {
            return ' style="display:none"';
        }
    }