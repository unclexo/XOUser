<?php 
namespace XOUser\Entity;

interface UserInterface
{
	/**
	 * Set user ID
	 *
	 * @param int $id
	 */
	public function setId($id);

	/**
	 * Set user email
	 *
	 * @param string $email
	 */
	public function setEmail($email);

	/**
	 * Set user name
	 *
	 * @param string $username
	 */
	public function setUsername($username);

	/**
	 * Set user password 
	 *
	 * @param string $password
	 */
	public function setPassword($password);

	/**
	 * Set created date
	 *
	 * @param string $createdAt
	 */
	public function setCreatedAt($createdAt);

	/**
	 * Set modified date
	 *
	 * @param string $modifiedAt
	 */
	public function setModifiedAt($modifiedAt);	

	/**
	 * Get user ID
	 *
	 * @return int
	 */
	public function getId();

	/**
	 * Get user email
	 *
	 * @return string
	 */
	public function getEmail();

	/**
	 * Get user name 
	 *
	 * @return string
	 */
	public function getUsername();

	/**
	 * Get user password 
	 *
	 * @return string
	 */
	public function getPassword();

	/**
	 * Get user creation date 
	 *
	 * @return string
	 */
	public function getCreatedAt();

	/**
	 * Get user modification date
	 *
	 * @return string
	 */
	public function getModifiedAt();					

}
