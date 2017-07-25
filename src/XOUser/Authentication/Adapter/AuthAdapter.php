<?php  
namespace XOUser\Authentication\Adapter;

use \ReflectionMethod;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManager;
use XOUser\Mapper\UserMapperInterface;

class AuthAdapter implements AdapterInterface
{

	/**
	 * @var string
	 */
	private $identity = null;

	/**
	 * @var string
	 */	
	private $credential = null;
	
	/**
	 * @var string
	 */
	private $identityType = null;

	/**
	 * @var UserMapperInterface
	 */
	protected $userMapper = null;

	/**
	 * @var ServiceManager
	 */
	protected $serviceManager = null;

	/**
	 * Check initial configurations
	 *
	 * @return void
	 */
	public function initialize()
	{	
		$type = array('email', 'username');

		if (null === $this->identity) {
			throw new \Exception("No identity provided for authetication!");
		}
		if (null === $this->credential) {
			throw new \Exception("No credential provided for authetication!");
		}
		if (null === $this->identityType) {
			throw new \Exception("No identity type provided for authetication!");
		}
		if (!in_array($this->identityType, $type)) {
			throw new \Exception("Invalid identity type provided for authetication!");
		}								
	}

	/**
	 * Perform a user authetication based on indentity and credential
	 *
	 * @return \Zend\Authentication\Result
	 */
	public function authenticate()
	{	
		// Check if everything is setup
		$this->initialize();
		
		// Prepare login details and user identity
		$loginDetails = array();
		if ('email' === $this->getIdentityType()) {
			$loginDetails['email'] = $this->getIdentity();
			$user = $this->getUserMapper()->getByEmail($this->getIdentity());
		} elseif ('username' === $this->getIdentityType()) {
			$loginDetails['username'] = $this->getIdentity();
			$user = $this->getUserMapper()->getByUsername($this->getIdentity());
		}
		$loginDetails['password'] = $this->getCredential();			
		// $identity = $user->getArrayCopy();

		if (empty($user)) {
			return new Result(Result::FAILURE, null, array('Invalid identity!'));
		}

		$bcrypt = new Bcrypt();
		if ($bcrypt->verify($this->getCredential(), $user->getPassword())) {
			// $hash = $bcrypt->create($this->getCredential());
			// $this->getUserMapper()->update(array('password' => $hash), array('id' => $user->getId()));

			return new Result(Result::SUCCESS, $user, array('Authentication successful!'));
		} else {
			return new Result(Result::FAILURE, null, array('Invalid credential!'));	
		}
	}

	/**
	 * Set user identiry
	 *
	 * @param string $identity
	 */
	public function setIdentity($identity)
	{
		$this->identity = $identity;
		return $this;
	}	

	/**
	 * Get user identiry
	 *
	 * @return string
	 */
	public function getIdentity()
	{
		return $this->identity;
	}	

	/**
	 * Set user credential
	 *
	 * @param string $credential
	 */
	public function setCredential($credential)
	{
		$this->credential = $credential;
		return $this;
	}

	/**
	 * Get user credential
	 *
	 * @return string
	 */
	public function getCredential()
	{
		return $this->credential;
	}

	/**
	 * Set user identity type
	 *
	 * @param string $identityType
	 */
	public function setIdentityType($identityType)
	{
		$this->identityType = $identityType;
		return $this;
	}	

	/**
	 * Get user identity type
	 *
	 * @return string
	 */
	public function getIdentityType()
	{
		return $this->identityType;
	}	

	/**
	 * Set UserMapper
	 *
	 * @param UserMapperInterface $userMapper
	 */
	public function setUserMapper(UserMapperInterface $userMapper)
	{
		$this->userMapper = $userMapper;
		return $this;
	}

	/**
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
}