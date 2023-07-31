<?php 
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('loadAddItem', new Route(constant('URL_SUBFOLDER') . '/addItem/{id}', array('controller' => 'ItemController', 'method'=>'loadAddItem'), array('id')));
$routes->add('loadHome', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'HomeController', 'method'=>'loadHome'), array()));
$routes->add('loadInfoItem', new Route(constant('URL_SUBFOLDER') . '/loadInfoItem/{id}', array('controller' => 'ItemController', 'method'=>'loadInfoItem'), array('id')));
$routes->add('loadAddCategory', new Route(constant('URL_SUBFOLDER') . '/loadAddCatrgory', array('controller' => 'CategoryController', 'method'=>'loadAddCategory'), array()));
$routes->add('loadInfoCategory', new Route(constant('URL_SUBFOLDER') . '/loadInfoCategory/{id}', array('controller' => 'CategoryController', 'method'=>'loadInfoCategory'), array('id')));
