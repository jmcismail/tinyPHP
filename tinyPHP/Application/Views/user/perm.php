<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Edit User Permission View
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
?>

<h1><?=get_name(_h($this->perms[0]['userID']));?> <?=_t( 'Permission: Edit' );?></h1>

<form class="form-horizontal margin-none" action="<?=BASE_URL;?>user/runUserPerm/" id="validateSubmitForm" method="post" autocomplete="off">
	<!-- Table -->
	<table class="dynamicTable tableTools table table-striped table-bordered table-condensed table-white">
	
		<!-- Table heading -->
		<thead>
			<tr>
				<th><?=_t( 'Permission' );?></th>
				<th class="text-center"><?=_t( 'Allow' );?></th>
			</tr>
		</thead>
		<!-- // Table heading END -->
	
		<!-- Table body -->
		<tbody>
			<?php userPerm(_h($this->perms[0]['userID'])); ?>
		</tbody>
		<!-- // Table body END -->

	</table>
	<!-- // Table END -->
	<input type="hidden" name="action" value="savePerms" />
	<input type="hidden" name="userID" value="<?=_h($this->perms[0]['userID']);?>" />
	<button type="submit" name="Submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i><?=_t( 'Save' );?></button>
</form>