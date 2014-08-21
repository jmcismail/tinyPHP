<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Edit Role View
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
use \tinyPHP\Classes\Libraries\ACL as ACL;
$eRole = new ACL();
?>

<h1><?=_t( 'Role: Edit' );?></h1>

<form class="form-horizontal margin-none" action="<?=BASE_URL;?>role/runRole/" id="validateSubmitForm" method="post" autocomplete="off">
	<label><?=_t( 'Role Name' ); ?></label><input type="text" name="roleName" value="<?=$eRole->getRoleNameFromID(isGetSet('roleID'));?>" required/><br />
	<!-- Table -->
	<table class="table table-striped table-bordered table-condensed table-white">
	
		<!-- Table heading -->
		<thead>
			<tr>
				<th><?=_t( 'Permission' );?></th>
				<th><?=_t( 'Allow' );?></th>
			</tr>
		</thead>
		<!-- // Table heading END -->
		
		<tbody>
			<?php rolePerm(isGetSet('roleID')); ?>
		</tbody>
	
	</table>
	<!-- // Table END -->
	<input type="hidden" name="action" value="saveRole" />
	<input type="hidden" name="roleID" value="<?=isGetSet('roleID');?>" />
	<button type="submit" name="Submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i><?=_t( 'Save' );?></button>
</form>