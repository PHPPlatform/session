<?php
namespace PhpPlatform\Tests\Session;

use PhpPlatform\Session\Factory;
use PhpPlatform\Errors\Exceptions\Application\ProgrammingError;
use PhpPlatform\Mock\Config\MockSettings;
use PhpPlatform\Config\SettingsCache;

class TestFactory extends \PHPUnit_Framework_TestCase {
	
	protected function setUp(){
		SettingsCache::getInstance()->reset();
		parent::setUp();
	}
	
	function testFactory(){
		// invoke factory without configuration
		$isException = false;
		try{
			Factory::getSession();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('session implementation class is not configured or invalid', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		
		// invoke factory with wrong configuration
		MockSettings::setSettings('php-platform/session', 'session.class', 'NonExistingClass');
		$isException = false;
		try{
			Factory::getSession();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('session implementation class is not configured or invalid', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		// invoke factory with class without implementing Session Interface
		MockSettings::setSettings('php-platform/session', 'session.class', 'PhpPlatform\Tests\Session\SampleSessionWithoutInterface');
		$isException = false;
		try{
			Factory::getSession();
		}catch (ProgrammingError $e){
			$isException = true;
			parent::assertEquals('PhpPlatform\Tests\Session\SampleSessionWithoutInterface does not implement PhpPlatform\Session\Session', $e->getMessage());
		}
		parent::assertTrue($isException);
		
		// invoke with proper configuration
		MockSettings::setSettings('php-platform/session', 'session.class', 'PhpPlatform\Tests\Session\SampleSessionImpl');
		$session = Factory::getSession();
		parent::assertEquals('PhpPlatform\Tests\Session\SampleSessionImpl', get_class($session));
		
		
	}
	
}