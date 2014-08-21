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

/* Begin choose database based on subdomain and type of installation. */
defined( 'DSN_PREFIX' )                 or define( 'DSN_PREFIX', 'mysql' );
defined( 'DB_HOST' )                    or define( 'DB_HOST', 'localhost' );
defined( 'DB_NAME' )                    or define( 'DB_NAME', 'tphp' );
defined( 'DB_USER' )                    or define( 'DB_USER', 'root' );
defined( 'DB_PASS' )                    or define( 'DB_PASS', 'root' );
defined( 'BASE_URL' )                   or define( 'BASE_URL', 'http://localhost:8888/tphp/' );
defined( 'SITE_TITLE' )                 or define( 'SITE_TITLE', 'tinyPHP Framework' );
defined( 'PLUGINS_DIR' )                or define( 'PLUGINS_DIR', APP_PATH . 'Plugins/' );