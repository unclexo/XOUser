<?php 
namespace XOUser\Authentication\Storage;

use Zend\Session\Container as SessionContainer;
use Zend\Authentication\Storage\StorageInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Json\Json;

class AuthStorage implements StorageInterface
{
    /**
     * Session namespace
     *
     * @var string
     */
    protected $namespace = null;    
    /**
     * Container for the session storage
     *
     * Object to proxy $_SESSION storage
     *
     * @var Container
     */
    protected $container = null;

	/**
	 * @var ServiceManager
	 */
	protected $serviceManager = null;

	/**
	 * @var mixed
	 */
	protected $resolvedIdentity = null;

    /**
     * Constructor
     *
     * Initialize session namespace object
     *
     * @param  string $namespace
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    	$this->container = new SessionContainer($this->namespace);       
    }

    /**
     * Prepare session manager with options
     *
     * @return AuthStorage
     */
    public function preparedSessionManager()
    {
        $sessionConfig = $this->getServiceManager()->get('XOSessionConfig');
        if ('PHPSESSID' === $sessionConfig->getOption('name')) {
            $namespace = $this->getNamespace();
        } else {
            $namespace = $sessionConfig->getOption('name');
        }
        $saveHandler = $this->getServiceManager()->get('XOSaveHandler');
        $saveHandler->open($sessionConfig->getOption('save_path'), $namespace);
        $sessionManager = $this->getSessionManager()
            ->setConfig($sessionConfig)
            ->setSaveHandler($saveHandler);
        SessionContainer::setDefaultManager($sessionManager);
        return $this;
    }

    /**
     * Returns true if and only if data is empty
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If it is impossible to determine whether data is empty
     * @return bool
     */
	public function isEmpty()
	{   
		$identityInDb = $this->getSessionManager()
            ->getSaveHandler()
            ->read($this->getSessionId());
        if (empty($identityInDb)) {
        	$this->clear();
            return true;
        }
        return false;
	}

    /**
     * Returns the contents from database
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If reading contents from database is impossible
     * @return mixed
     */
	public function read()
	{
        if (null !== $this->resolvedIdentity) {
            return $this->resolvedIdentity;
        }

		$identityInDb = $this->getSessionManager()
            ->getSaveHandler()
            ->read($this->getSessionId());
        if ($identityInDb) {
            // $this->resolvedIdentity = $identityInDb;
            $user = Json::decode($identityInDb);
            $this->resolvedIdentity = $user; 
        } else {
            $this->resolvedIdentity = null;
        }

        return $this->resolvedIdentity;
	}

    /**
     * Writes $contents to database
     *
     * @param  mixed $contents
     * @throws \Zend\Authentication\Exception\ExceptionInterface If writing $contents to database is impossible
     * @return void
     */
	public function write($contents)
	{
        $this->resolvedIdentity = null;

		$write = $this->getSessionManager()
            ->getSaveHandler()
            ->write($this->getSessionId(), Json::encode($contents));
    }

    /**
     * Clears contents from database
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If clearing contents from database is impossible
     * @return void
     */
	public function clear()
	{
		$destroy = $this->getSessionManager()
            ->getSaveHandler()
            ->destroy($this->getSessionId()); 
	}

    /**
     * Returns the session namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }    

    /**
     * Get session ID
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->getSessionManager()->getId();
    }

    /**
     * Get session manager
     *
     * @return string
     */
    public function getSessionManager()
    {
        return $this->container->getManager();
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