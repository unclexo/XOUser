<?php
namespace XOUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceManager;
use XOUser\Service\UserServiceInterface;

class DemoController extends AbstractActionController
{
	/**
	 * @var AuthenticationService
	 */
	protected $authService;

	/**
	 * @var UserServiceInterface
	 */
	protected $userService;

	/**
	 * @var ServiceManager
	 */
	protected $serviceManager;

	/**
	 * Constructor
	 */
	public function __construct(UserServiceInterface $userService)
	{
		$this->userService = $userService;
	}

	public function indexAction()
	{
		if (!$this->getAuthService()->hasIdentity()) {
			return $this->redirect()->toRoute('auth');
		}

		$user = $this->getAuthService()->getIdentity();

		return new ViewModel(array(
			'user' => $user,
		));
	}	

	/**
	 * Set authentication service
	 *
	 * @param  AuthenticationService $authService
	 */
	public function setAuthService($authService)
	{
		$this->authService = $authService;
		return $this;
	}

	/**
	 * Get authentication service
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
	 * @param  ServiceManager $serviceManager
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