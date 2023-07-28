<?php 
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('addItem', new Route(constant('URL_SUBFOLDER') . '/addItem/{id}', array('controller' => 'ItemController', 'method'=>'addItem'), array('id')));
$routes->add('loadHome', new Route(constant('URL_SUBFOLDER') . '/', array('controller' => 'HomeController', 'method'=>'loadHome'), array()));
$routes->add('infoItem', new Route(constant('URL_SUBFOLDER') . '/infoItem/{id}', array('controller' => 'ItemController', 'method'=>'getInfoItem'), array('id')));
$routes->add('addCategory', new Route(constant('URL_SUBFOLDER') . '/addCatrgory', array('controller' => 'CategoryController', 'method'=>'addCategory'), array()));
$routes->add('infoCatrgory', new Route(constant('URL_SUBFOLDER') . '/infoCategory/{id}', array('controller' => 'CategoryController', 'method'=>'getInfoCategory'), array('id')));
