<?php 
namespace XOUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Form\SignupForm;

class SignupFormFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$filter = $serviceLocator->get("XOSignupFormFilter");
		$form = new SignupForm();
		$form->setInputFilter($filter);
		return $form;
	}
}