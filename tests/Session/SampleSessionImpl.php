<?php
namespace PhpPlatform\Tests\Session;

use PhpPlatform\Session\Session;

class SampleSessionImpl implements Session{
	
	private static $instance = null;
	
	private function __construct(){
		
	}
	
	/**
	 * This method is to object the session from Singleton Session class
	 *
	 * @return Session , singleton Session object
	 */
	static function getInstance(){
		if(self::$instance == null){
			self::$instance = new SampleSessionImpl();
		}
		return self::$instance;
	}
	
	/**
	 * This method eturns the session id
	 * @return string , session id
	 */
	function getId(){}
	
	/**
	 * Returns the session value stored for this key , null if no value is available for the provided key
	 * @param $key string in JSON format representing a unque path to a value
	 *
	 * @return string|array the value availabe in the provided key
	 */
	function get($key){}
	
	/**
	 * Sets the value to the given key in the session
	 * @param string $key
	 * @param string|array $value
	 */
	function set($key,$value){}
	
	/**
	 * Clears all the session data, but session is not deleted
	 * @return Session , the same session object
	 */
	function clear(){}
	
	/**
	 * Generates new session
	 * @param int $flag , bitwise OR flags for customizing the data between the old and new sessions
	 *      Session::RESET_COPY_OLD will copy old session data to new session
	 *      Session::RESET_DELETE_OLD will deletes the data from old session
	 *
	 * @return Session , new Session created by reset
	 */
	function reset($flag = 0){}

}