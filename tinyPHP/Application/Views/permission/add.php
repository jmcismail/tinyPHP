<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Add Permission View
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
?>

<h1><?=_t( 'Add Permission' );?></h1>

<form class="form-horizontal margin-none" action="<?=BASE_URL;?>permission/editSaveDeletePerm/" id="validateSubmitForm" method="post" autocomplete="off">
	<label><?=_t( 'Name' );?></label><input type="text" name="permName" required/><br />
	<label><?=_t( 'Key' );?></label><input type="text" name="permKey" required/><br /><br />
	<input type="hidden" name="savePerm" value="savePerm" />
	<label>&nbsp;</label><input class="btn" type="submit" />
</form>