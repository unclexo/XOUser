<?php
namespace XOUser\Service;

interface UserServiceInterface 
{
	/**
	 * Gets user by ID
	 *
	 * @param int $id
	 * @return UserInterface
	 */
	public function getUserById($id);

	/**
	 * Gets user by username
	 *
	 * @param string $username
	 * @return UserInterface
	 */
	public function getUserByUsername($username);

	/**
	 * Gets user by email
	 *
	 * @param string $email
	 * @return UserInterface
	 */
	public function getUserByEmail($email);

	/**
	 * Gets all users
	 *
	 * @return UserInterface
	 */
	public function getAllUsers();

	/**
	 * Register a new user
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function register($data);	
}

