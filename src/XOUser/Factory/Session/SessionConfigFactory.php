<?php
namespace XOUser\Factory\Session;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\SessionConfig;

class SessionConfigFactory implements FactoryInterface 
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
        $config = $serviceLocator->get('Config');
        if (isset($config['session_config']) && !empty($config['session_config'])) {
            $sessionOptions = $config['session_config'];
        } else {
            $sessionOptions = array();
        }
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($sessionOptions);
		return $sessionConfig;
	}
}