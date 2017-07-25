<?php 
namespace XOUser\Factory\Filter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use XOUser\Filter\ChangePasswordFormFilter;

class ChangePasswordFormFilterFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */		
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new ChangePasswordFormFilter();
	}
}