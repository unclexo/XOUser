<?php 

return array(
	'session_config' => array(
		'name' => 'tuesday25',
        'use_cookies' => true,
        'cookie_lifetime' => 0,
        'gc_maxlifetime' => 3600,
	),
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view'
		),
	),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        'controller'    => 'xologin',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/login[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'xologin',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'xologin',
                                'action' => 'logout',
                            ),
                        ),
                    ),                                        
                    'signup' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/signup[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'xosignup',
                                'action' => 'index',
                            ),
                        ),
                    ),                  
                    'change_password' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/change-password[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'xochangepassword',
                                'action' => 'index',
                            ),
                        ),                       
                    ),
                ),
            ),
            
            // Edit this route as it is used for testing
            // purpose only for the admin area 
            'demo' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/demo-admin-area',
                    'defaults' => array(
                        'controller' => 'xodemo',
                        'action'     => 'index',
                    ),
                ),
            ),             
        ),
    ),
);