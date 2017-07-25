<?php 

return array(
	'factories' => array(
		'xodemo' => 'XOUser\Factory\Controller\DemoControllerFactory',
		'xologin' => 'XOUser\Factory\Controller\LoginControllerFactory',
		'xosignup' => 'XOUser\Factory\Controller\SignupControllerFactory',
		'xochangepassword' => 'XOUser\Factory\Controller\ChangePasswordControllerFactory',
	),
);