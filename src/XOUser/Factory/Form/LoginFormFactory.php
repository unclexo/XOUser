<?php 
namespace XOUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Form\LoginForm;

class LoginFormFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	
		$filter = $serviceLocator->get('XOLoginFormFilter');
		$form = new LoginForm();
		$form->setInputFilter($filter);
		return $form;
	}
}