<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Login View
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

<h1><?php echo _t( 'Login' ); ?></h1>

<form action="login/run" method="post">
	
	<label><?php echo _t( 'Login' ); ?></label><input type="text" name="login" /><br />
	<label><?php echo _t( 'Password' ); ?></label><input type="password" name="password" /><br />
	<label></label><input class="btn" type="submit" value="Submit &raquo;" />
</form>