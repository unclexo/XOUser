<?php
namespace XOUser\Factory\Authentication;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;

class AuthenticationServiceFactory implements FactoryInterface 
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$storage = $serviceLocator->get('XOAuthStorage');
		$adapter = $serviceLocator->get('XOAuthAdapter');
		return new AuthenticationService($storage, $adapter);
	}
}