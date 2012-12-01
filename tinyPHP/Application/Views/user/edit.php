<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * User Edit View
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

<h1><?php echo _t( 'User: Edit' ); ?></h1>

<?php foreach($this->user as $key => $value) { ?>
<form method="post" action="<?php echo BASE_URL;?>user/editSave/<?php echo $value['id']; ?>">
	<label><?php echo _t( 'Login' ); ?></label><input type="text" name="login" value="<?php echo $value['login']; ?>" /><br />
	<label><?php echo _t( 'Password' ); ?></label><input type="text" name="password" /><br />
	<label><?php echo _t( 'Role' ); ?></label>
		<select name="role">
			<option value="default" <?php if($value['role'] == 'default') echo 'selected'; ?>><?php echo _t( 'Default' ); ?></option>
			<option value="admin" <?php if($value['role'] == 'admin') echo 'selected'; ?>><?php echo _t( 'Admin' ); ?></option>
			<option value="owner" <?php if($value['role'] == 'owner') echo 'selected'; ?>><?php echo _t( 'Owner' ); ?></option>
		</select><br />
	<label>&nbsp;</label><input type="submit" />
</form>
<?php } ?>