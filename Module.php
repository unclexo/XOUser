<?php 
namespace XOUser;

class Module
{
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getControllerConfig()
	{
		return include __DIR__ . '/config/controller.config.php';
	}

	public function getServiceConfig()
	{
		return include __DIR__ . '/config/service.config.php';
	}

	public function getAutoloaderConfig() 
	{
		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				],
			],
		];
	}
}