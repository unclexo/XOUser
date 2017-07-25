<?php
namespace XOUser\Factory\Session;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;

class SaveHandlerFactory implements FactoryInterface 
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
        $adapter = $serviceLocator->get('XODbAdapter');
        $tableGateway = new TableGateway('session', $adapter);
        $saveHandler  = new DbTableGateway($tableGateway, new DbTableGatewayOptions());
		return $saveHandler;
	}
}