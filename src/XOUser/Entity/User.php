<?php
namespace XOUser\Entity;

class User implements UserInterface
{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $username;

	/**
	 * @var string
	 */
	public $password;

	/**
	 * @var string
	 */
	public $createdAt;

	/**
	 * @var string
	 */
	public $modifiedAt;

	/**
	 * @param int $id
	 */
	public function setId($id) 
	{
		$this->id = $id;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) 
	{
		$this->email = $email;
	}

	/**
	 * @param string $username
	 */
	public function setUsername($username) 
	{
		$this->username = $username;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password) 
	{
		$this->password = $password;
	}	

	/**
	 * @param string $createdAt
	 */
	public function setCreatedAt($createdAt) 
	{
		$this->createdAt = $createdAt;
	}

	/**
	 * @param string $modifiedAt
	 */
	public function setModifiedAt($modifiedAt) 
	{
		$this->modifiedAt = $modifiedAt;
	}				

	/**
	 * {@inheritdoc}
	 */
	public function getId() 
	{
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEmail() 
	{
		return $this->email;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getUsername() 
	{
		return $this->username;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPassword() 
	{
		return $this->password;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCreatedAt() 
	{
		return $this->createdAt;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getModifiedAt() 
	{
		return $this->modifiedAt;
	}

	/**
	 * Cast entity to an array
	 */
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}