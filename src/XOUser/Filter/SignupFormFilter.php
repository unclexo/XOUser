<?php
namespace XOUser\Filter;

use Zend\Db\Adapter\Adapter;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;

class SignupFormFilter extends InputFilter
{
	/**
	 * @var Adapter
	 */
	protected $adapter = null;

	/**
	 * Constructor
	 */
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->addFilters();
	}

	/**
	 * Create filters
	 */
	public function addFilters()
	{
		$this->add(array(
			'name' => 'username',
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
						'min' => 3,
						'max' => 100,
					),
					'break_chain_on_failure' => true,
				),
				array(
					'name' => 'Zend\Validator\Db\NoRecordExists',
					'options' => array(
						'table' => 'users',
						'field' => 'username',
						'adapter' => $this->adapter,
					),					
					'break_chain_on_failure' => true,
				),				
			),
		));

		$this->add(array(
			'name' => 'email',
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
						'max' => 100,
					),
					'break_chain_on_failure' => true,
				),
				array(
					'name' => 'Zend\Validator\Db\NoRecordExists',
					'options' => array(
						'table' => 'users',
						'field' => 'email',
						'adapter' => $this->adapter,
					),					
					'break_chain_on_failure' => true,
				),				
				array(
					'name' => 'EmailAddress',
					'options' => array(
						'messages' => array(
							EmailAddress::INVALID_FORMAT => 'Email address is not valid',
						),
					),
				),
			),
		));

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
						'min' => 8,
						'max' => 60,
					),
					'break_chain_on_failure' => true,
				),
			),
		));

		$this->add(array(
			'name' => 'repeat_password',
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
						'token' => 'password',
					),
					'break_chain_on_failure' => true,
				),
			),
		));		
	}
}