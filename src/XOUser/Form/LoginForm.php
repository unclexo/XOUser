<?php 
namespace XOUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class LoginForm extends Form
{
	/**
	 * Constructor
	 */	
	public function __construct($name = null)
	{
		parent::__construct('xo-login');
		$this->setAttribute('method', 'post');
		$this->addFields();
	}

	/**
	 * Create input fields
	 */
	public function addFields()
	{
		$this->add(array(
			'name' => 'username',
			'type' => 'Text',
			'options' => array(
				'label' => 'Username',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'username',
			),
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'Password',
			'options' => array(
				'label' => 'Password',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'password',
			),
		));

		$this->add(new Element\Csrf('csrf'));

		$this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Log in',
                'class' => 'btn btn-primary'
			),
		));
	}
}


