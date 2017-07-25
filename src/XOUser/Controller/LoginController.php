<?php
namespace XOUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use Zend\ServiceManager\ServiceManager;
use XOUser\Service\UserServiceInterface;

class LoginController extends AbstractActionController
{
	const ROUTE_LOGIN = 'auth';
	const ROUTE_SUCCESS = 'demo';
	const TEMPLATE_LOGIN = 'xo-user/login/index';
	const AUTH_SERVICE = 'XOAuthService';
	const FORM_LOGIN = 'XOLoginForm';

    /**
     * @var UserServiceInterface
     */
	protected $userService;

    /**
     * @var FormInterface
     */
    protected $loginForm;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

	/**
	 * Constructor
	 *
	 * @param UserServiceInterface $userService
	 * @return void
	 */
	public function __construct(UserServiceInterface $userService)
	{
		$this->userService = $userService;		
	}	

	public function indexAction()
	{
		if ($this->getAuthService()->hasIdentity()) {
			// redirect to intended route
			return $this->redirect()->toRoute(static::ROUTE_SUCCESS);
		}

		$form = $this->getLoginForm();
        return new ViewModel(array('form' => $form));
	}

	public function processAction()
	{
    	$request = $this->getRequest();
    	$form = $this->getLoginForm();

    	if (!$request->isPost()) {
    		return $this->redirect()->toRoute(static::ROUTE_LOGIN);
    	}

    	$post = $request->getPost()->toArray();
    	$form->setData($post);
    	if (!$form->isValid()) {
    		$model = new ViewModel(array(
    			'form' => $form,
    		));
    		$model->setTemplate(static::TEMPLATE_LOGIN);
    		return $model;
    	} else {
			$data = $form->getData();
			$auth = $this->getAuthService()
				->getAdapter()
				->setIdentity($data['username'])
				->setCredential($data['password'])
				->setIdentityType('username'); // Can only be 'username' or 'email'

			$result = $this->getAuthService()->authenticate();
            if ($result->isValid()) {
                return $this->redirect()->toRoute(static::ROUTE_SUCCESS);
            } else {
	    		$model = new ViewModel(array(
	    			'error' => true,
	    			'form' => $form,
	    		));
	    		$model->setTemplate(static::TEMPLATE_LOGIN);
	    		return $model;
            }  
    	}
	}

	/**
	 * Logout
	 */
    public function logoutAction()
    {
        $this->getAuthService()->getStorage()->clear();
        return $this->redirect()->toRoute(static::ROUTE_LOGIN);
    }

	/**
	 * Set login form
	 *
	 * @var FormInterface
	 */
	public function setLoginForm(FormInterface $loginForm)
	{
		$this->loginForm = $loginForm;
		return $this;
	}

	/**
	 * Get login form
	 *
	 * @return FormInterface
	 */
	public function getLoginForm() 
	{
		if (!$this->loginForm instanceof FormInterface) {
			$this->loginForm = $this->getServiceManager()->get(static::FORM_LOGIN);
		}
		return $this->loginForm;
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
			$this->authService = $this->getServiceManager()->get(static::AUTH_SERVICE);
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