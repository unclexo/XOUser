<?php 
namespace XOUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use XOUser\Form\ChangePasswordForm;

class ChangePasswordFormFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */	
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	
		$filter = $serviceLocator->get('XOChangePasswordFormFilter');
		$form = new ChangePasswordForm();
		$form->setInputFilter($filter);
		return $form;
	}
}