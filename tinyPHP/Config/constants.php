<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
/**
 *
 * Constants
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

/* Set this to false in a production environment */
defined( 'DEVELOPMENT_ENVIRONMENT' )	or define( 'DEVELOPMENT_ENVIRONMENT', TRUE );

defined( 'DB_HOST' )					or define('DB_HOST', 'localhost');
defined( 'DB_NAME' )					or define('DB_NAME', '');
defined( 'DB_USER' )					or define('DB_USER', '');
defined( 'DB_PASS' )					or define('DB_PASS', '');
defined( 'TP' )							or define('TP' , 'tp_'); // defines the table prefix

/* Always provide a TRAILING SLASH (/) AFTER A PATH */
defined( 'BASE_URL' )					or define( 'BASE_URL', '' );
defined( 'SITE_TITLE' )					or define( 'SITE_TITLE', 'User System' );
defined( 'ADMIN_SLUG' )					or define( 'ADMIN_SLUG', '');
defined( 'LOGIN_SLUG' )					or define( 'LOGIN_SLUG', '');