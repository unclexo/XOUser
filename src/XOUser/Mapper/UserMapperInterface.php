<?php
namespace XOUser\Mapper;

interface UserMapperInterface 
{
	/**
	 * Get user by ID
	 *
	 * @param int $id
	 * @return UserInterface
	 */
	public function getById($id);

	/**
	 * Get user by email
	 *
	 * @param string $email
	 * @return UserInterface
	 */
	public function getByEmail($email);

	/**
	 * Get user by username
	 *
	 * @param string $username
	 * @return UserInterface
	 */
	public function getByUsername($username);		

	/**
	 * Get an user
	 *
	 * @param Where|\Closure|string|array $where
	 * @return UserInterface
	 */
	public function getUser($where);

	/**
	 * Get all users
	 *
	 * @return UserInterface
	 */
	public function getAll();

	/**
	 * Insert data
	 *
	 * @param array $data
	 * @return ResultInterface
	 */
	public function insert($data);	

	/**
	 * Update data
	 *
	 * @param array $data
	 * @param Where|string|array|\Closure $where
	 * @return ResultInterface
	 */
	public function update($data, $where);

	/**
	 * Delete
	 *
	 * @param Where|\Closure|string|array $where
	 * @param ResultInterface
	 */
	public function delete($where);			
}

