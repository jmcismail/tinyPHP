<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Site Header
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
<!doctype html>
<html>
<head>
	<title><?php echo SITE_TITLE; ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/default.css" />
</head>
<body>

<?php tinyPHP\Classes\Core\Session::init(); ?>
	
<div id="header">

	<?php if (tinyPHP\Classes\Core\Session::get('loggedIn') == false):?>
		<a href="<?php echo BASE_URL; ?>index"><?php echo _t( 'Home' ); ?></a>
		<a href="<?php echo BASE_URL; ?>help"><?php echo _t( 'Help' ); ?></a>
	<?php endif; ?>	
	<?php if (tinyPHP\Classes\Core\Session::get('loggedIn') == true):?>
		<a href="<?php echo BASE_URL; ?>dashboard"><?php echo _t( 'Dashboard' ); ?></a>
		
		<?php if (tinyPHP\Classes\Core\Session::get('role') == 'owner'):?>
		<a href="<?php echo BASE_URL; ?>user"><?php echo _t( 'Users' ); ?></a>
		<?php endif; ?>
		
		<a href="<?php echo BASE_URL; ?>dashboard/logout"><?php echo _t( 'Logout' ); ?></a>	
	<?php else: ?>
		<a href="<?php echo BASE_URL; ?>login"><?php echo _t( 'Login' ); ?></a>
	<?php endif; ?>
</div>
	
<div id="content">
	
	