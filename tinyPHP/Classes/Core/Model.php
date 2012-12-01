<?php namespace tinyPHP\Classes\Core;
/**
 *
 * Abstract Model
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

if ( ! defined('BASE_PATH')) exit('No direct script access allowed');

abstract class Model {
	abstract protected function conn();
	abstract protected function is_error();
	abstract protected function disconnect();
	abstract protected function query($sql);
	abstract protected function select($table, $fields = '*', $where = null, $order = null);
	abstract protected function insert($table,$values,$fields = null);
	abstract protected function update($table,$fields,$where);
	abstract protected function delete($table,$where = null);
	abstract protected function get_results($sql);
	abstract protected function get_row($sql);
	abstract protected function escape($data);
	abstract protected function queryCache($sql = '', $expire = 0, $cachename = '');
	abstract protected function _get_db();
	abstract protected function _get_cache();
	abstract protected function _save_cache($data);
	abstract protected function delete_cache($filename, $wildcard = false);
	abstract protected function __clone();
	abstract protected function __destruct();
}