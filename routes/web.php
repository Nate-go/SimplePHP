<?php 
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('addItem', new Route(constant('URL_SUBFOLDER') . '/addItem/{id}', array('controller' => 'ItemController', 'method'=>'addItem'), array('id')));
$routes->add('home', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'HomeController', 'method'=>'loadHome'), array()));
$routes->add('deleteCategory', new Route(constant('URL_SUBFOLDER') . '/deleteCategory/{id}', array('controller' => 'CategoryController', 'method'=>'deleteCategory'), array('id')));
$routes->add('deleteItem', new Route(constant('URL_SUBFOLDER') . '/deleteItem/{id}', array('controller' => 'ItemController', 'method'=>'deleteItem'), array('id')));
$routes->add('getItem', new Route(constant('URL_SUBFOLDER') . '/getItem/{id}', array('controller' => 'ItemController', 'method'=>'getItem'), array('id')));