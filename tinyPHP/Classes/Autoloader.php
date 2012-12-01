<?php namespace tinyPHP\Classes;
/**
*	An SplClassLoader implementation for PHP 5.3.
*	
*	Example usage for loading classes from the Example/Src namespace:
*		$loader = new Autoloader('Example\Src','/path/to/Example')
*		$loader->register();
*
*	You can also load classes from outside the current namespace.
*		$loader->addPath('/path/to/external/library_one');
*		$loader->addPath('/path/to/external/library_two');
*
*	If no matches are found, the loader will search the PHP include path.
*
*	@author Matt Colf <mattcolf@mattcolf.com>
*/

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class Autoloader
{
	private $namespace;
	private $path;
	private $systemPath;
	private $userPath = array();
	private $extension = '.php';
	private $seperator = '\\';

	/**
	*	Create a new SplLoader that will load classes in the
	*	specified namespace.
	*
	*	@param string $ns The namespace to load from.
	*	@param string $path The base path to load from.
	*	@return void
	*/
	public function __construct($ns = null, $path = null)
	{
		$this->namespace = $ns;
		$this->path = $path;
		$this->systemPath = explode(PATH_SEPARATOR, get_include_path());
	}

	/**
	*	Set the namespace seperator used by classes in the namespace
	*	of this loader.
	*
	*	@param string $seperator The seperator character string.
	*	@return void
	*/
	public function setSeperator($seperator)
	{
		$this->seperator = $seperator;
	}

	/**
	*	Get the namespace seperator being used by this loader.
	*
	*	@return string 
	*/
	public function getSeperator()
	{
		return $this->seperator;
	}

	/**
	*	Set the file extension of the class files to load.
	*
	*	@param string $extension The file extension including dot.
	*	@return void
	*/
	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

	/**
	*	Gets the current file extension being used to load classes.
	*
	*	@return string
	*/
	public function getExtension()
	{
		return $this->extension;
	}

	/**
	*	Add additional search paths to use when loading classes
	*	from outside the current namespace.
	*
	*	@param string $path The search path to load from.
	*	@return void
	*/
	public function addPath($path)
	{
		$this->userPath[] = $path;
	}
		
	/**
	*	Register this loader onto the SPL autoloader stack.
	*
	*	@return void
	*/
	public function register()
	{
		spl_autoload_register(array($this,'load'));
	}

	/**
	*	Unregister this loader from the SPL autoloader stack.
	*
	*	@return void
	*/
	public function unregister()
	{
		spl_autoload_unregister(array($this,'load'));
	}

	/**
	*	Loads the requested class or interface.
	*
	*	@param string $class The name of the class to load.
	*	@return void
	*/
	public function load($class)
	{
		// namespace
		$ns = $this->namespace.$this->seperator;
		if ($this->namespace == null || $ns === substr($class,0,strlen($ns)))
		{
			$file = '';

			if (($lastsep = strripos($class, $this->seperator)) !== false)
			{
				$namespace = substr($class,0,$lastsep);
				$class = substr($class,$lastsep+1);
				$file = str_replace($this->seperator, DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
			}

			$file .= str_replace('_', DIRECTORY_SEPARATOR, $class).$this->extension;

			if ($this->path != null) $file = $this->path.DIRECTORY_SEPARATOR.$file;

			if (file_exists($file))
			{
				require($file);
				return;
			}
		}		

		// additional search paths
		foreach (array_merge($this->userPath,$this->systemPath) as $path)
		{
			$file = $path.DIRECTORY_SEPARATOR.$class.$this->extension;
			if (file_exists($file))
			{
				require($file);
				return;
			}
		}

		// no matches
		throw new \Exception("Unable to load $class.");
	}

}