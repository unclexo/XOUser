<?php
namespace XOUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use XOUser\Service\UserServiceInterface;

class ChangePasswordController extends AbstractActionController
{
	const ROUTE_LOGIN = 'auth';
	const ROUTE_CHANGE_PASSWORD = 'auth/change_password';
	const TEMPLATE_CHANGE_PASSWORD = 'xo-user/change-password/index';
	const AUTH_SERVICE = 'XOAuthService';
	const FORM_CHANGE_PASSWORD = 'XOChangePasswordForm';

    /**
     * @var UserServiceInterface
     */
	protected $userService;

    /**
     * @var FormInterface
     */
    protected $changePasswordForm;

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
		if (!$this->getAuthService()->hasIdentity()) {
			// redirect to intended route
			return $this->redirect()->toRoute(static::ROUTE_LOGIN);
		}

		$form = $this->getChangePasswordForm();
        return new ViewModel(array('form' => $form));
    }

	/**
	 * Process the signup form
	 */
    public function processAction()
    {
		if (!$this->getAuthService()->hasIdentity()) {
			// redirect to intended route
			return $this->redirect()->toRoute(static::ROUTE_LOGIN);
		}

    	$request = $this->getRequest();
    	$form = $this->getChangePasswordForm();

    	if (!$request->isPost()) {
    		return $this->redirect()->toRoute(static::ROUTE_CHANGE_PASSWORD);
    	}
    	$post = $request->getPost()->toArray();
    	$form->setData($post);
    	if (!$form->isValid()) {
    		$model = new ViewModel(array(
    			'form' => $form,
    		));
    		$model->setTemplate(static::TEMPLATE_CHANGE_PASSWORD);
    		return $model;
    	} else {
    		$data = $form->getData();
    		$update = $this->userService->changePassword($data);
    		if (!$update) {
	    		$model = new ViewModel(array(
	    			'error' => true,
	    			'form' => $form,
	    		));
	    		$model->setTemplate(static::TEMPLATE_CHANGE_PASSWORD);
	    		return $model;
    		} else {
	    		$model = new ViewModel(array(
	    			'success' => true,
	    			'form' => $form,
	    		));
	    		$model->setTemplate(static::TEMPLATE_CHANGE_PASSWORD);
	    		return $model;    			
    		}
    	}
    }  

	/**
	 * Set change-password form
	 *
	 * @var FormInterface
	 */
	public function setChangePasswordForm(FormInterface $changePasswordForm)
	{
		$this->changePasswordForm = $changePasswordForm;
		return $this;
	}

	/**
	 * Get change-password form
	 *
	 * @return FormInterface
	 */
	public function getChangePasswordForm() 
	{
		if (!$this->changePasswordForm instanceof FormInterface) {
			$this->changePasswordForm = $this->getServiceManager()->get(static::FORM_CHANGE_PASSWORD);
		}
		return $this->changePasswordForm;
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