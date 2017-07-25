<?php 
namespace XOUser\Factory\Db\Adapter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class DbAdapterFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	
		$config = $serviceLocator->get('config');
		return new Adapter($config['db']);
	}
}