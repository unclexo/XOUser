<?php
namespace XOUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use XOUser\Service\UserServiceInterface;

class SignupController extends AbstractActionController
{
	const ROUTE_SIGNUP = 'auth/signup';
	const ROUTE_SUCCESS = 'demo';
	const TEMPLATE_SIGNUP = 'xo-user/signup/index';
	const AUTH_SERVICE = 'XOAuthService';
	const FORM_SIGNUP = 'XOSignupForm';
	
    /**
     * @var UserServiceInterface
     */
	protected $userService;

    /**
     * @var FormInterface
     */
    protected $signupForm;

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

	/**
	 * Show the signup form
	 */
    public function indexAction()
    {
		if ($this->getAuthService()->hasIdentity()) {
			// redirect to intended route
			return $this->redirect()->toRoute(static::ROUTE_SUCCESS);
		}

		$form = $this->getSignupForm();
        return new ViewModel(array('form' => $form));
    }

	/**
	 * Process the signup form
	 */
    public function processAction()
    {
    	$request = $this->getRequest();
    	$form = $this->getSignupForm();

    	if (!$request->isPost()) {
    		return $this->redirect()->toRoute(static::ROUTE_SIGNUP);
    	}
    	$post = $request->getPost()->toArray();
    	$form->setData($post);
    	if (!$form->isValid()) {
    		$model = new ViewModel(array(
    			'form' => $form,
    		));
    		$model->setTemplate(static::TEMPLATE_SIGNUP);
    		return $model;
    	} else {
    		$data = $form->getData();
    		$insert = $this->userService->register($data);
    		if (!$insert) {
	    		$model = new ViewModel(array(
	    			'error' => true,
	    			'form' => $form,
	    		));
	    		$model->setTemplate(static::TEMPLATE_SIGNUP);
	    		return $model;
    		} else {
	    		$model = new ViewModel(array(
	    			'success' => true,
	    			'form' => $form,
	    		));
	    		$model->setTemplate(static::TEMPLATE_SIGNUP);
	    		return $model; 
    		}
    	}
    }

	/**
	 * Set signup form
	 *
	 * @var FormInterface
	 */
	public function setSignupForm(FormInterface $signupForm)
	{
		$this->signupForm = $signupForm;
		return $this;
	}

	/**
	 * Get signup form
	 *
	 * @return FormInterface
	 */
	public function getSignupForm() 
	{
		if (!$this->signupForm instanceof FormInterface) {
			$this->signupForm = $this->getServiceManager()->get(static::FORM_SIGNUP);
		}
		return $this->signupForm;
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