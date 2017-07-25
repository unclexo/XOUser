<?php 
namespace XOUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ChangePasswordForm extends Form
{
	/**
	 * Constructor
	 */
	public function __construct($name = null)
	{
		parent::__construct('xo-change-password');
		$this->setAttribute('method', 'post');
		$this->addFields();
	}

	/**
	 * Create input fields
	 */
	public function addFields()
	{
		$this->add(array(
			'name' => 'password',
			'type' => 'Password',
			'options' => array(
				'label' => 'Old Password',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'password',
			),
		));

		$this->add(array(
			'name' => 'new_password',
			'type' => 'Password',
			'options' => array(
				'label' => 'New Password',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'new_password',
			),
		));

		$this->add(array(
			'name' => 'repeat_new_password',
			'type' => 'Password',
			'options' => array(
				'label' => 'Repeat New Password',
				'label_attributes' => array(
					'class' => 'control-label'
				),
			),
            'attributes' => array(
                'class'  => 'repeat_new_password',
			),
		));

		$this->add(new Element\Csrf('csrf'));

		$this->add(array(
            'name' => 'change_password',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Change Password',
                'class' => 'btn btn-primary'
			),
		));
	}
}


