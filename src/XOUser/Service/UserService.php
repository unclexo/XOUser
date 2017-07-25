<?php 
namespace XOUser\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use XOUser\Mapper\UserMapperInterface;

class UserService implements UserServiceInterface
{
	/**
	 * @var UserMapperInterface
	 */
	protected $userMapper = null;

	/**
	 * @var AuthenticationService
	 */
	protected $authService = null;

	/**
	 * @var ServiceManager
	 */
	protected $serviceManager = null;

	/**
	 * Get user by ID
	 *
	 * @param int $id
	 * @return UserInterface
	 */
	public function getUserById($id) 
	{
		return $this->getUserMapper()->getById($id);
	}

	/**
	 * Get user by username
	 *
	 * @param string $username
	 * @return UserInterface
	 */
	public function getUserByUsername($username)
	{
		return $this->getUserMapper()->getByUsername($username);
	}


	/**
	 * Get user by email
	 *
	 * @param string $email
	 * @return UserInterface
	 */
	public function getUserByEmail($email)
	{
		return $this->getUserMapper()->getByEmail($email);
	}


	/**
	 * Get all users
	 *
	 * @return UserInterface
	 */
	public function getAllUsers()
	{
		return $this->getUserMapper()->getAll();
	}

	/**
	 * Register a new user
	 *
	 * @param array $data
	 * @return mixed|null
	 */
	public function register($data)
	{
		if (!is_array($data)) {
			throw new \Exception('Type of "$data" must be an array: "' . gettype($data) . '" provided!');
		}
		// Columns in the database table		
		$keys = array('username', 'email', 'password');
		$filteredArray = $this->filteredArray($keys, $data);
		
		$bcrypt = new Bcrypt;
		$password = $bcrypt->create($filteredArray['password']);
		$filteredArray['password'] = $password;

		try {
			return $this->getUserMapper()->insert($filteredArray);
		} catch (\Exception $e) {
			// @todo Show human-readable message
			return false;
		}
	}	

	/**
	 * Change user's password
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function changePassword($data)
	{
		if (!is_array($data)) {
			throw new \Exception('Type of "$data" must be an array: "' . gettype($data) . '" provided!');
		}		
		$keys = array('password', 'new_password');
		$filteredArray = $this->filteredArray($keys, $data);
	
		if (!$this->getAuthService()->hasIdentity()) {
			return false;
		}

		if ($filteredArray['password'] === $filteredArray['new_password']) {
			return false;
		}

		$currentUser = $this->getAuthService()->getIdentity();
		$id = $currentUser->id;
		$user = $this->getUserMapper()->getById($id);		

		if (empty($user)) {
			return false;
		}

		$bcrypt = new Bcrypt;
		if (!$bcrypt->verify($filteredArray['password'], $user->getPassword())) {
			return false;
		}

		$newPassword = $bcrypt->create($filteredArray['new_password']);
		$filteredArray['password'] = $newPassword;

		unset($filteredArray['new_password']);

		try {
			return $this->getUserMapper()->update($filteredArray, array('id' => (int) $id));
		} catch (\Exception $e) {
			// @todo Show human-readable message
			return false;
		}
	}	

	/**
	 * Change email
	 *
	 * @param array $data
	 * @return boolean
	 */
	public function changeEmail($data)
	{
		if (!is_array($data)) {
			throw new \Exception('Type of "$data" must be an array: "' . gettype($data) . '" provided!');
		}	
		$keys = array('email', 'password');
		$filteredArray = $this->filteredArray($keys, $data);

		if (!$this->getAuthService()->hasIdentity()) {
			return false;
		}

		$currentUser = $this->getAuthService()->getIdentity();
		$id = $currentUser->id;
		$user = $this->getUserMapper()->getById($id);		

		if (empty($user)) {
			return false;
		}

		if ($filteredArray['email'] === $user->getEmail()) {
			return false;
		}		

		$bcrypt = new Bcrypt;
		if (!$bcrypt->verify($filteredArray['password'], $user->getPassword())) {
			return false;
		}

		unset($filteredArray['password']);

		try {
			return $this->getUserMapper()->update($filteredArray, array('id' => (int) $id));
		} catch (\Exception $e) {
			// @todo Show human-readable message
			return false;
		}
	}

	/**
	 * Delete an user 
	 *
	 * @param Where|string|array|\Closure $where
	 * @return boolean
	 */
	public function deleteUser($where)
	{
		if (!$this->getAuthService()->hasIdentity()) {
			return false;
		}

		try {
			return $this->getUserMapper()->delete($where);
		} catch (\Exception $e) {
			// @todo Show human-readable message
			return false;
		}
	}

	/**
	 * Set user mapper
	 *
	 * @param UserMapperInterface $userMapper
	 */
	public function setUserMapper(UserMapperInterface $userMapper)
	{
		$this->userMapper = $userMapper;
		return $this;
	}

	/**
	 * Get user mapper
	 *	
	 * @return UserMapperInterface
	 */
	public function getUserMapper()
	{
		if (null === $this->userMapper) {
			$this->userMapper = $this->getServiceManager()->get('XOUserMapper');
		}
		return $this->userMapper;
	}

	/**
	 * Set auth service
	 *
	 * @param AuthenticationService
	 */
	public function setAuthService(AuthenticationService $authService)
	{
		$this->authService = $authService;
		return $this;
	}

	/**
	 * Get auth service
	 *
	 * @return AuthenticationService
	 */
	public function getAuthService()
	{
		if (null === $this->authService) {
			$this->authService = $this->getServiceManager()->get('XOAuthService');
		}
		return $this->authService;		
	}

	/**
	 * Set service manager
	 *
	 * @param ServiceManager $serviceManager
	 */
	public function setServiceManager(ServiceManager $serviceManager) 
	{
		$this->serviceManager = $serviceManager;
		return $this;
	}

	/**
	 * Get service manager
	 *
	 * @return ServiceManager
	 */
	public function getServiceManager()
	{
		return $this->serviceManager;
	}

	/**
	 * Make filtered array
	 *
	 * @param array $keys A non-associative array containing keys
	 * @param array $data An array to iterate over
	 * @return array
	 */
	protected function filteredArray($keys, $data) 
	{
		$filtered = array();
		foreach ($keys as $key) {
			if (in_array($key, array_keys($data))) {
				$filtered[$key] = $data[$key];
			} else {
				throw new \Exception("A required key \"{$key}\" does not exist in the given array!");
			}
		}
		return $filtered;
	}		
}