<?php 
namespace XOUser\Factory\Filter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Filter\SignupFormFilter;

class SignupFormFilterFactory implements FactoryInterface
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
		$filter = new SignupFormFilter($adapter);
		return $filter;
	}
}