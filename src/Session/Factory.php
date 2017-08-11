<?php

namespace PhpPlatform\Session;

use PhpPlatform\Config\Settings;
use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;

class Factory {
	private static $sessionGetInstanceReflectionMethod = null;
	
	/**
	 * This method returns Session singleton object
	 * @throws ProgrammingError
	 * @return Session
	 */
	static function getSession(){
		if(self::$sessionGetInstanceReflectionMethod == null){
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
			
			self::$sessionGetInstanceReflectionMethod = $sessionImplReflectionClass->getMethod('getInstance');
		}
		
		return self::$sessionGetInstanceReflectionMethod->invoke(null);
	}
}