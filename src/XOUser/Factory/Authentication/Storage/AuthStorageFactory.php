<?php
namespace XOUser\Factory\Authentication\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Authentication\Storage\AuthStorage;

class AuthStorageFactory implements FactoryInterface 
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	
        $storage = new AuthStorage('xo_user_sess');
        $storage->setServiceManager($serviceLocator);
        $storage->preparedSessionManager();
        return $storage;		
	}
}