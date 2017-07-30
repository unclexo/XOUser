Introduction
------------

XOUser is a skeleton module for user authentication and registration for Zend Framework 2. This is for making a user module very fast by extending its available functionality. XOUser stores session data in database. This is mainly a combination of Zend\Db, Zend\Session and Zend\Authentication for managing users persistently.

Version
-------
Please use one of versions from below:

|Supported Zend Framework version |
|---------------------------------|
| >= 2.2.7 to <= 2.5.0

Features
--------

* User login - authenticate via username or email (by specifying one of these two and changing that in other places).
* User registration.
* User change-password.
* Forms protected against CSRF.

Installation
------------

### Using composer:

1. In your project, use the following command on your terminal.

```bash
$ composer require unclexo/xo-user
```

2. Add this `XOUser` module name in your `application.config.php` file.

```php
<?php
  return array(
    'modules' => array(
      // ...
      'XOUser',
    ),
    // ...
  );
```

### Database Config:

XOUser expects and assumes you have a valid database configuration under a top key named `db`.

### Database Tables:

XOUser expects two database tables named `users` and `session` for managing users and sessions respectively:

```sql
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `modifiedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`),
  KEY `idx_email` (`email`), 
  KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `users` (`id`, `email`, `username`, `password`, `modifiedAt`, `createdAt`) VALUES (1, 'admin@gmail.com', 'admin', '$2y$10$iMDN8kS81DAdHy9/zNd3we2ChPwhy2bTkVIsCyHpNtaNZl9zUuyxG', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `session` (
  `id` char(32) NOT NULL,
  `name` char(32) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

### Session Config:

If you want to set custom configuration for handling session, you should do that under top key `session_config`. If you do not already have a custom configuration for your session, put the following in `./config/module.config.php`:

```php
<?php
'session_config' => array(
  'name' => 'session_name',
  'use_cookies' => true,
  'cookie_lifetime' => 0,
  'gc_maxlifetime' => 3600,
),

```

### Usage:

Use the following snippet of code in your controller method to manage login action. For more information, you should check the `LoginController`'s `processAction` method. 

```php
<?php
$auth = $this->getAuthService()
  ->getAdapter()
  ->setIdentity($data['username'])
  ->setCredential($data['password'])
  ->setIdentityType('username'); // This can only be 'username' and 'email'

$result = $this->getAuthService()->authenticate();

if ($result->isValid()) {
  // Do something
} else {
  // Do something
} 

```

Next up, just use this over and over again where you need:

```php
<?php
if (!$this->getAuthService()->hasIdentity()) {
  return $this->redirect()->toRoute('auth');
}

```

Available Routes
----------------

```php
/auth 	
/auth/login
/auth/signup
/auth/change-password
/auth/logout

```

Go to your site: http://yoursite.dev/auth and you should see a login page.


Login
-----

```php
username: admin
password: 12345678

```

Password Hash Caution
---------------------

**DO NOT CHANGE THE PASSWORD HASH SETTINGS FROM THEIR DEFAULTS** unless you
have fully understood exactly what and why you are doing!

ZF2 Components
--------------

The following ZF2 components are considerably used in XOUser module:

* [Zend/Authentication](https://framework.zend.com/manual/2.4/en/modules/zend.authentication.intro.html)
* [Zend/Crypt](https://framework.zend.com/manual/2.4/en/modules/zend.crypt.introduction.html)
* [Zend/Db](https://framework.zend.com/manual/2.4/en/modules/zend.db.adapter.html)
* [Zend/Filter](https://framework.zend.com/manual/2.4/en/modules/zend.filter.html)
* [Zend/Form](https://framework.zend.com/manual/2.4/en/modules/zend.form.intro.html)
* [Zend/InputFilter](https://framework.zend.com/manual/2.4/en/modules/zend.input-filter.intro.html)
* [Zend/Json](https://framework.zend.com/manual/2.4/en/modules/zend.json.introduction.html)
* [Zend/ModuleManager](https://framework.zend.com/manual/2.4/en/modules/zend.module-manager.intro.html)
* [Zend/Mvc](https://framework.zend.com/manual/2.4/en/modules/zend.mvc.intro.html)
* [Zend/ServiceManager](https://framework.zend.com/manual/2.4/en/modules/zend.service-manager.html)
* [Zend/Session](https://framework.zend.com/manual/2.4/en/modules/zend.session.config.html)
* [Zend/Validator](https://framework.zend.com/manual/2.4/en/modules/zend.validator.html)
* [Zend/View](https://framework.zend.com/manual/2.4/en/modules/zend.view.quick-start.html)

License
-------

This ZF2 module released under MIT license.
