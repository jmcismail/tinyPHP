<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Manage Role View
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
$roles = new ACL();
?>

<h1><?=_t( 'Roles' );?></h1>

<!-- Table -->
<table class="table table-striped table-bordered table-condensed table-white">

	<!-- Table heading -->
	<thead>
		<tr>
			<th class="text-center"><?=_t( 'ID' );?></th>
			<th class="text-center"><?=_t( 'Name' );?></th>
			<th class="text-center"><?=_t( 'Action' );?></th>
		</tr>
	</thead>
	<!-- // Table heading END -->
	
	<!-- Table body -->
	<tbody>
	<?php 
		$listRoles = $roles->getAllRoles('full');
		if($listRoles != '') {
			foreach ($listRoles as $k => $v) {
				echo '<tr class="gradeX">'."\n";
				echo '<td>'._h($v['ID']).'</td>'."\n";
				echo '<td>'._h($v['Name']).'</td>'."\n";
				echo '<td class="text-center"><a href="'.BASE_URL.'role/view/?roleID='._h($v['ID']).'">'._t( 'Edit' ).'</a></td>';
				echo '</tr>';
			}
		}
		
		/*if (count($listRoles) < 1) {
		_e( "No roles yet.<br />" );
		}*/
	?>
		
	</tbody>
	<!-- // Table body END -->
	
</table>
<!-- // Table END -->
<button type="submit" name="NewRole" class="btn btn-icon btn-primary glyphicons circle_ok" onclick="window.location='<?=BASE_URL;?>role/add/'"><i></i><?=_t( 'New Role' );?></button>