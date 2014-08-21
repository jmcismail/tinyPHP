<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Permission Edit View
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
use \tinyPHP\Classes\Libraries\ACL;
$ePerm = new ACL();
?>

<h1><?=_t( 'Permission: Edit' );?></h1>

<form class="form-horizontal margin-none" action="<?=BASE_URL;?>permission/editSaveDeletePerm/" id="validateSubmitForm" method="post" autocomplete="off">
	<label><?=_t( 'Name' );?></label><input type="text" name="permName" value="<?=$ePerm->getPermNameFromID(isGetSet('permID'));?>" required/><br />
	<label><?=_t( 'Key' );?></label><input type="text" name="permKey" value="<?=$ePerm->getPermKeyFromID(isGetSet('permID'));?>" required/><br />
	<input type="hidden" name="savePerm" value="savePerm" />
	<input type="hidden" name="permID" value="<?=isGetSet('permID');?>" />
	<label>&nbsp;</label><input class="btn" type="submit" value="Save" />
</form>