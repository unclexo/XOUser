<?php 
namespace XOUser\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Mapper\UserMapper;

class UserMapperFactory implements FactoryInterface
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
		$userMapper = new UserMapper();
		$userMapper->setAdapter($adapter);
		$userMapper->setTable('users');
		return $userMapper;
	}
}