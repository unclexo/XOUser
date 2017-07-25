<?php 
namespace XOUser\Factory\Filter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Filter\LoginFormFilter;

class LoginFormFilterFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */		
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new LoginFormFilter();
	}
}