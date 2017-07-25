<?php
namespace XOUser\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;

class ChangePasswordFormFilter extends InputFilter
{
	/**
	 * Constructor
	 */	
	public function __construct()
	{
		$this->addFilters();
	}

	/**
	 * Create filters
	 */
	public function addFilters()
	{
		$this->add(array(
			'name' => 'password',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'break_chain_on_failure' => true,
				),
				array(
					'name' => 'StringLength',
					'options' => array(
						'min' => 5,
						'max' => 100,
					),
					'break_chain_on_failure' => true,
				),
			),
		));

		$this->add(array(
			'name' => 'new_password',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'break_chain_on_failure' => true,
				),
				array(
					'name' => 'StringLength',
					'options' => array(
						'min' => 8,
						'max' => 60,
					),
					'break_chain_on_failure' => true,
				),
			),
		));		

		$this->add(array(
			'name' => 'repeat_new_password',
			'required' => true,
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'break_chain_on_failure' => true,
				),
				array(
					'name' => 'Identical',
					'options' => array(
						'token' => 'new_password',
					),
					'break_chain_on_failure' => true,
				),
			),
		));		
	}
}