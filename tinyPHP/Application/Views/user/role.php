<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Edit User Role View
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

<h1><?=get_name(_h($this->role[0]['userID']));?> <?=_t( 'Role: Edit' );?></h1>

<form class="form-horizontal margin-none" action="<?=BASE_URL;?>user/runRolePerm/" id="validateSubmitForm" method="post" autocomplete="off">
	<!-- Table -->
	<table class="dynamicTable tableTools table table-striped table-bordered table-condensed table-white">
	
		<!-- Table heading -->
		<thead>
			<tr>
				<th><?=_t( 'Role' );?></th>
				<th><?=_t( 'Member' );?></th>
				<th><?=_t( 'Not Member' );?></th>
			</tr>
		</thead>
		<!-- // Table heading END -->
	
		<!-- Table body -->
		<tbody>
			<?php 
			$roleACL = new ACL(_h((int)$this->role[0]['userID']));
				$role = $roleACL->getAllRoles('full');
				foreach ($role as $k => $v) {
					echo '<tr><td>'._h($v['Name']).'</td>';
					
					echo "<td class=\"center\"><input type=\"radio\" name=\"role_" . _h($v['ID']) . "\" id=\"role_" . _h($v['ID']) . "_1\" value=\"1\"";
					if ($roleACL->userHasRole(_h($v['ID']))) { echo " checked=\"checked\""; }
					echo " /></td>";
					 
					echo "<td class=\"center\"><input type=\"radio\" name=\"role_" . _h($v['ID']) . "\" id=\"role_" . _h($v['ID']) . "_0\" value=\"0\"";
					if (!$roleACL->userHasRole(_h($v['ID']))) { echo " checked=\"checked\""; }
					echo " /></td></tr>";
				}
			?>
		</tbody>
		<!-- // Table body END -->

	</table>
	<!-- // Table END -->
	<input type="hidden" name="action" value="saveRoles" />
	<input type="hidden" name="userID" value="<?=_h($this->role[0]['userID']);?>" />
	<button type="submit" name="Submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i><?=_t( 'Save' );?></button>
</form>