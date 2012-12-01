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

<h1><?php echo _t( 'User' ); ?></h1>

<form method="post" action="<?php echo BASE_URL;?>user/create">
	<label><?php echo _t( 'Login' ); ?></label><input type="text" name="login" /><br />
	<label><?php echo _t( 'Password' ); ?></label><input type="text" name="password" /><br />
	<label><?php echo _t( 'Role' ); ?></label>
		<select name="role">
			<option value="default"><?php echo _t( 'Default' ); ?></option>
			<option value="admin"><?php echo _t( 'Admin' ); ?></option>
		</select><br />
	<label>&nbsp;</label><input type="submit" />
</form>

<hr />

<table>
<?php
	foreach($this->userList as $key => $value) {
		echo '<tr>';
		echo '<td>' . $value['id'] . '</td>';
		echo '<td>' . $value['login'] . '</td>';
		echo '<td>' . $value['role'] . '</td>';
		echo '<td>
				<a href="'.BASE_URL.'user/edit/'.$value['id'].'">' . _t( 'Edit' ) . '</a> 
				<a href="'.BASE_URL.'user/delete/'.$value['id'].'">' . _t( 'Delete' ) . '</a></td>';
		echo '</tr>';
	}
?>
</table>