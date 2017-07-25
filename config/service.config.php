<?php
return array(
	'factories' => array(
		// Form services
		'XOLoginForm' => 'XOUser\Factory\Form\LoginFormFactory',
		'XOSignupForm' => 'XOUser\Factory\Form\SignupFormFactory',
		'XOChangePasswordForm' => 'XOUser\Factory\Form\ChangePasswordFormFactory',
		
		// Filter services
		'XOLoginFormFilter' => 'XOUser\Factory\Filter\LoginFormFilterFactory',
		'XOSignupFormFilter' => 'XOUser\Factory\Filter\SignupFormFilterFactory',
		'XOChangePasswordFormFilter' => 'XOUser\Factory\Filter\ChangePasswordFormFilterFactory',

		// Mapper services
		'XOUserService' => 'XOUser\Factory\Service\UserServiceFactory',
		'XOUserMapper' => 'XOUser\Factory\Mapper\UserMapperFactory',

		// Session services
		'XOSessionConfig' => 'XOUser\Factory\Session\SessionConfigFactory',
		'XOSaveHandler' => 'XOUser\Factory\Session\SaveHandlerFactory',
		
		// DB Adapter service
		'XODbAdapter' => 'XOUser\Factory\Db\Adapter\DbAdapterFactory',

		// Authentication services	
		'XOAuthAdapter' => 'XOUser\Factory\Authentication\Adapter\AuthAdapterFactory',
		'XOAuthStorage' => 'XOUser\Factory\Authentication\Storage\AuthStorageFactory',
		'XOAuthService' => 'XOUser\Factory\Authentication\AuthenticationServiceFactory',
	),
);