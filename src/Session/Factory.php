<?php

namespace PhpPlatform\Session;

use PhpPlatform\Config\Settings;
use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;

class Factory {
	private static $session = null;
	
	/**
	 * This method returns Session singleton object
	 * @throws ProgrammingError
	 * @return Session
	 */
	static function getSession(){
		if(self::$session == null){
			$sessionImplClassName = Settings::getSettings('php-platform/session',"session.class");
			try{
				$sessionImplReflectionClass = new \ReflectionClass($sessionImplClassName);
			}catch (\ReflectionException $re){
				throw new ProgrammingError("session implementation class is not configured or invalid");
			}
			$sessionInterfaceName = 'PhpPlatform\Session\Session';
			if(!$sessionImplReflectionClass->implementsInterface($sessionInterfaceName)){
				throw new ProgrammingError("$sessionImplClassName does not implement $sessionInterfaceName");
			}
			
			$sessionGetInstanceReflectionMethod = $sessionImplReflectionClass->getMethod('getInstance');
			
			self::$session = $sessionGetInstanceReflectionMethod->invokeArgs(null,array());
		}
		return self::$session;
	}
}