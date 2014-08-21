<?php
/**
 *
 * Site Root
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

defined( 'DS' )					or define( 'DS', DIRECTORY_SEPARATOR );
defined( 'BASE_PATH' )			or define( 'BASE_PATH', __DIR__ . DS );
defined( 'APP_FOLDER' )			or define( 'APP_FOLDER', 'Application' );
defined( 'SYS_PATH' )			or define( 'SYS_PATH', BASE_PATH . 'tinyPHP' . DS );
defined( 'APP_PATH' )			or define( 'APP_PATH', SYS_PATH . APP_FOLDER . DS );
defined( 'LOCALE_DIR' ) 		or define( 'LOCALE_DIR', SYS_PATH . 'Locale' );
defined( 'DEFAULT_LOCALE' )		or define( 'DEFAULT_LOCALE', '');
defined( 'ENCODING' )			or define( 'ENCODING', 'UTF-8');
defined( 'CURRENT_VERSION' )	or define( 'CURRENT_VERSION', '1.0.0');
require( SYS_PATH . 'application.php');
$cookieDomain = new \tinyPHP\Classes\Libraries\Cookies;
defined( 'COOKIE_EXPIRE' )      or define( 'COOKIE_EXPIRE', time()+\tinyPHP\Classes\Libraries\Hooks::get_option('cookieexpire') );
defined( 'COOKIE_PATH' )        or define( 'COOKIE_PATH', \tinyPHP\Classes\Libraries\Hooks::get_option('cookiepath') );
defined( 'COOKIE_DOMAIN' )      or define( 'COOKIE_DOMAIN', $cookieDomain->cookieDomain() );
defined( 'DEFAULT_LOCALE' )     or define( 'DEFAULT_LOCALE', Hooks::get_option('core_locale') );

$app = new \tinyPHP\Classes\Core\Bootstrap();