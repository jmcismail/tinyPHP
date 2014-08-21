<?php if ( ! defined('BASE_PATH')) exit('No direct script access allowed');
/**
 *
 * Actions Helper
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

    use \tinyPHP\Classes\Libraries\Hooks;
    
    /**
    * Includes and loads all activated plugins.
    *
    * @since 1.0.0
    */
    Hooks::load_activated_plugins();
    
    /**
    * An action called to add the plugin's link
    * to the menu structure.
    *
    * @since 1.0.0
    * @uses do_action() Calls 'admin_menu' hook.
    */
    Hooks::do_action('admin_menu');

    function init() {
        Hooks::do_action('init');
    }
    
    function head() {
        Hooks::do_action('head');
    }
    
    function footer() {
        Hooks::do_action('footer');
    }
    
    function version() {
        Hooks::do_action('version');
    }
    
    Hooks::add_action( 'head',                      'head_version_meta',            5       );
    Hooks::add_action( 'version',                   'foot_version',                 5       );