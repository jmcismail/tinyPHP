<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Main User View
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
 * @since tinyPHP(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<h1><?=_t( 'User' );?></h1>

<form method="post" action="<?=BASE_URL;?>user/create">
	<label><?=_t( 'Login' );?></label><input type="text" name="login" required/><br />
	<label><?=_t( 'First Name' );?></label><input type="text" name="fname" required/><br />
	<label><?=_t( 'Last Name' );?></label><input type="text" name="lname" required/><br />
	<label><?=_t( 'Password' );?></label><input type="password" name="password" required/><br />
	<label>&nbsp;</label><input class="btn" type="submit" />
</form>

<hr />

<table class="table table-striped table-bordered table-condensed table-white">
	<thead>
		<tr>
			<th><?=_t( 'User ID' );?></th>
			<th><?=_t( 'Username' );?></th>
			<th><?=_t( 'Name' );?></th>
			<th><?=_t( 'Actions' );?></th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($this->userList as $key => $value) {
		echo '<tr>';
		echo '<td>' . $value['userID'] . '</td>';
		echo '<td>' . $value['login'] . '</td>';
		echo '<td>' . get_name($value['userID']) . '</td>';
		echo '<td>
				<a href="'.BASE_URL.'user/edit/'.$value['userID'].'">' . _t( 'Edit' ) . '</a> | 
				<a href="'.BASE_URL.'user/role/'.$value['userID'].'">' . _t( 'Role' ) . '</a> | 
				<a href="'.BASE_URL.'user/perm/'.$value['userID'].'">' . _t( 'Permission' ) . '</a> | 
				<a href="'.BASE_URL.'user/delete/'.$value['userID'].'">' . _t( 'Delete' ) . '</a></td>';
		echo '</tr>';
	}
?>
	</tbody>
</table>