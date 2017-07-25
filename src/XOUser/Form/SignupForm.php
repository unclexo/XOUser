<?php
namespace XOUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SignupForm extends Form
{
	/**
	 * Constructor
	 */	
	public function __construct($name = null)
	{
		parent::__construct('xo-signup');
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
			'name' => 'email',
			'type' => 'Text',
			'options' => array(
				'label' => 'Email',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'email',
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

		$this->add(array(
			'name' => 'repeat_password',
			'type' => 'Password',
			'options' => array(
				'label' => 'Confirm Password',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'repeat_password',
			),			
		));

		$this->add(new Element\Csrf('csrf'));

		$this->add(array(
            'name' => 'signup',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Sign up',
                'class' => 'btn btn-primary'
			),
		));
	}
}


