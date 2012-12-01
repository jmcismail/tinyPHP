<?php namespace tinyPHP\Classes\Core;
/**
 *
 * Database
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

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class MySQLiDriver extends \tinyPHP\Classes\Core\Model {
	protected $dir		= 'tmp/cache/';		// Location of cache files (relavtive to page calling class)
	protected $filename	= '';						// Current filename of the cached query (Defaults to queries md5 hash)
	protected $sql		= '';						// Current MySQL query
	protected $data		= '';						// Queried data from MySQL query
	
	private $connection;
 
    /**
     * Current result set
     *
     * @access private
     * @var object
     */
    private $result;
 
    /**
     * The last result (processed)
     *
     * @access private
     * @var array
     */
    private $last_result;
 
    /**
     * The number of rows from last result
     *
     * @access private
     * @var int
     */
    private $row_count;
 
    /**
     * Last error
     *
     * @access private
     * @var string
     */
    private $last_error;
 
    /**
     * Creates and references the db object.
     *
     * @access public
     * @return object MySQLi database object
     */
    public function conn() {
        $this->connection = new \mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		return true;
    }
 
    /**
     * Checks for errors.
     *
     * @return string|false $last_error if it exists or false if no errors.
     */
    public function is_error() {
        if ( isset($this->last_error) && !empty($this->last_error) )
            return $this->last_error;
        return false;
    }
 
    /**
     * Close active connection to MySQL database.
     *
     * @access public
     * @return bool Always returns true.
     */
    public function disconnect() {
        $this->connection->close();
        return true;
    }
 
    /**
     * Executes query and returns results.
     *
     * @access public
     * @param string $sql The SQL statement to execute.
     * @return mixed
     */
    public function query($sql) {
        $this->result = $this->connection->query($sql);
        return $this->result;
    }
	
	/**
     * Selects information from the database.
	 * 
     * @param table (the name of the table)
     * @param fields (the columns requested, separated by commas) optional
     * @param where (column = value as a string) optional
     * @param order (column DIRECTION as a string) optional
	 * @return mixed
     */
    public function select($table, $fields = '*', $where = null, $order = null) {
        $q = 'SELECT '.$fields.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;

        $query = $this->query($q);
		return $query;
    }
	
	/**
     * Insert values into the table
	 * 
	 * @access public
     * @param table (the name of the table)
     * @param values (the values to be inserted)
     * @param fields (if values don't match the number of fields) optional
	 * @return mixed
     */
    public function insert($table,$values,$fields = null) {
            $insert = 'INSERT INTO '.$table;
            if($fields != null) {
                $insert .= ' ('.$fields.')';
            }

            for($i = 0; $i < count($values); $i++) {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';

            $ins = $this->query($insert);

            if($ins) {
                return true;
            }
    }
	
	/**
     * Updates the database with the values sent
	 * 
	 * @access public
     * @param table (the name of the table to be updated
     * @param fields (the rows/values in a key/value array
     * @param where (the row/condition in an array (row,condition) )
	 * @return mixed
     */
	public function update($table,$fields,$where) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++) {
                if($i%2 != 0) {
                    if(is_string($where[$i])) {
                        if($where[($i+1)] != null)
                            $where[$i] = "='".$where[$i]."' AND ";
                        else
                            $where[$i] = "='".$where[$i]."'";
                    }
                }
            }
			$where = implode('',$where);

            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($fields);
            for($i = 0; $i < count($fields); $i++) {
                if(is_string($fields[$keys[$i]])) {
                    $update .= $keys[$i].'="'.$fields[$keys[$i]].'"';
                } else {
                    $update .= $keys[$i].'='.$fields[$keys[$i]];
                }

                // Parse to add commas
                if($i != count($fields)-1) {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = $this->query($update);
            if($query) {
                return true;
            } else {
                return false;
            }
    }

    /**
     * Deletes table or records where condition is true
	 * 
	 * @access public
     * @param table (the name of the table)
     * @param where (condition [column =  value]) optional
	 * @return mixed
     */
    public function delete($table,$where = null) {
            if($where == null) {
                $delete = 'DELETE '.$table;
            } else {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            $del = $this->query($delete);

            if($del) {
                return true;
            } else {
                return false;
            }
    }
 
    public function get_results($sql) {
        if ( !$this->query($sql) )
            return false;
 
        $num_rows = 0;
        while ( $row = $this->result->fetch_object() ) {
            $this->last_result[$num_rows] = $row;
            $num_rows++;
        }
 
        $this->result->close();
 
        return $this->last_result;
    }
 
    public function num_rows() {
        return (int) $this->row_count;
    }
 
    /**
     * Retrieve a single row from the database.
     *
     * Do not include LIMIT 1 on the end, as this will be taken care
     * of automatically.
     *
     * @param string $sql The SQL statement to execute.
     * @return object The MySQL row object
     */
    public function get_row($sql) {
        if ( !$results = $this->query($sql . " LIMIT 1") )
            return false;
 
        return $results->fetch_object();
    }
 
    /**
     * Sanitizes data for safe execution in SQL query.
     *
     * @access public
     * @param mixed $data The data to be escaped.
     * @return mixed
     */
    public function escape($data) {
        return $this->connection->real_escape_string($data);
    }
	
	/**
	 * Determines how to handle the query
	 * 
	 * @param	string	SQL query statement
	 * @param	mixed	Number of seconds or 'daily' for cache length
	 * @param	string	Filename for queries cache file
	 * @return  array
	 */
	public function queryCache($sql = '', $expire = 0, $cachename = '') {
		// Checks to see if query was given, don't need to go on if empty
		if (!$sql) {
			return false;
		}
		$this->sql  = $sql;
		$this->data = '';
		// Check if an expiration length was given, if empty data needs to be refreshed
		if ($expire == '0') {
			$this->data = $this->_get_db();
			return $this->data;
		} else {
			// Check if cachename is set == 0
			if (!strlen(trim($cachename))) {
				$cachename = md5($this->sql);
			}
			$this->filename = BASE_PATH . $this->dir . $cachename;
			// Check timestamp of cachefile
			$timestamp = file_exists($this->filename) ? filemtime($this->filename) : 0;
			// Check if the cache file is set to expire once a day
			if ($expire == 'daily') {
				// If timestamp doesn't match current day refresh data
				if (date('Y-m-d', $timestamp) != date('Y-m-d', time())) {
					$this->data = $this->_get_db();
					// Save the data to the cache file
					if (!$this->_save_cache($this->data)) {
						return false;
					}
					return $this->data;
				} else { // If we get here, the cache is still good
					$this->data = $this->_get_cache();
					return $this->data;
				}
			// Check cache's lifespan against timestamp
			} else {
				// Check if cache is older than cache's lifespan
				if ((time() - $timestamp) >= $expire) {
					$this->data = $this->_get_db();
					// Save the data to the cache file
					if (!$this->_save_cache($this->data)) {
						return false;
					}
					return $this->data;
				} else { // If we get here, the cache is still good
					$this->data = $this->_get_cache();
					return $this->data;
				}
			}
		}
	}

	/**
	 * Refreshes data if the cache is expired or cache is disabled
	 * 
	 * @return  array
	 */
	protected function _get_db() {
		// Perform the query
		if (!$query = $this->query($this->sql)) {
			return false;
		}
		while ($row = $query->fetch_array()) {
			$this->data[] = $row;
		}
		return $this->data;
	}
	
	/**
	 * Retrieves the query data from cache file
	 * 
	 * @return  array
	 */
	protected function _get_cache() {
		if (!$data = json_decode(file_get_contents($this->filename), true)) {
			return false;
		}
		return $data;
	}
	
	/**
	 * Takes the array generated from get_db() and saves it to a file in JSON form
	 * 
	 * @param	array Query data
	 * @return  bool
	 */
	protected function _save_cache($data) {
		if (!file_put_contents($this->filename, json_encode($data))) {
			return false;
		}
		return true;
	}
	
	/**
	 * Deletes cache file manually
	 * 
	 * @param	string Filename of cache file
	 * @param	bool   Decides if the given filename should be used as a wildcard
	 * @return  void
	 */
	public function delete_cache($filename, $wildcard = false) {
		$filename = BASE_PATH . $this->dir . $filename;
		// If wildcard is set, delete anything file with a prefix of $filename
		if ($wildcard) {
			foreach (glob($filename.'*') as $file) {
				unlink($file);
			}
		} else { // Just deletes file with filename
			if (file_exists($filename)) {
				unlink($filename);
			}
		}
	}
 
    /**
     * Prevent cloning of db.
     *
     * @access public
     * @return void
     */
    public function __clone() {
        // Issue E_USER_ERROR if clone is attempted
        trigger_error('Cloning <em>db</em> is prohibited.', E_USER_ERROR);
    }
 
    /**
     * Destructor
     *
     * @access public
     */
    public function __destruct() {}
}